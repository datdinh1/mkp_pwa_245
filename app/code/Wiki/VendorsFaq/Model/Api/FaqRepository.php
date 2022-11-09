<?php

namespace Wiki\VendorsFaq\Model\Api;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\AuthenticationException;
use Wiki\VendorsFaq\Api\FaqRepositoryInterface;


/**
 * 
 */
class FaqRepository implements FaqRepositoryInterface
{

    protected $faqFactory;
    protected $faqDetailFactory;
    public function __construct(
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Customer\Model\Customer $customerModel,
        \Wiki\VendorsFaq\Model\FaqFactory $faqFactory,
        \Wiki\VendorsFaq\Model\Api\Data\FaqDetailFactory $faqDetailFactory
    ){
        $this->_vendorsModel         = $vendorsModel;
        $this->_customerModel        = $customerModel;
        $this->faqFactory            = $faqFactory;
        $this->faqDetailFactory      = $faqDetailFactory;
    }
    
    /**
     * @inheritdoc
     */
    public function saveFaq($entity)
    {
        $listDetail = $entity->getListDetail();
        $entity->save();
        $idFaq = $entity->getId();
        foreach ($listDetail as $detail) {

            $detail->setFaqId($idFaq);
            $detail->save();
        }
        return $entity;
    }

     /**
     * @inheritdoc
     */
    public function getFaqByVendorId($vendorID)
    {
        try {
            $vendor = $this->_vendorsModel->loadByIdentifier($vendorID);
            $id = $vendor->getId();
            $customer = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->_vendorsModel->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return null;
            } else {
                $faq = $this->faqFactory->create();
                $faqCollection = $faq->getCollection()->addFieldToFilter('vendor_id', ['eq' => $vendorID]);
                foreach($faqCollection as $faqData){
                    $faqDeatail = $this->faqDetailFactory->create();
                    $idFaq = $faqData->getId();
                    $faqDetailCollection = $faqDeatail->getCollection()->addFieldToFilter('faq_id', ['eq' => $faqData->getId()]);
                    $listDetail = [];
                    foreach($faqDetailCollection as $faqDetailData){
                        $listDetail[] =$faqDetailData;
                    }
                    $faqData->setListDetail($listDetail);
                    $result[] = $faqData;
                }
                return $result;
            }
        } catch (AuthenticationException $e) {
            $faq = $this->faqFactory->create();
            return null;
        }
    }

    public function deleteFaq($idFaq){
        $faq = $this->faqFactory->create();
        $faqModel = $faq->load($idFaq);
        if($faqModel){
            $id = $faqModel->getId();
            
            $faqDeatail = $this->faqDetailFactory->create();
            $faqDetailModel = $faqDeatail->getCollection()->addFieldToFilter('faq_id', ['eq' => $id]);
            if($faqDetailModel){
                foreach($faqDetailModel as $faqDetail){
                    $faqDetail->delete();
                }
            }
           
            $faqModel->delete();
            return true;
        }
        return false;
    }
    
}
