<?php

namespace Wiki\VendorsCustomTheme\Block\Vendors\Theme\Edit\Tab;

use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Wiki\VendorsCustomTheme\Model\Source\LayoutStyle;

/**
 * implementing now
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Configuration extends \Wiki\Vendors\Block\Vendors\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var WysiwygConfig
     */
    protected $wysiwygConfig;

    /**
     * Status options
     * @var \Wiki\VendorsCustomTheme\Model\Source\LayoutStyle
     */
    protected $statusOptions;

    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    protected $pageLayoutBuilder;

    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $vendorSession;

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('SM Destino');
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return $this
     */
    public function _beforeToHtml()
    {
        $this->_initForm();

        return parent::_beforeToHtml();
    }

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param WysiwygConfig $wysiwygConfig
     * @param \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder
     * @param \Wiki\Vendors\Model\Session $vendorSession
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        WysiwygConfig $wysiwygConfig,
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        \Wiki\Vendors\Model\Session $vendorSession,
        array $data = [],
        \Wiki\VendorsCustomTheme\Model\Source\LayoutStyle $layoutStyle,
        \Wiki\VendorsCustomTheme\Model\Source\MaxWidth $maxwidth,
        \Wiki\VendorsCustomTheme\Model\Source\Repeat $repeat,
        \Wiki\VendorsCustomTheme\Model\Source\BackgroundRepeatImage $backGroundRepeatImage,
        \Magento\Config\Model\Config\Source\Yesno $yesno,
        \Wiki\VendorsCustomTheme\Model\Source\HomeStyle $homeStyle,
        \Wiki\VendorsCustomTheme\Block\Adminhtml\Fields\Heading $heading,
        \Wiki\VendorsCustomTheme\Model\Config\Sources\Fonts $fonts,
        \Wiki\VendorsCustomTheme\Model\ResourceModel\Theme\Config\Collection $configCollection
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->wysiwygConfig            = $wysiwygConfig;
        $this->pageLayoutBuilder        = $pageLayoutBuilder;
        $this->vendorSession            = $vendorSession;
        $this->layoutStyle              = $layoutStyle;
        $this->maxwidth                 = $maxwidth;
        $this->repeat                   = $repeat;
        $this->backGroundRepeatImage    = $backGroundRepeatImage;
        $this->yesno                    = $yesno;
        $this->homeStyle                = $homeStyle;
        $this->heading                  = $heading;
        $this->fonts                    = $fonts;
        $this->_configCollection        = $configCollection;
    }

    /**
     * @return void
     */
    protected function _initForm()
    {
        $theme = $this->_coreRegistry->registry('current_theme');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        /* $config = $this->wysiwygConfig->getConfig(); */
        $fieldset = $form->addFieldset('general_content_fieldset', ['legend' => __('General'), 'class' => 'theme-home-general']);
        $fieldset->addType(
            'fieldColor',
            '\Wiki\VendorsCustomTheme\Block\Adminhtml\Customformfield\Edit\Renderer\CustomRenderer'
        );
        $fieldset->addField(
            'theme_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][general][theme_color]',
                'label' => __('Theme color'),
                'title' => __('Theme color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'layout_style',
            'select',
            [
                'name' => 'theme[custom_theme][general][layout_style]',
                'label' => __('Layout style'),
                'title' => __('Layout style'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->layoutStyle->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'maximum_page_width',
            'select',
            [
                'name' => 'theme[custom_theme][general][maximum_page_width]',
                'label' => __('Maximum Page Width'),
                'title' => __('Maximum Page Width'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->maxwidth->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'background_image',
            'file',
            [
                'name' => 'theme[custom_theme][general][background_image]',
                'label' => __('Out of Box Background Image'),
                'title' => __('Out of Box Background Image'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
            ]
        );
        $fieldset->addField(
            'background_repeat',
            'select',
            [
                'name' => 'theme[custom_theme][general][background_repeat]',
                'label' => __('Background Repeat'),
                'title' => __('Background Repeat'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->repeat->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'background_image_position',
            'select',
            [
                'name' => 'theme[custom_theme][general][background_image_position]',
                'label' => __('Background Image Position'),
                'title' => __('Background Image Position'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->backGroundRepeatImage->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'responsive_layout',
            'select',
            [
                'name' => 'theme[custom_theme][general][responsive_layout]',
                'label' => __('Responsive Layout'),
                'title' => __('Responsive Layout'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->yesno->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'right_to_left_layout',
            'select',
            [
                'name' => 'theme[custom_theme][general][right_to_left_layout]',
                'label' => __('Right To Left Layout'),
                'title' => __('Right To Left Layout'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->yesno->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'show_border_radius',
            'select',
            [
                'name' => 'theme[custom_theme][general][show_border_radius]',
                'label' => __('Show Border Radius'),
                'title' => __('Show Border Radius'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->yesno->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'home_style',
            'select',
            [
                'name' => 'theme[custom_theme][general][home_style]',
                'label' => __('Home Style'),
                'title' => __('Home Style'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->homeStyle->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'mobile_layout',
            'select',
            [
                'name' => 'theme[custom_theme][general][mobile_layout]',
                'label' => __('Mobile Layout'),
                'title' => __('Mobile Layout'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->yesno->toOptionArray(),
            ]
        );
        $fieldset->addField(
            'cms_home_page_mobile',
            'select',
            [
                'name' => 'theme[custom_theme][general][cms_home_page_mobile]',
                'label' => __('CMS Home Page Mobile'),
                'title' => __('CMS Home Page Mobile'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->yesno->toOptionArray(),
            ]
        );
        $fieldset = $form->addFieldset('fonts_content_fieldset', ['legend' => __('Fonts'), 'class' => 'theme-home-fonts']);
        $fieldset->addField(
            'default_font',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Default Font</h4>");
        $fieldset->addField(
            'default_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][default_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'default_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][default_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'heading1',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Heading 1</h4>");
        $fieldset->addField(
            'heading1_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][default_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'heading1_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][heading1_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'heading2',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Heading 2</h4>");
        $fieldset->addField(
            'heading2_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][heading2_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'heading2_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][heading2_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'heading3',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Heading 3</h4>");
        $fieldset->addField(
            'heading3_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][heading3_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'heading3_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][heading3_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'heading4',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Heading 4</h4>");
        $fieldset->addField(
            'heading4_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][heading4_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'heading4_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][heading4_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'heading5',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Heading 5</h4>");
        $fieldset->addField(
            'heading5_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][heading5_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'heading5_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][heading5_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'heading6',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Heading 6</h4>");
        $fieldset->addField(
            'heading6_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][heading6_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'heading6_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][heading6_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'price',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Price</h4>");
        $fieldset->addField(
            'price_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][price_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'price_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][price_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'menu',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Menu</h4>");
        $fieldset->addField(
            'menu_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][menu_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'menu_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][menu_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'button',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Button</h4>");
        $fieldset->addField(
            'button_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][button_font_family]',
                'label' => __('Font Family'),
                'title' => __('Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'button_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][button_font_size]',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset->addField(
            'custom',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Custom Font</h4>");
        $fieldset->addField(
            'custom_font_family',
            'select',
            [
                'name' => 'theme[custom_theme][fonts][custom_font_family]',
                'label' => __('Custom Font Family'),
                'title' => __('Custom Font Family'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'values' => $this->fonts->toOptionArray()
            ]
        );
        $fieldset->addField(
            'custom_font_size',
            'text',
            [
                'name' => 'theme[custom_theme][fonts][custom_font_size]',
                'label' => __('Custom Font Size'),
                'title' => __('Custom Font Size'),
                'css_class' => 'admin__field-control',
                'class' => 'admin__control-text',
                'note' => '	eg: 12px'
            ]
        );
        $fieldset = $form->addFieldset('header_content_fieldset', ['legend' => __('Header'), 'class' => 'theme-home-header']);
        $fieldset->addType(
            'fieldColor',
            '\Wiki\VendorsCustomTheme\Block\Adminhtml\Customformfield\Edit\Renderer\CustomRenderer'
        );
        $fieldset->addField(
            'header_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][header_background_color]',
                'label' => __('Header background color'),
                'title' => __('Header background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'header_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][header_border_color]',
                'label' => __('Header border color'),
                'title' => __('Header border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'top_link_section',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Top Links Section</h4>");
        $fieldset->addField(
            'toplink_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][toplink_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'toplink_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][toplink_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'toplink_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][toplink_link_color]',
                'label' => __('Link color'),
                'title' => __('Link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'toplink_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][toplink_link_hover_color]',
                'label' => __('Link hover color'),
                'title' => __('Link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'toplink_dropdown_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][toplink_dropdown_link_color]',
                'label' => __('Dropdown link color'),
                'title' => __('Dropdown link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'toplink_dropdown_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][toplink_dropdown_link_hover_color]',
                'label' => __('Dropdown link hover color'),
                'title' => __('Dropdown link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Middle Section</h4>");
        $fieldset->addField(
            'middle_section_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_middle_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_middle_link_color]',
                'label' => __('Middle link color'),
                'title' => __('Middle link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_middle_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_middle_link_hover_color]',
                'label' => __('Middle link hover color'),
                'title' => __('Middle link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_middle_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_middle_text_hover]',
                'label' => __('Middle text color'),
                'title' => __('Middle text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_icon_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_icon_color]',
                'label' => __('Icon color'),
                'title' => __('Icon color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_icon_color_hover',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_icon_color_hover]',
                'label' => __('Icon color (Hover)'),
                'title' => __('Icon color (Hover)'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_number_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_number_color]',
                'label' => __('Number color'),
                'title' => __('Number color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'middle_section_number_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][middle_section_number_background_color]',
                'label' => __('Number background color'),
                'title' => __('Number background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Menu Section</h4>");
        $fieldset->addField(
            'menu_section_section_background_menu',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_section_background_menu]',
                'label' => __('Section background menu'),
                'title' => __('Section background menu'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_section_background_content_menu',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_section_background_content_menu]',
                'label' => __('Section background content menu'),
                'title' => __('Section background content menu'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_0_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_0_link_color]',
                'label' => __('Level 0 link color'),
                'title' => __('Level 0 link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_0_link_color_hover',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_0_link_color_hover]',
                'label' => __('Level 0 link hover color'),
                'title' => __('Level 0 link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_0_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_0_background_color]',
                'label' => __('Level 0 background color'),
                'title' => __('Level 0 background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_0_hover_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_0_hover_background_color]',
                'label' => __('Level 0 hover background color'),
                'title' => __('Level 0 hover background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_1_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_1_link_color]',
                'label' => __('Level 1 link color'),
                'title' => __('Level 1 link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_1_link_color_hover',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_1_link_color_hover]',
                'label' => __('Level 1 link hover color'),
                'title' => __('Level 1 link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_1_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_1_background_color]',
                'label' => __('Level 1 background color'),
                'title' => __('Level 1 background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'menu_section_level_1_hover_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][header][menu_section_level_1_hover_background_color]',
                'label' => __('Level 1 hover background color'),
                'title' => __('Level 1 hover background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset = $form->addFieldset('main_content_fieldset', ['legend' => __('Main Content'), 'class' => 'theme-home-content']);
        $fieldset->addType(
            'fieldColor',
            '\Wiki\VendorsCustomTheme\Block\Adminhtml\Customformfield\Edit\Renderer\CustomRenderer'
        );
        $fieldset->addField(
            'text_link',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Text & Link</h4>");
        $fieldset->addField(
            'text_link_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][text_link_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'text_link_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][text_link_link_color]',
                'label' => __('Link color'),
                'title' => __('Link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        //
        $fieldset->addField(
            'text_link_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][text_link_link_hover_color]',
                'label' => __('Link hover color'),
                'title' => __('Link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'text_link_price_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][text_link_price_color]',
                'label' => __('Price color'),
                'title' => __('Price color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'text_link_special_price_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][text_link_special_price_color]',
                'label' => __('Special price color'),
                'title' => __('Special price color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'text_link_old_price_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][text_link_old_price_color]',
                'label' => __('Old price color'),
                'title' => __('Old price color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Default Button</h4>");
        $fieldset->addField(
            'default_button_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button_hover_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button_hover_text_color]',
                'label' => __('Hover text color'),
                'title' => __('Hover text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button_hover_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button_hover_background_color]',
                'label' => __('Hover background color'),
                'title' => __('Hover background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button_border_color]',
                'label' => __('Border color'),
                'title' => __('Border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button_hover_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button_hover_border_color]',
                'label' => __('Hover border color'),
                'title' => __('Hover border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button2',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Default Button2</h4>");
        $fieldset->addField(
            'default_button2_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button2_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button2_hover_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button2_hover_text_color]',
                'label' => __('Hover text color'),
                'title' => __('Hover text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button2_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button2_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button2_hover_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button2_hover_background_color]',
                'label' => __('Hover background color'),
                'title' => __('Hover background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button2_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button2_border_color]',
                'label' => __('Border color'),
                'title' => __('Border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'default_button2_hover_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][default_button2_hover_border_color]',
                'label' => __('Hover border color'),
                'title' => __('Hover border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'primary_button',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Primary Button</h4>");
        $fieldset->addField(
            'primary_button_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][primary_button_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'primary_button_hover_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][primary_button_hover_text_color]',
                'label' => __('Hover text color'),
                'title' => __('Hover text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'primary_button_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][primary_button_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'primary_button_hover_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][primary_button_hover_background_color]',
                'label' => __('Hover background color'),
                'title' => __('Hover background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'primary_button_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][primary_button_border_color]',
                'label' => __('Border color'),
                'title' => __('Border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'primary_button_hover_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][primary_button_hover_border_color]',
                'label' => __('Hover border color'),
                'title' => __('Hover border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'secondary_button',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Secondary Button</h4>");
        $fieldset->addField(
            'secondary_button_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][secondary_button_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'secondary_button_hover_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][secondary_button_hover_text_color]',
                'label' => __('Hover text color'),
                'title' => __('Hover text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'secondary_button_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][secondary_button_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'secondary_button_hover_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][secondary_button_hover_background_color]',
                'label' => __('Hover background color'),
                'title' => __('Hover background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'secondary_button_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][secondary_button_border_color]',
                'label' => __('Border color'),
                'title' => __('Border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'secondary_button_hover_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][main][secondary_button_hover_border_color]',
                'label' => __('Hover border color'),
                'title' => __('Hover border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset = $form->addFieldset('footer_content_fieldset', ['legend' => __('Footer'), 'class' => 'theme-home-footer']);
        $fieldset->addType(
            'fieldColor',
            '\Wiki\VendorsCustomTheme\Block\Adminhtml\Customformfield\Edit\Renderer\CustomRenderer'
        );
        $fieldset->addField(
            'top_section',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Top Section</h4>");
        $fieldset->addField(
            'top_section_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][top_section_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'top_section_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][top_section_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'top_section_border_top_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][top_section_border_top_color]',
                'label' => __('Border top color'),
                'title' => __('Border top color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'top_section_heading_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][top_section_heading_color]',
                'label' => __('Heading color'),
                'title' => __('Heading color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'top_section_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][top_section_link_color]',
                'label' => __('Link color'),
                'title' => __('Link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'top_section_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][top_section_link_hover_color]',
                'label' => __('Link hover color'),
                'title' => __('Link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'footer_middle_section',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Middle Section</h4>");
        $fieldset->addField(
            'footer_middle_section_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][footer_middle_section_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'footer_middle_section_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][footer_middle_section_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'footer_middle_section_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][footer_middle_section_border_top_color]',
                'label' => __('Border color'),
                'title' => __('Border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'footer_middle_section_heading_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][footer_middle_section_heading_color]',
                'label' => __('Heading color'),
                'title' => __('Heading color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'footer_middle_section_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][footer_middle_section_link_color]',
                'label' => __('Link color'),
                'title' => __('Link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'footer_middle_section_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][footer_middle_section_link_hover_color]',
                'label' => __('Link hover color'),
                'title' => __('Link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'bottom_section',
            'hidden',
            []
        )->setAfterElementHtml("<h4>Bottom Section</h4>");
        $fieldset->addField(
            'bottom_section_background_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][bottom_section_background_color]',
                'label' => __('Background color'),
                'title' => __('Background color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'bottom_section_text_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][bottom_section_text_color]',
                'label' => __('Text color'),
                'title' => __('Text color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'bottom_section_border_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][bottom_section_border_top_color]',
                'label' => __('Border color'),
                'title' => __('Border color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'bottom_section_heading_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][bottom_section_heading_color]',
                'label' => __('Heading color'),
                'title' => __('Heading color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'bottom_section_link_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][bottom_section_link_color]',
                'label' => __('Link color'),
                'title' => __('Link color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $fieldset->addField(
            'bottom_section_link_hover_color',
            'fieldColor',
            [
                'name' => 'theme[custom_theme][footer][bottom_section_link_hover_color]',
                'label' => __('Link hover color'),
                'title' => __('Link hover color'),
                'css_class' => 'admin__field-control',
                'class' => 'input-text mColorPicker admin__control-text',
            ]
        );
        $this->_eventManager->dispatch('Wiki_vendorscustom_theme_vendors_tab_main_after', ['form' => $form, 'object' => $theme]);
        $themeConfig = $theme->getAllConfigs();
        // foreach($themeConfig as $path => $value){
        //     // $elementId = str_replace('/','_', $path);
        //     $fruits_arr = explode('/', $path);
        //     $element = $form->getElement($fruits_arr[2]);
        //     if($element){
        //         $element->setValue($value);
        //     }
        // }

        $themeConfig = $this->_configCollection->addFieldToFilter('theme_id', $theme->getId())->addFieldToFilter('vendor_id', $this->vendorSession->getVendor()->getId());
        foreach($themeConfig as $config){
            $fruits_arr = explode('/', $config["path"]);
            $element = $form->getElement($fruits_arr[2]);
            if($element){
                $element->setValue($config["value"]);
            }
        }

        $vendorThemeConfigs = $theme->getAllConfigsByVendor($this->vendorSession->getVendor());

        foreach($vendorThemeConfigs as $path=>$value){
            $elementId = str_replace('/','_', $path);
            $element = $form->getElement($elementId);
            if($element){
                $element->setValue($value);
            }
        }

        $this->setForm($form);
    }

}
