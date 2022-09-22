<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Wiki\VendorsNotification\Model\NotificationFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var NotificationrFactory
     */
    protected $notificationrFactory;

    public function __construct(
        Context                     $context,
        JsonFactory                 $jsonFactory,
        NotificationFactory         $notificationFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory          = $jsonFactory;
        $this->notificationFactory  = $notificationFactory;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } 
            else {
                foreach (array_keys($postItems) as $modelId) {
                    $plan = $this->notificationFactory->create()->load($modelId);
                    try {
                        $plan->setData(array_merge($plan->getData(), $postItems[$modelId]));
                        $plan->save();
                    } 
                    catch (\Exception $e) {
                        $messages[] = "[Message ID: {$modelId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }
        
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}