<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Api\Data;
 
interface ResponseInterface 
{
    /**
     * Get status
     * @return bool|null
     */
    public function getStatus();

    /**
     * Set status
     * @param bool $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get message
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
}
