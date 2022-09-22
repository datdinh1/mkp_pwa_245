<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order;

class Cancel extends \Wiki\VendorsSales\Controller\Vendors\Order
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_order_action_cancel';

    /**
     * Cancel order
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $order = $this->_initOrder();
        if ($order) {
            $vendorOrder = $this->_coreRegistry->registry('vendor_order');
            try {
                $vendorOrder->cancel();
                $vendorOrder->save();
                $order->save();
                $this->messageManager->addSuccessMessage(__('You canceled the order.'));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('You have not canceled the item.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            }
            return $resultRedirect->setPath('sales/order/view', ['order_id' => $vendorOrder->getId()]);
        }
        return $resultRedirect->setPath('sales/*/');
    }
}
