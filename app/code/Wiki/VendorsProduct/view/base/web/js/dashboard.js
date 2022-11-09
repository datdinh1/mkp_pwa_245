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
                showSideBar: false,
                countChecked: 0
            })
        },

        toggleAction: function () {
            $('.a-action').toggleClass('a-dropdown--active');
        },

        showSelectAll: function () {
            return $(".select_product:checked").length > 0;
        },

        changeSelect: function () {
            if ($('.select_product:checked').length > 0) {
                this.showSideBar(true)
                this.countChecked($('.select_product:checked').length)
            } else {
                this.showSideBar(false)
                this.countChecked(0)
            }
        },

        selectAll: function (){
            if ($("#auction-select-all").is(":checked")) {
                $('.select_product').prop('checked', true);
                this.countChecked($('.select_product:checked').length)
            } else {
                $('.select_product').prop('checked', false);
                this.countChecked(0);
                this.showSideBar(false);
            }
        }
    })
})
