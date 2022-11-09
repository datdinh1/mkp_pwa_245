<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model;

use Magento\Integration\Model\Oauth\TokenFactory;

use Wiki\VendorsChat\Api\ChatManagementInterface;
use Wiki\VendorsChat\Model\ChatRoomFactory;
use Wiki\VendorsChat\Model\ChatActionFactory;
use Wiki\VendorsChat\Model\ResourceModel\ChatRoom\CollectionFactory;
use Wiki\Vendors\Api\SellerManagementInterface;
use Wiki\VendorsChat\Model\Api\InfoRoomFactory;
use Wiki\Vendors\Model\Api\GeneralFactory;
use Wiki\Vendors\Model\VendorFactory;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Wiki\VendorsChat\Model\Api\RoomFactory;
use Wiki\VendorsChat\Model\Api\MessageFactory;
use Wiki\Vendors\Model\Api\SellerFactory;
use Wiki\VendorsChat\Model\ChatImageFactory;

use Wiki\VendorsChat\Helper\Data;
use Wiki\VendorsChat\Model\Api\BodyContentFactory;
use Wiki\VendorsChat\Model\Api\DataRoomItemsFactory;
use Wiki\VendorsChat\Model\Api\DataMessageItemsFactory;

class ChatManagement implements ChatManagementInterface
{
    protected $roomFactory;
    protected $customerRepoInterface;
    protected $chatRoomFactory;
    protected $chatActionFactory;
    protected $collectionFactory;
    protected $sellerInterface;
    protected $inforRoomFactory;
    protected $generalFactory;
    protected $messageFactory;
    protected $sellerFactory;

    protected $dataHelper;
    protected $bodyContent;

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /** 
     * @var TokenFactory
     */
    protected $tokenFactory;

    /**
     * @var DataRoomItemsFactory
     */
    protected $dataRoomItemsFactory;

    /**
     * @var DataMessageItemsFactory
     */
    protected $dataMessageItemsFactory;

    public function __construct(
        Data $dataHelper,
        BodyContentFactory $bodyContent,
        SellerFactory $sellerFactory,
        RoomFactory $roomFactory,
        CustomerRepositoryInterface $customerRepoInterface,
        GeneralFactory $generalFactory,
        InfoRoomFactory $inforRoomFactory,
        SellerManagementInterface $sellerInterface,
        ChatRoomFactory $chatRoomFactory,
        CollectionFactory $collectionFactory,
        ChatActionFactory $chatActionFactory,
        MessageFactory $messageFactory,
        ChatImageFactory $chatImageFactory,
        VendorFactory $vendorFactory,
        TokenFactory $tokenFactory,
        DataRoomItemsFactory $dataRoomItemsFactory,
        DataMessageItemsFactory $dataMessageItemsFactory
    ) {
        $this->bodyContent                  = $bodyContent;
        $this->dataHelper                   = $dataHelper;
        $this->sellerFactory                = $sellerFactory;
        $this->customerRepoInterface        = $customerRepoInterface;
        $this->customerRepoInterface        = $customerRepoInterface;
        $this->roomFactory                  = $roomFactory;
        $this->generalFactory               = $generalFactory;
        $this->inforRoomFactory             = $inforRoomFactory;
        $this->sellerInterface              = $sellerInterface;
        $this->chatRoomFactory              = $chatRoomFactory;
        $this->collectionFactory            = $collectionFactory;
        $this->chatActionFactory            = $chatActionFactory;
        $this->messageFactory               = $messageFactory;
        $this->chatImageFactory             = $chatImageFactory;
        $this->vendorFactory                = $vendorFactory;
        $this->tokenFactory                 = $tokenFactory;
        $this->dataRoomItemsFactory         = $dataRoomItemsFactory;
        $this->dataMessageItemsFactory      = $dataMessageItemsFactory;
    }

