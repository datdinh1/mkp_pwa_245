<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCustomTheme\Controller\ThemePage;

use Magento\Framework\App\Action\Context;

class Css extends \Magento\Framework\App\Action\Action
{

    public function __construct(
		Context $context,
		\Wiki\Vendors\Model\Session $vendorSession,
		\Wiki\VendorsCustomTheme\Model\ResourceModel\Theme\Config\Collection $configCollection
	){
		$this->_configCollection     	= $configCollection;
		$this->_vendorSession     		= $vendorSession;
        parent::__construct($context);
    }

    public function execute()
    {
		$themeId = $this->getRequest()->getParam('themeId');
		$configTheme = $this->_configCollection->addFieldToFilter('theme_id', $themeId);
		$arr = [];
        $arr[0] = [];
        $arr[$this->_vendorSession->getVendor()->getId()]=[];
        $checkCurrentConfig = 0;
		foreach($configTheme as $config){
			if($config["vendor_id"] == 0){
                $arr[0][] = $config;
            }else{
                $arr[$this->_vendorSession->getVendor()->getId()][] = $config;
                $checkCurrentConfig = 1;
            }
		}
        if($checkCurrentConfig == 1){
            $configTheme = $arr[$this->_vendorSession->getVendor()->getId()];
        }else{
			$configTheme = $arr[0];
		}
		$storeId = $this->getRequest()->getParam('store');
		$helper =  \Magento\Framework\App\ObjectManager::getInstance()->get('Wiki\VendorsCustomTheme\Helper\AdditionData');
		$html = '';
		$html .= 'body{';
		$fontStyle = [];
        foreach($configTheme as $config){
			$fruits_ar = explode('/', $config["path"]);
			if($fruits_ar[1] == "general"){
			    if($fruits_ar[2] == "theme_color"){
                    $html .= 'background-color:'.$config["value"].' !important;';
                }
                if($fruits_ar[2] == "background_image") {
                    $backgroundImage = $config["value"];
                    if($backgroundImage!=''){
                        $folderName = \Wiki\VendorsCustomTheme\Model\Config\Backend\Image::UPLOAD_DIR;
                        $path = $folderName . '/' . $backgroundImage;
                        $backgroundImageUrl = $helper->getUrlBuilder()->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . $path;
                        $html .= 'background-image:url('.$backgroundImageUrl.') !important;';

                    }
                }
                if($fruits_ar[2] == "background_repeat") {
                    $html.= 'background-repeat:'.$config["value"].' !important;';
                }
                if($fruits_ar[2] == "background_image_position") {
                    $html.= 'background-position:'.$config["value"].' !important;';
                }
			}
			else if($fruits_ar[1] == "fonts"){
                if($fruits_ar[2] == "default_font") {
                    $html .= 'font-family: "' . $config["value"] . '", arial, tahoma !important;font-weight: normal !important;';
                    continue;
                }
				if($fruits_ar[2] == "default_font_size") {
					$html .= 'font-size:' . $config["value"] . ' !important;';
                    $html .= '}';
                    continue;
                }
				if($fruits_ar[2] == "custom_fonts_element") {
					$custom_font = $config["value"];
				}
				if($fruits_ar[2] == "menu") {
					$index = ".navigation li.level0 a.level-top, .navigation ul.container .level0 > a";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "menu_font_size") {
					$index = ".navigation li.level0 a.level-top, .navigation ul.container .level0 > a";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h1") {
					$index = "h1";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h1_font_size") {
					$index = "h1";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h2") {
					$index = "h2";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h2_font_size") {
					$index = "h2";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h3") {
					$index = "h3";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h3_font_size") {
					$index = "h3";
					if(!isset($fontStyle[$index])){

						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h4") {
					$index = "h4";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h4_font_size") {
					$index = "h4";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h5") {
					$index = "h5";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h5_font_size") {
					$index = "h5";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h6") {
					$index = "h6";
					if(!isset($fontStyle["h6"])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "h6_font_size") {
					$index = "h6";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "price") {
					$index = ".price, .price-box .price";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "price_font_size") {
					$index = ".price, .price-box .price";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "btn") {
					$index = ".btn";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "btn_font_size") {
					$index = ".btn";
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "custom_font_fml") {
					$index = '$custom_font';
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-family"] = $config["value"];
					}else{
						$fontStyle[$index]["font-family"] = $config["value"];
					}
					continue;
				}
				if($fruits_ar[2] == "custom_font_size") {
					$index = '$custom_font';
					if(!isset($fontStyle[$index])){
						$fontStyle[$index] = [];
						$fontStyle[$index]["font-size"] = $config["value"];
					}else{
						$fontStyle[$index]["font-size"] = $config["value"];
					}
					continue;
				}
			}
			else if($fruits_ar[1] == "header"){
				$headerColorSetting = $helper->getHeaderColorSetting($storeId, $fruits_ar[2], $config["value"]);
				if (count($headerColorSetting) > 0) {
					foreach ($headerColorSetting as $class => $style) {
					    if($fruits_ar[2] == ".".$class)
						$style = array_filter($style);
						if (count($style) > 0) {
							$html .= $class . '{';
							foreach ($style as $_style => $value) {
								$html .= $_style . ': ' . $value . ' !important;';
							}
							$html .= '}';
						}
					}
				}
			}else if($fruits_ar[1] == "main"){
				$mainColorSetting = $helper->getMainColorSetting($storeId , $fruits_ar[2], $config["value"]);
				if (count($mainColorSetting) > 0) {
					foreach ($mainColorSetting as $class => $style) {
						$style = array_filter($style);
						if (count($style) > 0) {
							$html .= $class . '{';
							foreach ($style as $_style => $value) {
								$html .= $_style . ': ' . $value . ' !important;';
							}
							$html .= '}';
						}
					}
				}
			}else if($fruits_ar[1] == "footer"){
				$footerColorSetting = $helper->getFooterColorSetting($storeId , $fruits_ar[2], $config["value"]);
				if (count($footerColorSetting) > 0) {
					foreach ($footerColorSetting as $class => $style) {
						$style = array_filter($style);
						if (count($style) > 0) {
							$html .= $class . '{';
							foreach ($style as $_style => $value) {
								$html .= $_style . ': ' . $value . ' !important;';
							}
							$html .= '}';
						}
					}
				}
			}
		}
        $existsDefaultFront = false;
		foreach($configTheme as $config){
			$fruits_ar = explode('/', $config["path"]);
			if(in_array("default_font_size", $fruits_ar) == true){
			    $existsDefaultFront = true;
            }
		}
		if( $existsDefaultFront == false){
            $html .= '}';
        }

		$fontStyle = array_filter($fontStyle);
		foreach ($fontStyle as $class => $style) {
			$style = array_filter($style);
			if (count($style) > 0) {
				$html .= $class . '{';
				foreach ($style as $_style => $value) {
					if($_style=='font-family'){
						$html .= $_style . ': "' . $value . '" !important;';
					}else{
						$html .= $_style . ': ' . $value . ' !important;';
					}
				}
				$html .= '}
				';
			}
		}






		if ($helper->getStoreConfig('mgstheme/custom_style/style', $storeId) != '') {
            $html .= $helper->getStoreConfig('mgstheme/custom_style/style', $storeId);
        }

		$this->getResponse()->setHeader('Content-type', 'text/css', true);
		$this->getResponse()->setBody($html);
    }
}
