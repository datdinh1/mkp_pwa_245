<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Api;
 
interface SmsManagementInterface 
{
    /**
     * @api
     * @param mixed $otp
     * @param mixed $phoneNumber
     * @return \Wiki\OtpSms\Api\Data\ResponseInterface
     * @throws \Exception
     */
    public function sendOTPToPhone($otp, $phoneNumber);

    /**
     * Create customer account. Perform necessary business operations like sending email.
     * @param \Wiki\OtpSms\Api\Data\CustomerOtpInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createAccountMobile($customer);

}
