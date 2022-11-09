/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'uiComponent',
    'jquery',
    'underscore',
    'mage/translate',
    'domReady!'
], function (Component, $, _, $t){
    'use strict';

    return Component.extend({
        defaults: {
            vendorId: '',
        },
        /**
         * Initialize
         */
        initialize: function () {
            this._super();
            this.observe({
                product_checked: [],
            })
        },

        selectAll: function () {
            if ($("#auction-select-all").is(":checked")) {
                $('.auction-product:not(:checked)').trigger('click');
            } else {
                $('.auction-product:checked').trigger('click');
            }
        }
    })
})
