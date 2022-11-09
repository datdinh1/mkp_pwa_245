/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'jquery',
    'underscore',
    'mage/translate',
    'Magento_Ui/js/lib/validation/validator',
    'jquery/file-uploader',
    'domReady!'
], function (Component, $, _, $t, validator) {
    'use strict';

    $(document).on('keyup',function(evt) {
        if (evt.keyCode === 27 && $('.a-explorer').hasClass('_active')) {
            $('.a-explorer').removeClass('_active');
        }
    });

    return Component.extend({
        defaults: {
            vendorId: '',
            allowedExtensions: false,
            maxFileSize: false,
            isFirstItem: true,
            isFirstChecked: true,
            today: new Date().toISOString().slice(0, 10),
            modal: '.a-modal'
        },

        /**
         * Initialize
         */
        initialize: function () {
            this._super();
            this.observe({
                uploadFiles: {}, // Product image upload
                brandFiles: {}, // Brand image upload
                brandImg: '', // Brand image
                p_name: 0, // Product name
                p_sku: 0, // Product SKU
                p_des: 0, // Product description
                p_condition: '', // Product condition
                p_typeGender: '', // Product sex
                p_typeAge: '', // Product age
                p_startPrice: 0, // Product price
                p_miniumBid: 0, // Product quantity
                p_weight: 0, // Product quantity
                b_name: 0, // Brand name
                selectBrand: '', // Get selected brand
                preorder: false,
                product_prepare: '1',
                preorder_type: 'full',
                shipping_time: '',
                shipping_date: '',
                shipping_method: [],
                imageDefault: '',
                modalBtn: false,
                imageSelect: '',
                buyItNow: false,
                reverse: false
            })
        },

        isExtensionAllowed: function (file) {
            return validator('validate-file-type', file.name, this.allowedExtensions);
        },

        isSizeExceeded: function (file) {
            return validator('validate-max-size', file.size, this.maxFileSize);
        },

        isFileAllowed: function (file) {
            let result;

            _.every([this.isExtensionAllowed(file), this.isSizeExceeded(file)], function (value) {
                result = value;

                return value.passed;
            });

            return result;
        },

        uploadImg: function (fileInput, data) {
            var self = this;

            const file = data.target.files[0],
                allowed = this.isFileAllowed(file);


            if (allowed.passed) {
                const uploadFiles = self.uploadFiles();
                if (this.isFirstItem) {this.imageDefault(file.name); this.isFirstItem = false}
                uploadFiles[file.name] = {file: file, isUploaded: false, errorMsg: '', data: data};
                self.uploadFiles(uploadFiles);
            } else {
                this.notifyError(allowed.message, $t('Error: %1').replace('%1', file.name));
            }
        },

        getProductImage: function () {
            var uploadFiles = this.uploadFiles();

            const result = [];

            for (const x in uploadFiles) {
                const file = uploadFiles[x];
                var url = URL.createObjectURL(file.file);
                var name = file.file.name;
                var isDefault = file.isDefault;
                result.push({url, name, isDefault})
            }

            return result;
        },

        openModal: function (data, e) {
            if (data.name === this.imageDefault()) {
                this.modalBtn(true)
            } else {
                this.imageSelect(data.name)
                this.modalBtn(false)
            }
            $(this.modal).addClass('_active')
        },

        closeModal: function () {
            $(this.modal).removeClass('_active')
        },

        setDefault: function () {
            var uploadFiles = this.uploadFiles()
            var image = uploadFiles[this.imageSelect()]
            var newUploadfiles = {}
            newUploadfiles[this.imageSelect()] = {file: image.file, isUploaded: false, errorMsg: '', data: image.data}; //////asdasdasdasdasdasdasd
            delete uploadFiles[this.imageSelect()]
            this.imageDefault(this.imageSelect())
            newUploadfiles = {...newUploadfiles ,...uploadFiles}
            this.uploadFiles(newUploadfiles)
            this.closeModal()
        },

        countPName: function (e, data) {
            this.p_name($('#' + data.target.id).val().length)
        },

        countPSku: function (e, data) {
            this.p_sku($('#' + data.target.id).val().length)
        },

        countPDes: function (e, data) {
            this.p_des($('#' + data.target.id).html().length)
        },

        countPStartPrice: function (e, data) {
            this.p_startPrice($('#' + data.target.id).val().length)
        },

        countPMiniumBid: function (e, data) {
            this.p_miniumBid($('#' + data.target.id).val().length)
        },

        countPWeight: function (e, data) {
            this.p_weight($('#' + data.target.id).val().length)
        },

        countBName: function (e, data) {
            this.b_name($('#' + data.target.id).val().length)
        },
        /**
         * Open delivery sidebar menu
         */
        deliveryBar: function () {
            $(".a-explorer.delivery").toggleClass('_active');
        },

        /**
         * Open select brand sidebar menu
         */
        brandBar: function () {
            $(".a-explorer.brand").toggleClass('_active');
        },

        /**
         * Clear already selected brand
         */
        clearBrand: function () {
            this.selectBrand('')
        },

        /**
         * Open shipping sidebar menu
         */
        shippingBar: function () {
            $(".a-explorer.shipping").toggleClass('_active');
        },

        /**
         * Clear select shipping method
         */
        clearShipping: function () {
            this.shipping_method([])
        },

        /**
         * Open create brand sidebar menu
         */
        createBrandBar: function () {
            $(".a-explorer.create_brand").toggleClass('_active');
            this.brandBar();
        },

        /**
         * Return to the input field
         */
        shippingTime: function () {
            if (this.shipping_time() === '30') {return '30'}
            if (this.shipping_time() === '7-14') {return ''}
            if (this.shipping_time() === '' && this.isFirstChecked) {
                this.isFirstChecked = false;
                return ''
            } else {
                return '3'
            }
        },

        /**
         * Set date to delivery
         */
        setDate: function (e, data) {
            this.shipping_date($('#' + data.target.id).val());
        },

        /**
         * Disable input field
         */
        isDisable: function () {
            if (this.shipping_time() !== '') {return true}
        },

        /**
         * Get delivery text
         */
        getDeliveryText: function (){
            if (this.shipping_time() !== '') {
                this.shipping_date(this.shipping_time());
            } else {
                if ($("#delivery__date").val() === '') {
                    if (this.isFirstChecked) {
                        this.shipping_date('');
                    } else {
                        this.shipping_date('3');
                    }
                } else {
                    if ($("#delivery__date").val() === '30'){
                        this.shipping_date('3');
                    } else {
                        this.shipping_date($('#delivery__date').val());
                    }
                }
            }
            return this.shipping_date() === '1' ? ('within ' + this.shipping_date() + ' business day') : ('within ' + this.shipping_date() + ' business days');
        },

        clearDate: function () {
            this.shipping_time('')
            this.shipping_date('')
            this.deliveryBar()
        },

        setBrandImage: function (fileInput, data) {
            const self = this;

            const   file = data.target.files[0],
                allowed = this.isFileAllowed(file);

            self.brandImg(URL.createObjectURL(file));

            if (allowed.passed) {
                const brandFiles = self.brandFiles();
                brandFiles[file.name] = {file: file, isUploaded: false, errorMsg: '', data: data};
                self.brandFiles(brandFiles);
            } else {
                this.notifyError(allowed.message, $t('Error: %1').replace('%1', file.name));
            }
        },

        notifyError: function (msg, title = $t('Error: ')) {
            this.errorCount(this.errorCount() + 1);
            $('#msg-error').prepend('<div class="message message message-error error"><div>' + title + '<br />' + msg + '<div></div>');
            return this;
        },

        getBrandImage: function () {
            const brandFiles = this.brandFiles();
            const result = [];
            for (const x in brandFiles) {
                const file = brandFiles[x];
                var url = URL.createObjectURL(file.file)
                result.push(url);
            }
            return result;
        },

        clearImage: function () {
            this.brandFiles({})
        },
    })
})
