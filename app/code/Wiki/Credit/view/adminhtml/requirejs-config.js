/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {

    "shim": {
    	"jquery/raphael": ["jquery"],
    	"jquery/chartjs": ["jquery"],
    	"jquery/morris": ["jquery","jquery/raphael"]
	},
	"paths": {
        "jquery/morris": "Wiki_Credit/js/morris/morris_min",
        "jquery/raphael": "Wiki_Credit/js/morris/raphael-min",
        "jquery/chartjs": "Wiki_Credit/js/chartjs/chart_min"
	}
};
