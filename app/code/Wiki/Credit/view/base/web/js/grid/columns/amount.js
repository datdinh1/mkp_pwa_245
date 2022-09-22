/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'underscore',
    'Magento_Ui/js/grid/columns/column'
], function (_, Column) {
    'use strict';

    return Column.extend({
    	defaults: {
	    	headerTmpl: 'Wiki_Credit/grid/columns/text',
	        bodyTmpl: 'Wiki_Credit/grid/cells/text',
    	},
    	/**
         * Initializes column component.
         *
         * @returns {Column} Chainable.
         */
        initialize: function () {
            this._super();
            return this;
        },
        getAmountClass: function(record){
        	var value = record[this.index];
        	return (value.indexOf("-") >=0)?'amount-subtract':'amount-add';
        }
    });
});
