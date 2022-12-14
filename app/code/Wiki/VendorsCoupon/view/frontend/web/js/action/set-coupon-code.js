/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Customer store credit(balance) application
 */
/*global define,alert*/
define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/model/quote',
        'Wiki_VendorsCoupon/js/model/resource-url-manager',
        'Magento_Checkout/js/model/error-processor',
        'Magento_SalesRule/js/model/payment/discount-messages',
        'Wiki_VendorsCoupon/js/model/discount',
        'mage/storage',
        'mage/translate',
        'Magento_Checkout/js/action/get-payment-information',
        'Wiki_VendorsCoupon/js/action/get-discount-detail',
        'Magento_Checkout/js/model/totals',
        'Magento_Checkout/js/model/full-screen-loader'
    ],
    function (
        ko, $, quote, urlManager, errorProcessor, messageContainer, discountModel, storage, $t, getPaymentInformationAction,getDiscountDetail, totals,
        fullScreenLoader
    ) {
        'use strict';

        return function (couponCode) {
            var quoteId = quote.getQuoteId(),
                url = urlManager.getApplyCouponUrl(couponCode, quoteId),
                message = $t('Your coupon was successfully applied.');

            fullScreenLoader.startLoader();

            return storage.put(
                url,
                {},
                false
            ).done(
                function (response) {
                    if (response) {
                        var deferred = $.Deferred();
                        
                        getDiscountDetail();
                        
                        totals.isLoading(true);
                        getPaymentInformationAction(deferred);
                        $.when(deferred).done(function () {
                            fullScreenLoader.stopLoader();
                            totals.isLoading(false);
                        });
                        messageContainer.addSuccessMessage({
                            'message': message
                        });
                    }
                }
            ).fail(
                function (response) {
                    fullScreenLoader.stopLoader();
                    totals.isLoading(false);
                    errorProcessor.process(response, messageContainer);
                }
            );
        };
    }
);
