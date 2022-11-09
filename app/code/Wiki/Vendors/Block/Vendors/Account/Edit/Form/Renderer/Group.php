<?php

namespace Wiki\Vendors\Block\Vendors\Account\Edit\Form\Renderer;

/**
 * Widget Instance page groups (predefined layouts group) to display on
 *
 * @method \Magento\Widget\Model\Widget\Instance getWidgetInstance()
 */
class Group extends \Wiki\Vendors\Block\Vendors\Widget\Form\Renderer\Fieldset\Element
{
    protected $_template = 'Wiki_Vendors::account/form/renderer/fieldset/group.phtml';

    /**
     * @var \Wiki\Vendors\Model\Group
     */
    protected $_group;
    
    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\Group $group,
        array $data = []
    ) {
    
        $this->_group = $group;
        return parent::__construct($context, $data);
    }
    
    /**
     * Get vendor group
     * @return \Wiki\Vendors\Model\Group
     */
    public function getGroup()
    {
        if (!$this->_group->getId()) {
            $this->_group->load($this->getElement()->getEscapedValue());
        }
        
        return $this->_group;
    }
}
