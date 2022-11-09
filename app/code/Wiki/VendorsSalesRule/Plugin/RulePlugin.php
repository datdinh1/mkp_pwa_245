<?php
namespace Wiki\VendorsSalesRule\Plugin;

use Magento\SalesRule\Model\Rule;
use Wiki\VendorsSalesRule\Model\VarcharCode;

class RulePlugin
{
    /**
     * @var VarcharCode
     */
    protected $varcharCode;

    public function __construct(
        VarcharCode           $varcharCode
    ) {
        $this->varcharCode    = $varcharCode;
    }

    /**
     * Custom: add auto generate coupon code
     * 
     * @var \Magento\SalesRule\Model\Rule
     * @return $this
     */
    public function afterAfterSave(Rule $subject, $result)
    {
        $varcharCode = $this->varcharCode->_getLastItem();
        if ( !$varcharCode->getId() ){
            $varcharCode = $this->varcharCode->setAutoGenerate('A0001')->save();
        }

        $primaryCoupon = $result->getPrimaryCoupon();
        if ( $result->getCouponType() == Rule::COUPON_TYPE_SPECIFIC ){
            $couponCode = $primaryCoupon->getCode();
            $couponGenerate = $autoGenerate = $primaryCoupon->getAutoGenerate();

            /** set data auto generate */
            if ( !$couponGenerate ){
                $autoGenerate = $varcharCode->getAutoGenerate();
                $autoGenerate++;
                $varcharCode->setAutoGenerate($autoGenerate)->save();
                $primaryCoupon->setAutoGenerate($autoGenerate);
            }

            if ( strpos($couponCode, $autoGenerate) !== 0 || !$couponGenerate ){
                $couponCode = $autoGenerate . $couponCode;
            }

            $primaryCoupon->setCode($couponCode)->save();
        }

        return $result;
    }
}
