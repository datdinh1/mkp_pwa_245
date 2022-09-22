<?php

namespace Wiki\VendorsSalesRule\Controller\Adminhtml\Promo\Quote;

use Magento\Backend\App\Action\Context;

use Magento\Framework\View\Result\PageFactory;
use Wiki\SampleImageUploader\Model\UploaderPool;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;


use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\SalesRule\Controller\Adminhtml\Promo\Quote\Save
{
    const MARKETPLACE_CODE       = 'MARKETPLACE_CODE';
    const MARKETPLACE_SELLER     = 'MARKETPLACE_SELLER';

    protected $uploaderPool;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /** @var \Magento\SalesRule\Api\RuleRepositoryInterface $rule **/

    protected $rule;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        TimezoneInterface $timezone = null,
        DataPersistorInterface $dataPersistor = null,
        UploaderPool $uploaderPool,
        \Magento\SalesRule\Model\Rule $rule


    ) {

        parent::__construct($context, $coreRegistry, $fileFactory, $dateFilter);
        $this->timezone =  $timezone ?? \Magento\Framework\App\ObjectManager::getInstance()->get(
            TimezoneInterface::class
        );
        $this->dataPersistor = $dataPersistor ?? \Magento\Framework\App\ObjectManager::getInstance()->get(
            DataPersistorInterface::class
        );
        $this->uploaderPool = $uploaderPool;
        $this->rule = $rule;
    }


    public function execute()
    {
        //use to get image
        $dataPost = $this->getRequest()->getPostValue();

        //use to save data rule
        $data = $this->getRequest()->getPostValue();
        $this->messageManager->addSuccess('Message from new admin controller.');



        //imageFromBB   =
        if (!isset($dataPost['rule_id'])) {
            $image = $this->getUploader('image')->uploadFileAndGetName('image', $dataPost);

            $data['image'] = $image;
        } else {

            /** @var \Magento\SalesRule\Model\Rule $rule **/
            $ruleCol = $this->rule->load($dataPost['rule_id']);
            $imageUrlPost = isset($data['image']) ? ($data['image'][0]['url']) : '';

            if ($imageUrlPost) {
                $imageNamePost = explode('images/image', $imageUrlPost)[1];
                $imageFromBB = $ruleCol->getImage();

                if ($imageNamePost != $imageFromBB) {
                    $image = $this->getUploader('image')->uploadFileAndGetName('image', $dataPost);
                    $data['image'] = $image;
                    $this->deleteImage($imageFromBB);
                } else {
                    unset($data['image']);
                }
            }
            if (empty($imageUrlPost) && $ruleCol->getImage()) {
                $this->deleteImage($ruleCol->getImage());
                $data['image'] = null;
            }
        }

        if ($data) {
            try {
                /** @var $model \Magento\SalesRule\Model\Rule */
                $model = $this->_objectManager->create(\Magento\SalesRule\Model\Rule::class);
                $this->_eventManager->dispatch(
                    'adminhtml_controller_salesrule_prepare_save',
                    ['request' => $this->getRequest()]
                );
                if (empty($data['from_date'])) {
                    $data['from_date'] = $this->timezone->formatDate();
                }

                $filterValues = ['from_date' => $this->_dateFilter];
                if ($this->getRequest()->getParam('to_date')) {
                    $filterValues['to_date'] = $this->_dateFilter;
                }
                $inputFilter = new \Zend_Filter_Input(
                    $filterValues,
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                if (!$this->checkRuleExists($model)) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('The wrong rule is specified.'));
                }

                $session = $this->_objectManager->get(\Magento\Backend\Model\Session::class);

                $validateResult = $model->validateData(new \Magento\Framework\DataObject($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) {
                        $this->messageManager->addErrorMessage($errorMessage);
                    }
                    $session->setPageData($data);
                    $this->dataPersistor->set('sale_rule', $data);
                    $this->_redirect('sales_rule/*/edit', ['id' => $model->getId()]);
                    return;
                }

                if (
                    isset(
                        $data['simple_action']
                    ) && $data['simple_action'] == 'by_percent' && isset(
                        $data['discount_amount']
                    )
                ) {
                    $data['discount_amount'] = min(100, $data['discount_amount']);
                }
                if (isset($data['rule']['conditions'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                }
                if (isset($data['rule']['actions'])) {
                    $data['actions'] = $data['rule']['actions'];
                }
                if (isset($data['rule']['category_id'])) {
                    $data['category_id'] = $data['rule']['category_id'];
                }
                
                if(!empty($data['coupon_by_seller'])){
                    if ($data['coupon_by_seller'] == self::MARKETPLACE_SELLER || $data['coupon_by_seller'] == self::MARKETPLACE_SELLER) {
                        if (isset($data['actions'])) {
                            $data['coupon_by_seller'] = self::MARKETPLACE_CODE;
                            foreach ($data['actions'] as $action) {
                                if (isset($action['attribute']) && $action['attribute'] == "vendor_id") {
                                    $data['coupon_by_seller'] = self::MARKETPLACE_SELLER;
                                }
                            }
                        } else {
                            $data['coupon_by_seller'] = self::MARKETPLACE_CODE;
                        }
                    }
                } else {
                    $data['coupon_by_seller'] = self::MARKETPLACE_CODE;
                }
                
                unset($data['rule']);
                $model->loadPost($data);

                $useAutoGeneration = (int)(!empty($data['use_auto_generation']) && $data['use_auto_generation'] !== 'false');
                $model->setUseAutoGeneration($useAutoGeneration);

                $session->setPageData($model->getData());

                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the rule.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('sales_rule/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('sales_rule/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $id = (int)$this->getRequest()->getParam('rule_id');
                if (!empty($id)) {
                    $this->_redirect('sales_rule/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('sales_rule/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the rule data. Please review the error log.')
                );
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
                $this->_objectManager->get(\Magento\Backend\Model\Session::class)->setPageData($data);
                $this->_redirect('sales_rule/*/edit', ['id' => $this->getRequest()->getParam('rule_id')]);
                return;
            }
        }
        $this->_redirect('sales_rule/*/');
    }
    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
    /**
     * Check if Cart Price Rule with provided id exists.
     *
     * @param \Magento\SalesRule\Model\Rule $model
     * @return bool
     */
    private function checkRuleExists(\Magento\SalesRule\Model\Rule $model): bool
    {
        $id = $this->getRequest()->getParam('rule_id');
        if ($id) {
            $model->load($id);
            if ($model->getId() != $id) {
                return false;
            }
        }
        return true;
    }

    protected function deleteImage($image)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $file = $objectManager->get('Magento\Framework\Filesystem\Driver\File');
        $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
            ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $mediaRootDir = $mediaDirectory->getAbsolutePath();

        /*
         * sampleimageuploader/images/image
         * via Module SampleImageUploader
        */
        $mediaRootDir .= "sampleimageuploader/images/image";
        if ($image) {
            if ($file->isExists($mediaRootDir . $image)) {
                $file->deleteFile($mediaRootDir . $image);
            }
        }
    }
}
