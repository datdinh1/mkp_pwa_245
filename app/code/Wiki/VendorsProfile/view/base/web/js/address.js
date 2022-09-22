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
            tyuy: 'asdasd',
        },
        /**
         * Initialize
         */
        initialize: function () {
            this._super();
        },

        isDisplay: function (){
            return false;
        }
    })
})
