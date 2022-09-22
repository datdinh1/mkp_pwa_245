<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Constant config
     */
    const MODULE_ENABLE = 'wkotpsms/general/enable';

    public function debug($data)
    {
		$writer = new \Zend\Log\Writer\Stream(BP .'/var/log/otpsms.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($data);
	}

    public function isEnableModule()
    {
        return $this->scopeConfig->getValue(
            self::MODULE_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getSmsConfig($field)
    {
        return $this->scopeConfig->getValue(
            'wkotpsms/connection/'. $field,
            ScopeInterface::SCOPE_STORE
        ); 
    }

    public function sendSmsMessage($otp, $phoneNumber)
    {
        $url = $this->getSmsConfig('url_sms');
        $sender = $this->getSmsConfig('sender');
        $service = $this->getSmsConfig('service');
        $content = $this->getSmsConfig('content_sms');

        $status = false;
        if ($service == 'smsmkt') {
            $postBody = json_encode(['sender' => $sender, 'phone' => $phoneNumber, 'message' => sprintf($content, $otp)]);
            $response = $this->sendSmsMKT($url, $postBody);
            if ($response['status']) {
                $status = true;
            }
            else {
                $details = "ERROR: HTTP status ". $response['http_status_code'] .", API status: ". $response['api_status_code'] .", API message: ". $response['api_message'] .", Full details: ". $response['details'];
                if ($response['transient_error']) {
                    $details .= 'This is a transient error - you should retry it in a production environment';
                }
                $this->debug($details);
            }
        }
        return $status;
    }

    public function sendSmsMKT($url, $postBody)
    {
        $apiKey = $this->getSmsConfig('api_key');
        $secretKey = $this->getSmsConfig('secret_key');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json",
            "api_key:$apiKey",
            "secret_key:$secretKey",
        ]);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        $response = [
            'status' => false,
            'details' => '',
            'api_message' => '',
            'api_batch_id' => '',
            'api_status_code' => '',
            'transient_error' => 0,
            'http_status_code' => $info['http_code'],
        ];

        if ($result == false) {
            $response['details'] .= "CURL error: ". curl_error($ch) ."\n";
        }
        elseif ($info['http_code'] != 200) {
            $response['transient_error'] = 1;
            $response['details'] .= "Error: non-200 HTTP status code: ". $info['http_code'] ."\n";
        }
        else {
            $apiResult = json_decode($result);
            $statusCode = $apiResult->code;
            $response['api_status_code'] = $statusCode;
            $response['api_message'] = $apiResult->detail;
            $response['details'] .= "Response from server: $result\n";

            if ($statusCode == '000') {
                $response['status'] = true;
                $response['api_batch_id'] = $apiResult->result->transaction_id;
                $response['details'] .= "Message sent - Batch ID\n";
            }
            elseif ($statusCode == '1') {
                $response['status'] = true;
                $response['api_batch_id'] = $apiResult[2];
            }
            else {
                $response['details'] .= "Error sending: status code [$apiResult->code] description [$apiResult->detail]\n";
            }
        }
        curl_close($ch);
        return $response;
    }
}
