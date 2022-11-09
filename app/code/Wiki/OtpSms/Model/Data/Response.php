<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Model\Data;

use Wiki\OtpSms\Api\Data\ResponseInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

class Response extends AbstractExtensibleObject implements ResponseInterface
{
    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->_get('status');
    }

    /**
     * @inheritdoc
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->_get('message');
    }

    /**
     * @inheritdoc
     */
    public function setMessage($message)
    {
        return $this->setData('message', $message);
    }
}
