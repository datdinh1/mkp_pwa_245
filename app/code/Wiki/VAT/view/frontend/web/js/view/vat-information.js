define(
    [
        'jquery',
        'ko',
        'underscore',
        'uiComponent',
        'Wiki_VAT/js/model/vat-data',
        'Wiki_VAT/js/model/vat-information',
        'jquery/ui',
        'jquery/jquery-ui-timepicker-addon'
    ],
    function ($, ko, _, Component, vatData, vatInformation) {
        'use strict';

        var cacheKeyvatNumber = 'vatNumber',
            cacheKeyIsRequireVat = 'vatRequire';

        function prepareSubscribeValue(object, cacheKey) {
            object(vatData.getData(cacheKey));
            object.subscribe(function (newValue) {
                vatData.setData(cacheKey, newValue);
            });
        }

        return Component.extend({
            defaults: {
                template: 'Wiki_VAT/container/vat-information'
            },
            vatNumber: vatInformation().vatNumber,

            initialize: function () {
                this._super();

                var self = this;

                prepareSubscribeValue(this.vatNumber, cacheKeyvatNumber);

                return this;
            },
            initObservable: function () {
                this._super()
                    .observe({
                        isRequireVatVisible: vatData.getData(cacheKeyIsRequireVat)
                    });

                this.isRequireVatVisible.subscribe(function (newValue) {
                    vatData.setData(cacheKeyIsRequireVat, newValue);
                });

                return this;
            },
        });
    }
);
