<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsSales\Block\Vendors\Order\Creditmemo;

class View extends \Wiki\Vendors\Block\Vendors\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Add & remove control buttons
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'creditmemo_id';
        $this->_controller = 'adminhtml_order_creditmemo';
        $this->_mode = 'view';

        parent::_construct();

        $this->buttonList->remove('save');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('delete');

        if (!$this->getCreditmemo()) {
            return;
        }

        if ($this->getCreditmemo()->canCancel()) {
            $this->buttonList->add(
                'cancel',
                [
                    'label' => __('Cancel'),
                    'class' => 'fa fa-minus-circle btn btn-lg btn-warning btn-cancel',
                    'onclick' => 'setLocation(\'' . $this->getCancelUrl() . '\')'
                ]
            );
        }

        /*if ($this->_isAllowedAction('Wiki_VendorsSales::sales_send_emails')) {
            $this->addButton(
                'send_notification',
                [
                    'label' => __('Send Email'),
                    'class' => 'fa fa-envelope-o btn btn-lg btn-default send-email',
                    'onclick' => 'confirmSetLocation(\'' . __(
                            'Are you sure you want to send a credit memo email to customer?'
                        ) . '\', \'' . $this->getEmailUrl() . '\')'
                ]
            );
        }*/

        if ($this->getCreditmemo()->canRefund()) {
            $this->buttonList->add(
                'refund',
                [
                    'label' => __('Refund'),
                    'class' => 'refund',
                    'onclick' => 'setLocation(\'' . $this->getRefundUrl() . '\')'
                ]
            );
        }

        if ($this->getCreditmemo()->canVoid()) {
            $this->buttonList->add(
                'void',
                [
                    'label' => __('Void'),
                    'class' => 'void',
                    'onclick' => 'setLocation(\'' . $this->getVoidUrl() . '\')'
                ]
            );
        }

        if ($this->getCreditmemo()->getId()) {
            $this->buttonList->add(
                'print',
                [
                    'label' => __('Print'),
                    'class' => 'fa fa-print btn btn-lg bg-olive print',
                    'onclick' => 'setLocation(\'' . $this->getPrintUrl() . '\')'
                ]
            );
        }
    }

    /**
     * Retrieve creditmemo model instance
     *
     * @return \Magento\Sales\Model\Order\Creditmemo
     */
    public function getCreditmemo()
    {
        return $this->_coreRegistry->registry('current_creditmemo');
    }

    /**
     * Retrieve text for header
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->getCreditmemo()->getEmailSent()) {
            $emailSent = __('The credit memo email was sent.');
        } else {
            $emailSent = __('The credit memo email wasn\'t sent.');
        }
        return __(
            'Credit Memo #%1 | %3 | %2 (%4)',
            $this->getCreditmemo()->getIncrementId(),
            $this->formatDate(
                $this->_localeDate->date(new \DateTime($this->getCreditmemo()->getCreatedAt())),
                \IntlDateFormatter::MEDIUM,
                true
            ),
            $this->getCreditmemo()->getStateName(),
            $emailSent
        );
    }

    /**
     * Retrieve back url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl(
            'sales/order/view',
            [
                'order_id' => $this->getCreditmemo() ? $this->getCreditmemo()->getVendorOrderId() : null,
                'active_tab' => 'order_creditmemos'
            ]
        );
    }

    /**
     * Retrieve capture url
     *
     * @return string
     */
    public function getCaptureUrl()
    {
        return $this->getUrl('sales/*/capture', ['creditmemo_id' => $this->getCreditmemo()->getId()]);
    }

    /**
     * Retrieve void url
     *
     * @return string
     */
    public function getVoidUrl()
    {
        return $this->getUrl('sales/*/void', ['creditmemo_id' => $this->getCreditmemo()->getId()]);
    }

    /**
     * Retrieve cancel url
     *
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->getUrl('sales/*/cancel', ['creditmemo_id' => $this->getCreditmemo()->getId()]);
    }

    /**
     * Retrieve email url
     *
     * @return string
     */
    public function getEmailUrl()
    {
        return $this->getUrl(
            'sales/creditmemo/email',
            [
                'creditmemo_id' => $this->getCreditmemo()->getId(),
                'order_id' => $this->getCreditmemo()->getOrderId()
            ]
        );
    }

    /**
     * Retrieve print url
     *
     * @return string
     */
    public function getPrintUrl()
    {
        return $this->getUrl('sales/creditmemo/print', ['creditmemo_id' => $this->getCreditmemo()->getId()]);
    }

    /**
     * Update 'back' button url
     *
     * @param bool $flag
     * @return \Magento\Backend\Block\Widget\Container|$this
     */
    public function updateBackButtonUrl($flag)
    {
        if ($flag) {
            if ($this->getCreditmemo()->getBackUrl()) {
                return $this->buttonList->update(
                    'back',
                    'onclick',
                    'setLocation(\'' . $this->getCreditmemo()->getBackUrl() . '\')'
                );
            }

            return $this->buttonList->update(
                'back',
                'onclick',
                'setLocation(\'' . $this->getUrl('sales/order_creditmemo/') . '\')'
            );
        }
        return $this;
    }

    /**
     * Check whether action is allowed
     *
     * @param string $resourceId
     * @return bool
     */
    public function _isAllowedAction($resourceId)
    {
        $permission = new \Wiki\Vendors\Model\AclResult();
        $this->_eventManager->dispatch(
            'ves_vendor_check_acl',
            [
                'resource' => $resourceId,
                'permission' => $permission
            ]
        );
        return $permission->isAllowed();
    }
}
