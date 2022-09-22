define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Ui/js/lib/validation/validator',
    'jquery/file-uploader',
],
    function ($, Component, ko, validator) {
    'use strict';
        $(document).on('keyup',function(evt) {
            if (evt.keyCode === 27 && $('.a-explorer').hasClass('_active')) {
                $('.a-explorer').removeClass('_active');
            }
        });
    return Component.extend({
        defaults: {
            allowedExtensions: false,
            maxFileSize: false,
            couponNameInput: 'input[name="name"]',//'input[name="coupon__name"]',
            couponCodeInput: 'input[name="coupon_code"]',//'input[name="coupon__code"]',
            couponStartInput: 'input[name="from_date"]',//'input[name="coupon__start"]',
            couponEndInput: 'input[name="to_date"]',
            couponAmountInput: 'input[name="uses_per_coupon"]',
            today: new Date().toISOString().slice(0, 10),
            type_store: '',
            simple_action: '',
            couponImgUrl: '',
            flag: true,
            discountLimited: '',
        },

        radioSelectedOptionValue: ko.observable(),
        maximumDiscount: ko.observable('limit_value'),
        couponType: ko.observable('store_coupon'),

        initialize: function () {
            this._super();
            this.observe({
                uploadFiles: {},
                errorCount: 0,
                couponImg: this.couponImgUrl ? this.couponImgUrl : '',
                couponName: '',
                couponCode: '',
                couponStart: '',
                couponEnd: '',
                couponAmount: '',
            })
        },

        byFixed: function () {
            // if (this.simple_action != '') {this.radioSelectedOptionValue(this.simple_action)}
            return this.radioSelectedOptionValue() === 'by_fixed';
        },

        byPercent: function () {
            // if (this.simple_action != '') {this.radioSelectedOptionValue(this.simple_action)}
            return this.radioSelectedOptionValue() === 'by_percent';
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

        setImage: function (fileInput, data) {
            const self = this;

            const   file = data.target.files[0],
                    allowed = this.isFileAllowed(file);

            self.couponImg(URL.createObjectURL(file));

            if (allowed.passed) {
                const uploadFiles = self.uploadFiles();
                uploadFiles[file.name] = {file: file, isUploaded: false, errorMsg: '', data: data};
                self.uploadFiles(uploadFiles);
            } else {
                this.notifyError(allowed.message, $t('Error: %1').replace('%1', file.name));
            }
        },

        notifyError: function (msg, title = $t('Error: ')) {
            this.errorCount(this.errorCount() + 1);
            $('#msg-error').prepend('<div class="message message message-error error"><div>' + title + '<br />' + msg + '<div></div>');
            return this;
        },

        getPendingCoupon: function () {
            const uploadFiles = this.uploadFiles();
            const result = [];
            for (const x in uploadFiles) {
                const file = uploadFiles[x];
                result.push(file);
            }
            return result;
        },

        clearImage: function () {
            this.uploadFiles({})
            this.couponImg('')
        },

        getCouponType: function (){
            if (this.type_store != '' && this.flag ) {
                this.couponType(this.type_store); 
                this.radioSelectedOptionValue(this.simple_action);
                this.setCouponAmount();
                this.setCouponName();
                this.setCouponCode();
                this.setCouponStart();
                this.setCouponEnd();
                this.maximumDiscount(this.discountLimited);
                this.flag = false
            }
           return this.couponType() === 'store_coupon' ? 'store discount code' : 'product discount code';
        },

        getCouponTypeHidden: function (){
            return this.couponType() === 'store_coupon' ? 'store_coupon' : 'product_coupon';
         },

        toggleCouponType: function () {
            $('.a-explorer._type').toggleClass('_active')
        },

        toggleSelectProduct: function () {
            $('.a-explorer._product').toggleClass('_active')
        },

        setCouponName: function () {
            this.couponName($(this.couponNameInput).val())
        },

        setCouponCode: function () {
            this.couponCode($(this.couponCodeInput).val())
        },

        setCouponStart: function () {
            this.couponStart($(this.couponStartInput).val())
        },

        setCouponEnd: function () {
            this.couponEnd($(this.couponEndInput).val())
        },

        setCouponAmount: function () {
            this.couponAmount($(this.couponAmountInput).val())
        },

        allInputFilled: function () {
            if (this.flag) {this.flag = false; }
            return this.couponName() !== '' && this.couponCode() !== '' && this.couponStart() !== '' && this.couponEnd() !== '' && this.couponAmount() !== '' && this.radioSelectedOptionValue() !== '';
        }
    });
});
