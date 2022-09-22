/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            categoryForm:       'Wiki_VendorsProduct/catalog/category/form',
            newCategoryDialog:  'Wiki_VendorsProduct/js/new-category-dialog',
            categoryTree:       'Wiki_VendorsProduct/js/category-tree',
            productGallery:     'Wiki_VendorsProduct/js/product-gallery',
            baseImage:          'Wiki_VendorsProduct/catalog/base-image-uploader',
            newVideoDialog:     'Wiki_VendorsProduct/js/video/new-video-dialog',
            openVideoModal:     'Wiki_VendorsProduct/js/video/video-modal',
            productAttributes:  'Wiki_VendorsProduct/catalog/product-attributes',
            menu:               'mage/backend/menu'
        }
    },
    "shim": {
        "productGallery": ["jquery/fix_prototype_bootstrap"],
        "Wiki_VendorsProduct/catalog/apply-to-type-switcher": ["Wiki_VendorsProduct/catalog/type-events"]
    },
    "paths": {
        "Magento_Catalog/catalog/type-events": "Wiki_VendorsProduct/catalog/type-events",
        "Magento_Catalog/catalog/apply-to-type-switcher": "Wiki_VendorsProduct/catalog/apply-to-type-switcher",
        "Magento_Catalog/js/product/weight-handler":"Wiki_VendorsProduct/js/product/weight-handler",
        "Magento_Catalog/js/product-gallery":"Wiki_VendorsProduct/js/product-gallery",
        "Magento_ProductVideo/js/get-video-information":"Wiki_VendorsProduct/js/video/get-video-information",
        "Magento_Catalog/js/tier-price/percentage-processor":"Wiki_VendorsProduct/js/tier-price/percentage-processor",
        "Magento_Catalog/js/tier-price/value-type-select":"Wiki_VendorsProduct/js/tier-price/value-type-select",
        "Magento_Catalog/js/utils/percentage-price-calculator":"Wiki_VendorsProduct/js/utils/percentage-price-calculator",
        "Magento_Catalog/js/components/custom-options-component":"Wiki_VendorsProduct/js/components/custom-options-component",
        "Magento_Catalog/js/components/custom-options-price-type":"Wiki_VendorsProduct/js/components/custom-options-price-type",
        "Magento_Catalog/js/components/dynamic-rows-import-custom-options":"Wiki_VendorsProduct/js/components/dynamic-rows-import-custom-options"
    }
};
