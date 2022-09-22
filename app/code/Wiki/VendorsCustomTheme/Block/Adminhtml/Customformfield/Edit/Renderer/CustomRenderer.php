<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCustomTheme\Block\Adminhtml\Customformfield\Edit\Renderer;
/**
* CustomFormField Customformfield field renderer
*/
class CustomRenderer extends \Magento\Framework\Data\Form\Element\AbstractElement
{
    /**
    * Get the after element html.
    *
    * @return mixed
    */
    public function getAfterElementHtml()
    {
        
        // here you can write your code.
        $customDiv = '<div style="width:600px;height:200px;margin:10px 0;border:2px solid #000" id="customdiv"><h1 style="margin-top: 12%;margin-left:40%;">Custom Div</h1></div>';
        $output = "
		<script type='text/javascript'>
			require([
				'jquery'
			], function(jQuery){
				(function($) {
					$('#".$this->getId()."').attr('data-hex', true).mColorPicker();
				})(jQuery);
			});
		</script>";
        return $output;
    }
}