    /**
     * @param Wiki\VendorsChat\Api\Data\ChatInterface $message
     * @return bool
     */
    public function createConversation($message)
    {
        $this->_verify($message);
        $firstMessage = false;
        $chatRoom = $this->chatRoomFactory->create()->getCollection()
                    ->addFieldToFilter('customer_id', $message->getCustomerId())
                    ->addFieldToFilter('vendor_id', $message->getVendorId())->getLastItem();
        if ( !$chatRoom->getId() ){
            $chatRoom->setData($message->getData())->save();
            $firstMessage = true;
        }
        
        $chatAction = $this->chatActionFactory->create();
        $chatAction->setData([
            "chat_id" => $chatRoom->getId(),
            "message" => $message->getMessage(),
            "sender_id" => ($message->getSenderType() == 'B') ? $message->getCustomerId() : $message->getVendorId(),
            "sender_type" => $message->getSenderType(),
            "from_system" => !empty($message->getFromSystem()) ?  $message->getFromSystem() : false
        ])->save();
        
        if ( $message->getImages() ){
            foreach ( $message->getImages() as $image ){
                if ( $this->dataHelper->checkExitsImage($image) ){
                    $chatAction = $this->chatActionFactory->create();
                    $chatAction->setData([
                        "chat_id" => $chatRoom->getId(),
                        "message" => null,
                        "sender_id" => ($message->getSenderType() == 'B') ? $message->getCustomerId() : $message->getVendorId(),
                        "sender_type" => $message->getSenderType(),
                        "from_system" => !empty($message->getFromSystem()) ?  $message->getFromSystem() : false
                    ])->save();

                    try {
                        $this->chatImageFactory->create()->setActionId($chatAction->getId())->setImage($image)->save();
                    }
                    catch ( \Exception $e ){
                        throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()));
                    }
                }
                else {
                    throw new \Magento\Framework\Webapi\Exception(__("Image does not exist"));
                }
            }
        }

        $message = [
            'vendor_id' => $message->getVendorId(),
            'customer_id' => $message->getCustomerId(),
            'message' => $message->getMessage(),
            'images' => isset($images) ? $images : null,
            'sender_type' => $message->getSenderType(),
            "from_system" => $message->getFromSystem(),
            'created_at' => $chatAction->load($chatAction->getId())->getCreatedAt()
        ];
        $sendMessageByPusher = $this->dataHelper->useChatPusher($chatRoom->getId(), $message, 'chat');

        /** update is read chat room */
        $chatRoom->setIsRead(false)->save();
        $this->dataHelper->useChatPusher($chatRoom->getId(), true, 'is_read');
        if (!$sendMessageByPusher) return false;

        if($firstMessage){
            $reload = $this->dataHelper->sendReloadChat($message['customer_id'],$message['vendor_id']);
            if (!$reload) return false;
        } 
       
        return true;
    }

    /**
     * @param string[] $base64Image
     * @return string[]
     */
    public function uploadImage($base64Image)
    {
        $images = [];
        foreach ( $base64Image as $image ){
            $image = $this->dataHelper->uploadImage($image);
            if ( $image === false ){
                /** rollback when error */
                foreach ( $images as $deleteImage ){
                    $this->dataHelper->deleteImageByFilePath($deleteImage, '');
                }
                throw new \Magento\Framework\Webapi\Exception(__("The image MIME type is not valid or not supported."));
            }
            $images[] = $image;
        }

        return $images;
    }

    public function getListRoomById($id, $senderType, $pageSize = null, $currentPage = null)
    {
        $collection = $this->chatRoomFactory->create()->getCollection();
        $collection->addFieldToFilter(($senderType == 'B') ? 'customer_id' : 'vendor_id', $id);
        // count total room
        $totalCount = $collection->getSize();
        // sort page size
        $pageSize = $pageSize ?: 10;
        $collection->setPageSize($pageSize)->setCurPage($currentPage)->setOrder('chat_id', 'DESC');
        
        $items = [];
        $temp['vendor'] = [];
        $temp['customer'] = [];
        foreach ( $collection->getItems() as $item ){
            if ( !array_key_exists($item->getVendorId(), $temp['vendor']) ){
                $vendor =  $this->sellerInterface->getDataAccount($item->getVendorId())[0];
                $infoSeller = $this->sellerFactory->create();
                $infoSeller->setData($vendor)->setGeneral($this->generalFactory->create()->setData($vendor['general']));
                $temp['vendor'][$item->getVendorId()] = $infoSeller;
            }
            else {
                $infoSeller = $temp['vendor'][$item->getVendorId()];
            }
            if ( !array_key_exists($item->getCustomerId(), $temp['customer']) ){
                $customer = $this->customerRepoInterface->getById($item->getCustomerId());
                $temp['customer'][$item->getCustomerId()] = $customer;
            }
            else {
                $customer = $temp['customer'][$item->getCustomerId()];
            }

            $items[] = $this->inforRoomFactory->create()
                        ->setBuyer($customer)->setSeller($infoSeller)
                        ->setRoom($this->roomFactory->create()->setData($item->getData()));
        }
        return $this->dataRoomItemsFactory->create()->setItems($items)->setTotalCount($totalCount);
    }

    /**
     * @param int $customerId
     * @param string $vendorId
     * @param string $token
     */
    public function getMessage($customerId, $vendorId, $token, $type, $pageSize = null, $currentPage = null)
    {
        try {
            $exitsToken = $this->_getToken($token);
            if($type == 'B'){
                if ( $exitsToken->getCustomerId() != $customerId){
                    throw new \Magento\Framework\Webapi\Exception(
                        __("The oAuth consumer account couldn't be loaded. Please try again later.")
                    );
                }
            } else {
                $vendor = $this->vendorFactory->create()->loadByVendorId($vendorId);
                $userVendorId = $vendor->getCustomer()->getId();

                if ( $exitsToken->getCustomerId() != $userVendorId){
                    throw new \Magento\Framework\Webapi\Exception(
                        __("The oAuth consumer account couldn't be loaded. Please try again later.")
                    );
                }
            }
        }
        catch ( \Exception $e ){
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }

        $chatRoom = $this->chatRoomFactory->create()->getCollection()
                    ->addFieldToFilter('customer_id', $customerId)
                    ->addFieldToFilter('vendor_id', $vendorId)->getLastItem();
        $totalCount = 0;
        $items = [];
        if ($chatId = $chatRoom->getId()){
            $collection = $this->chatActionFactory->create()->getCollection()->addFieldToFilter('chat_id', $chatId);
            $collection->getSelect()->joinLeft(
                array('chat_image' => 'wk_chat_message_image'),
                'main_table.action_id = chat_image.action_id',
                array('chat_image.image')
            );
            // count total room
            $totalCount = $collection->getSize();
            // sort page size
            $pageSize = $pageSize ?: 10;
            $collection->setPageSize($pageSize)->setCurPage($currentPage)->setOrder('action_id', 'DESC');
            foreach ( $collection->getItems() as $item ){
                $items[] = $this->messageFactory->create()->setData($item->getData());
            }
            /** update is read chat room */
            $chatRoom->setIsRead(true)->save();
        }

        return $this->dataMessageItemsFactory->create()->setItems(array_reverse($items))->setTotalCount($totalCount);
    }

    public function getChatImage($action_id)
    {
        $result = [];
        $modelChatImage = $this->chatImageFactory->create();
        $collection =  $modelChatImage->getCollection()
            ->addFieldToFilter('action_id', $action_id);
        foreach ($collection as $image) {
            $result[] = $image['image'];
        }
        return $result;
    }

    public function getActionById($id)
    {
        $modelChatAction = $this->chatActionFactory->create();
        $collection =  $modelChatAction->getCollection();
        $getCollectionFilter = $collection->addFieldToFilter('action_id', $id)->getFirstItem();

        $messageFactory = $this->messageFactory->create();
        $dataAction =  $messageFactory->setData($getCollectionFilter->getData());

        $data['msg_id'] =  $dataAction->getMsgId();
        $data['room_id'] = $dataAction->getRoomId();
        $data['body'] = $dataAction;
        $data['sender_id'] = $dataAction->getSenderId();
        $data['sender_type'] = $dataAction->getSenderType();
        $data['from_system'] = $dataAction->getFromSystem();
        $data['created_at'] = $dataAction->getCreatedAt();
        return $data;
    }

    public function deleteRoom($roomId, $id, $token, $senderType)
    {
        $id = ($senderType == 'S') ? $this->vendorFactory->create()->loadByVendorId($id)->getCustomer()->getId() : $id;
        $exitsToken = $this->_getToken($token);
        if ( $exitsToken->getCustomerId() != $id ){
            throw new \Magento\Framework\Webapi\Exception(
                __("The oAuth consumer account couldn't be loaded. Please try again later.")
            );
        }

        $collection = $this->chatImageFactory->create()->getCollection();
        $collection->addFieldToSelect('image')->addFieldToFilter('chat_room.chat_id', $roomId);
        $collection->getSelect()->join(
            array('chat_room_action' => 'wk_chat_room_action'),
            'main_table.action_id = chat_room_action.action_id'
        )->join(
            array('chat_room' => 'wk_chat_room'),
            'chat_room_action.chat_id = chat_room.chat_id'
        );
        $images = $collection->getColumnValues('image');

        try {
            // delete Chat Room
            $this->chatRoomFactory->create()->load($roomId)->delete();
            // delete Images from Chat Room
            foreach ( $images as $image ){
                $this->dataHelper->deleteImageByFilePath($image, '');
            }
        }
        catch ( \Exception $e ){
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }

        return true;
    }

    protected function _getToken($token)
    {
        if ( !strlen($token) == \Magento\Framework\Oauth\Helper\Oauth::LENGTH_TOKEN ){
            throw new \Magento\Framework\Webapi\Exception(
                __('The token length is invalid. Check the length and try again.')
            );
        }

        $tokenObj = $this->tokenFactory->create()->load($token, 'token');
        if ( !$tokenObj->getId() ){
            throw new \Magento\Framework\Webapi\Exception(
                __('Specified token does not exist')
            );
        }

        return $tokenObj;
    }

    protected function _verify($message)
    {
        try {
            /** check exits customer and vendor */
            $customer = $this->customerRepoInterface->getById($message->getCustomerId());
            if ( !$customer->getId() ){
                throw new \Magento\Framework\Webapi\Exception(__("Customer does not exist."));
            }

            $vendor = $this->vendorFactory->create()->loadByVendorId($message->getVendorId());
            if ( !$vendor->getId() ){
                throw new \Magento\Framework\Webapi\Exception(__("Seller does not exist."));
            }
            
            /** check dup customer */
            if ( $message->getCustomerId() == $vendor->getCustomer()->getId() ){
                throw new \Magento\Framework\Webapi\Exception(__("You can not talk to yourself."));
            }
        }
        catch ( \Exception $e ){
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()));
        }
    }
}
