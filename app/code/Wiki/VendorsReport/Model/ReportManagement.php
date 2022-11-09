<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsReport\Model;

use Wiki\VendorsReport\Api\ProductSellerManagementInterface;
/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class ReportManagement implements ProductSellerManagementInterface
{

    protected $_urlInterface;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Framework\UrlInterface $urlInterface

        

    ) {
        $this->_scopeConfig                 = $scopeConfig;
        $this->_vendorsModel                = $vendorsModel;
        $this->_customerModel               = $customerModel;
        $this->_urlInterface                = $urlInterface;


    }


    /**
     * @inheritdoc
     */
    public function getConversionRateByMonth($namestore, $month){

        if( $month > 12 || $month < 1){
            return "The month invalid.";
        }
        try {
            $vendor                 = $this->_vendorsModel->loadByIdentifier($namestore);
            $id                     = $vendor->getId();
            $customer               = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);


            if(count($customerVendor->getData()) == 0){
                return "This is not account Seller";
            } else{
                $objectManager      = \Magento\Framework\App\ObjectManager::getInstance();
                $connection         = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');        
                $listViewAllByAddToCart = $connection->fetchAll("SELECT * FROM `wiki_report_conversion_rate` WHERE vendor_id=$id AND MONTH(update_at) = $month LIMIT 1");
                return $listViewAllByAddToCart;

            }
        }catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }
            
    

}
