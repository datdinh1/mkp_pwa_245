<?php
namespace Wiki\VendorsNotification\Block\Adminhtml\News\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Wiki\VendorsNotification\Ui\Component\Listing\ObjectUsers;

class Info extends Generic implements TabInterface
{
    /**
     * @var Config
     */
    protected $wysiwygConfig;

    /**
     * @var ObjectUsers
     */
    protected $objectUsers;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $newsStatus
     * @param array $data
     */
    public function __construct(
        Context                     $context,
        Registry                    $registry,
        FormFactory                 $formFactory,
        Config                      $wysiwygConfig,
        ObjectUsers                 $objectUsers,
        array                       $data = []
    ) {
        $this->wysiwygConfig        = $wysiwygConfig;
        $this->objectUsers          = $objectUsers;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('wiki_notification');
        $data = $model->getData();
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $this->setForm($form);

        $form->setFieldNameSuffix('params');
        $fieldset = $form->addFieldset('edit_fieldset', [
            'legend' => __('General Information'),
        ]);

        if ( $model->getId() ){
            $fieldset->addField(
                'notification_id',
                'hidden',
                [
                    'name'      => 'id',
                    'value'     => $model->getId(),
                ]
            );
        }

        $fieldset->addField(
            'message',
            'text',
            [
                'name'          => 'message',
                'label'         => __('Title'),
                'value'         => $model->getMessage(),
                'required'      => true
            ]
        );

        $fieldset->addField(
            'content',
            'editor',
            [
                'name'          => 'content',
                'label'         => __('Description'),
                'value'         => $model->getContent(),
                'config'        => $this->wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            'image',
            'image',
            [
                'name'          => 'image',
                'label'         => __('Image'),
                'title'         => __('Image'),
                'value'         => $model->getImage(),
                'note'          => 'Allow image type: jpg, jpeg, png'
            ]
        );

        $fieldset->addField(
            'notification_of',
            'select',
            [
                'name'          => 'notification_of',
                'label'         => __('Object User'),
                'value'         => $model->getNotificationOf(),
                'values'        => $this->objectUsers->toArray(),
            ]
        );      

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     * @return string
     */
    public function getTabLabel()
    {
        return __('News Info');
    }
 
    /**
     * Prepare title for tab
     * @return string
     */
    public function getTabTitle()
    {
        return __('News Info');
    }
 
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
 
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}