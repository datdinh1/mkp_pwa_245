<?php

namespace Wiki\SmsNotification\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\SmsNotification\Model\NewsFactory;



class CustomerLogin implements ObserverInterface
{

  /**
   * @var \Wiki\VendorsNotification\Model\NotificationFactory
   */
  protected $_notificationFactory;

  /**
   * News model factory
   *
   * @var \Wiki\SmsNotification\Model\NewsFactory
   */
  protected $_newsFactory;



  public function __construct(
    \Wiki\VendorsNotification\Model\NotificationFactory $notificationFactory,
    NewsFactory $newsFactory

  ) {

    $this->_notificationFactory = $notificationFactory;
    $this->_newsFactory = $newsFactory;
  }

  public function execute(\Magento\Framework\Event\Observer $observer)
  {

    $customer = $observer->getEvent()->getCustomer();
    $customer_id =  $customer->getId(); //Get customer name
    //  exit;
    //  /**list notfication of customer */
    //  $notification = $this->_notificationFactory->create()->getCollection();
    //  $listNoti = $notification->addFieldToFilter('customer_id', $customer_id)

    //  ->addFieldToFilter('noti_admin_id', array('neq' => 0))
    //  ->addFieldToSelect('noti_admin_id')->getColumnValues('noti_admin_id');
    $notification = $this->_notificationFactory->create();
    $listNoti = $notification->getCollection()->addFieldToFilter('customer_id', $customer_id)

      ->addFieldToFilter('noti_admin_id', array('neq' => 0))
      ->addFieldToSelect('noti_admin_id')->getColumnValues('noti_admin_id');


    /** list notification of admin */
    $notiAdmin = $this->_newsFactory->create();

    $listNotiAdmin = $notiAdmin->getCollection()->addFieldToFilter('status', 1)
      ->addFieldToFilter('obj_user', [['eq' => [0]], ['eq' => [2]]])
      ->addFieldToSelect('id')->getColumnValues('id');

    /** list notification of admin */
    $notiAdmin = $this->_newsFactory->create()->getCollection();

    // $listNotiAdmin = $notiAdmin->addFieldToFilter('status', 1)
    //   ->addFieldToFilter('obj_user', [['eq' => [0]], ['eq' => [2]]])
    //   ->addFieldToSelect('id')->getColumnValues('id');

    // foreach ($listNotiAdmin as $adminNoti) {
    //   if (in_array($adminNoti, $listNoti)) {
    //     // echo "Tên có thể sử dụng ".$adminNoti."<br>";
    //     $notification->addData([
    //       'vendor_id' => 1,
    //       "noti_admin_id" => $adminNoti,
    //       "customer_id" => $customer_id,
    //     ]);
    //     $notificationSave = $notification->save();
    //   }
    // }
  }
}
