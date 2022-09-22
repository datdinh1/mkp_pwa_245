<?php

namespace Wiki\VendorsSubAccount\Block\User\Edit\Tab;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\Registry;

/**
 * implementing now
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Main extends \Wiki\Vendors\Block\Vendors\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var CustomerMetadataInterface
     */
    protected $customerMetadata;

    /**
     * @var array
     */
    protected $attributes = [];
    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('User Info');
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
     * Main constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param CustomerMetadataInterface $customerMetadata
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        CustomerMetadataInterface $customerMetadata,
        array $data = []
    ) {
        $this->customerMetadata = $customerMetadata;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    
    /**
     * @return void
     */
    protected function _initForm()
    {
        $user = $this->_coreRegistry->registry('current_user');
        
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('User Information')]);

        if(!$user->getIsSuperUser()){
            $fieldset->addField(
                'is_active_user',
                'select',
                [
                    'name' => 'is_active_user',
                    'label' => __('Is Active'),
                    'id' => 'is_active_user',
                    'css_class' => 'admin__field-control',
                    'required' => false,
                    'options' => ['0' => __('No') , '1' => __('Yes')]
                ]
            );
        }
        $fieldset->addField(
            'firstname',
            'text',
            [
                'name' => 'firstname',
                'label' => __('First Name'),
                'id' => 'firstname',
                'css_class' => 'admin__field-control',
                'required' => true
            ]
            );
        $fieldset->addField(
            'lastname',
            'text',
            [
                'name' => 'lastname',
                'label' => __('Last Name'),
                'id' => 'lastname',
                'css_class' => 'admin__field-control',
                'required' => true
            ]
        );

        if($this->isEnabledAttribute('dob')){
            $fieldset->addType('custom_date','Wiki\VendorsSubAccount\Block\User\Edit\Form\Element\Date');
            $fieldset->addField(
                'dob',
                'custom_date',
                [
                    'name' => 'dob',
                    'label' => __('Date of Birth'),
                    'id' => 'dob',
                    'input_format' => \Magento\Framework\Stdlib\DateTime::DATE_INTERNAL_FORMAT,
                    'date_format' => 'yyyy-M-d',
                    'css_class' => 'admin__field-control',
                    'required' => $this->isRequiredAttribute('dob'),
                ]
            );
        }

        if($this->isEnabledAttribute('taxvat')){
            $fieldset->addField(
                'taxvat',
                'text',
                [
                    'name' => 'taxvat',
                    'label' => __('Tax/VAT'),
                    'id' => 'taxvat',
                    'css_class' => 'admin__field-control',
                    'required' => $this->isRequiredAttribute('taxvat'),
                ]
            );
        }

        if($this->isEnabledAttribute('gender')){
            $genderOptions = [];
            foreach($this->_getAttribute('gender')->getOptions() as $option){
                $genderOptions[$option->getValue()] = $option->getLabel();
            }

            $fieldset->addField(
                'gender',
                'select',
                [
                    'name' => 'gender',
                    'label' => __('Gender'),
                    'id' => 'gender',
                    'css_class' => 'admin__field-control',
                    'required' => $this->isRequiredAttribute('gender'),
                    'options' => $genderOptions,
                ]
            );
        }



        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'id' => 'email',
                'class' => 'validate-email',
                'css_class' => 'admin__field-control',
                'required' => true,
            ]
        );
        
        $fieldset->addField(
            'password',
            'password',
            [
                'name' => 'password',
                'label' => __('Password'),
                'id' => 'password',
                'class' => 'validate-admin-password',
                'css_class' => 'admin__field-control',
                'required' => !$user->getId(),
            ]
        );
        
        $fieldset->addField(
            'password_confirmation',
            'password',
            [
                'name' => 'password_confirmation',
                'label' => __('Password Confirmation'),
                'id' => 'password_confirmation',
                'class' => 'validate-cpassword',
                'css_class' => 'admin__field-control',
                'required' => !$user->getId(),
            ]
        );

        $fieldset->addField('user_id', 'hidden', ['name' => 'user_id', 'id' => 'user_id']);

        $fieldset = $form->addFieldset('current_user_fieldset', ['legend' => __('Current User Identity Verification')]);
        $fieldset->addField(
            'current_password',
            'password',
            [
                'name' => 'current_password',
                'label' => __('Your Password'),
                'id' => 'current_password',
                'class' => 'required-entry',
                'css_class' => 'admin__field-control',
                'required' => true,
            ]
        );
        if(!$user->getId()){
            $user->setIsActiveUser(1);
        }
        $form->setValues($user->getData());
        $form->getElement('user_id')->setValue($user->getId());
        
        $this->setForm($form);
    }

    /**
     * Check if dob attribute enabled in system
     *
     * @return bool
     */
    public function isEnabledAttribute($attrCode)
    {
        $attributeMetadata = $this->_getAttribute($attrCode);
        return $attributeMetadata ? (bool)$attributeMetadata->isVisible() : false;
    }

    /**
     * Check if dob attribute marked as required
     *
     * @return bool
     */
    public function isRequiredAttribute($attrCode)
    {
        $attributeMetadata = $this->_getAttribute('dob');
        return $attributeMetadata ? (bool)$attributeMetadata->isRequired() : false;
    }

    /**
     * Retrieve customer attribute instance
     *
     * @param string $attributeCode
     * @return \Magento\Customer\Api\Data\AttributeMetadataInterface|null
     */
    protected function _getAttribute($attributeCode)
    {
        if(isset($this->attributes[$attributeCode])) return $this->attributes[$attributeCode];

        try {
            $this->attributes[$attributeCode] = $this->customerMetadata->getAttributeMetadata($attributeCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->attributes[$attributeCode] = null;
        }
        return $this->attributes[$attributeCode];
    }

}
