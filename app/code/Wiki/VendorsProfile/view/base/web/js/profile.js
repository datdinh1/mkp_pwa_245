/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'jquery',
    'knockout',
    'underscore',
    'mage/translate',
    'Magento_Ui/js/lib/validation/validator',
    'Wiki_VendorsProfile/js/owl.carousel.min',
    'jquery/file-uploader',
    'domReady!'
], function (Component, $, ko, _, $t, validator) {
    'use strict';

    $(document).on('keyup',function(evt) {
        if (evt.keyCode === 27 && $('#image-modal').hasClass('_active')) {
            $('#image-modal').removeClass('_active');
        }
    });

    return Component.extend({
        defaults: {
            vendorId: '',
            allowedExtensions: false,
            maxFileSize: false,
            isMultipleFiles: false,
            pageSize: 20,
            uploaderConfig: {
                dataType: 'json',
                sequentialUploads: true,
                formData: {
                    'form_key': window.FORM_KEY
                }
            },
        },
        backgroundUpload: '#profile-image',
        modalUpload: '#image-modal',
        modalCloseBtn: '.image-modal__back',

        /**
         * Initialize
         */
        initialize: function () {
            this._super();
            this.observe({
                uploadFiles: {},
                fileUploading: '',
                pageSize: this.pageSize,
                errorCount: 0,
                backgroundImg: ko.observable(),
                avatarImg: ko.observable(),
                bannerImg: ko.observableArray([]),
            });
        },

        /**
         * Initializes file uploader plugin on provided input element.
         *
         * @param {HTMLInputElement} fileInput
         * @returns {FileUploader} Chainable.
         */
        initUploader: function (fileInput) {
            this.onBeforeFileUpload(fileInput);
            return this;
        },

        /**
         * Handler function which is supposed to be invoked when
         * file input element has been rendered.
         *
         * @param {HTMLInputElement} fileInput
         * @param data
         */
        onElementRender: function (fileInput, data) {
            this.initUploader(data);
        },

        bannerModalToggle: function () {
            $(this.modalUpload).toggleClass('_active')
        },

        isExtensionAllowed: function (file) {
            return validator('validate-file-type', file.name, this.allowedExtensions);
        },

        isSizeExceeded: function (file) {
            return validator('validate-max-size', file.size, this.maxFileSize);
        },

        isFileAllowed: function (file) {
            let result;

            _.every([
                this.isExtensionAllowed(file),
                this.isSizeExceeded(file)
            ], function (value) {
                result = value;

                return value.passed;
            });

            return result;
        },

        /**
         * Handle before upload file
         */
        onBeforeFileUpload: function (e) {
            const self = this;

            const data = {
                fileInput: $(e.target),
                files: e.target.files,
                nameInput: e.target.name
            }

            const file = e.target.files[0],
                allowed = this.isFileAllowed(file);

            if (data.nameInput === 'profile-image') {
                self.backgroundImg(URL.createObjectURL(file));
            }
            if (data.nameInput === 'profile-logo') {
                self.avatarImg(URL.createObjectURL(file))
            }
            if (data.nameInput === 'profile-banners') {
                self.bannerImg().push(URL.createObjectURL(file))
            }
            if (allowed.passed) {
                const uploadFiles = self.uploadFiles();
                uploadFiles[file.name] = {file: file, isUploaded: false, errorMsg: '', data: data};
                self.uploadFiles(uploadFiles);
            } else {
                this.notifyError(allowed.message, $t('Error: %1').replace('%1', file.name));
            }
        },

        /**
         * Displays provided error message.
         *
         * @param {String} msg
         * @param title
         * @returns {FileUploader} Chainable.
         */
        notifyError: function (msg, title = $t('Error: ')) {
            this.errorCount(this.errorCount() + 1);
            $('#msg-error').prepend('<div class="message message message-error error"><div>' + title + '<br />' + msg + '<div></div>');
            return this;
        },

        /**
         * Get pending upload files
         *
         * @return array
         */
        getPendingUploadFiles: function () {
            const uploadFiles = this.uploadFiles();
            const result = [];
            for (const x in uploadFiles) {
                const file = uploadFiles[x];
                if (!file.isUploaded) {
                    result.push(file);
                }
            }
            return uploadFiles;
        },

        /**
         * Get pending upload Background
         *
         * @return array
         */
        getPendingBackground: function () {
            const uploadFiles = this.uploadFiles();
            const result = [];
            for (const x in uploadFiles) {
                const file = uploadFiles[x];
                if (!file.isUploaded && file.data.nameInput === 'profile-image') {
                    result.push(file);
                }
            }
            return result;
        },

        /**
         * Get pending upload Avatar
         *
         * @return array
         */
        getPendingAvatar: function () {
            const uploadFiles = this.uploadFiles();
            const result = [];
            for (const x in uploadFiles) {
                const file = uploadFiles[x];
                if (!file.isUploaded && file.data.nameInput === 'profile-logo') {
                    result.push(file);
                }
            }
            return result;
        },

        /**
         * Get pending upload Banner
         *
         * @return array
         */
        getPendingBanner: function () {
            const uploadFiles = this.uploadFiles();
            const result = [];
            for (const x in uploadFiles) {
                const file = uploadFiles[x];
                if (!file.isUploaded && file.data.nameInput === 'profile-banners') {
                    let image = URL.createObjectURL(file.file);
                    let name = file.file.name;
                    result.push({image, name});
                }
            }
            return result;
        },

        /**
         * Get total number of uploaded images.
         */
        getImagesCount: function () {
            return this.getPendingUploadFiles().size();
        },

        removeBanner: function (data, e) {
            const uploadFiles = this.uploadFiles();
            delete uploadFiles[data.name];
            this.uploadFiles(uploadFiles);
        },

        /**
         * Clear input field
         *
         * @return void
         */
        clear: function () {
            this.uploadFiles({});
            $('#shop-name').val($('#shop-name').attr('data-reset'));
            $('#shop-description').val($('#shop-description').attr('data-reset'));
        },

        bannerSlide: function (element, data){
            if(this.foreach[this.foreach.length-1] === data) {
                $('.mgs-carousel-catalog').owlCarousel({
                    items: 1,
                    autoplay: false,
                    nav: false,
                    dots: false,
                    autoHeight: false,
                });
            }
        }
    })
})
