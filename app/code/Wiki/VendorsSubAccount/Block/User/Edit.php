<?php

namespace Wiki\VendorsSubAccount\Block\User;

class Edit extends \Wiki\Vendors\Block\Vendors\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize form
     * Add standard buttons
     * Add "Save and Apply" button
     * Add "Save and Continue" button
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'user_id';
        $this->_blockGroup = 'Wiki_VendorsSubAccount';
        $this->_controller = 'User';
        
        parent::_construct();
        $this->updateButton('save', 'label', __('Save User'));

        $user = $this->coreRegistry->registry('current_user');
        if($user->getIsSuperUser()){
            $this->removeButton('delete');
        }
        
        return $this;
    }

    /**
     * Getter for form header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $user = $this->coreRegistry->registry('current_user');
        if ($user->getEntityId()) {
            return __("Edit User '%s'", $this->escapeHtml($user->getName()));
        } else {
            return __('New User');
        }
    }
}
