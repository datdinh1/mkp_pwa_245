/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    "map": {
        '*': {
            "fastclick":            'Wiki_Vendors/js/fastclick',
            "translateInline":      "mage/translate-inline",
            "form":                 "mage/backend/form",
            "button":               "mage/backend/button",
            "accordion":            "mage/accordion",
            "actionLink":           "mage/backend/action-link",
            "validation":           "mage/backend/validation",
            "notification":         "mage/backend/notification",
            "loader":               "mage/loader_old",
            "loaderAjax":           "mage/loader_old",
            "floatingHeader":       "mage/backend/floating-header",
            "suggest":              "mage/backend/suggest",
            "mediabrowser":         "jquery/jstree/jquery.jstree",
            "tabs":                 "mage/backend/tabs",
            "treeSuggest":          "mage/backend/tree-suggest",
            "calendar":             "mage/calendar",
            "dropdown":             "mage/dropdown_old",
            "collapsible":          "mage/collapsible",
            /*"menu":                 "mage/backend/menu",*/
            "jstree":               "jquery/jstree/jquery.jstree",
            "details":              "jquery/jquery.details",
            mageTranslationDictionary: 'Magento_Translation/js/mage-translation-dictionary'
        }
    },
    "shim": {
        "jquery/bootstrap": ["jquery","jquery/ui"],
        "adminlte": ["jquery","jquery/bootstrap"],
        "jquery/adminlte": ["jquery","jquery/bootstrap"],
        "jquery/slimscroll": ["jquery"],
        "jquery/fix_prototype_bootstrap": ["jquery","jquery/bootstrap","prototype"],
    },
    "deps": [
         "mage/backend/bootstrap",
         "mage/adminhtml/globals",
         "fastclick",
         "jquery/bootstrap",
         "jquery/slimscroll",
         "jquery/adminlte",
         "jquery/fix_prototype_bootstrap"
     ],
    "paths": {
        "jquery/ui": "jquery/jquery-ui",
        "jquery/bootstrap": "Wiki_Vendors/js/bootstrap",
        "jquery/slimscroll": 'Wiki_Vendors/js/jquery.slimscroll',
        "jquery/adminlte": "Wiki_Vendors/js/adminlte",
        "jquery/fix_prototype_bootstrap": "Wiki_Vendors/js/fix_prototype_bootstrap"
    }
};
