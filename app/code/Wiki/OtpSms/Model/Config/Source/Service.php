<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Model\Config\Source;

class Service implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
	{		
	    return [ 
			['value' => 'smsmkt', 'label' => __('SMS Marketing')],
        ];
	}
}
