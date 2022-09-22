<?php

namespace Wiki\VendorsSubAccount\Block\User\Edit\Tab;

use Magento\Framework\Registry;

/**
 * @api
 * @since 100.0.2
 */
class Roles extends \Wiki\Vendors\Block\Vendors\Widget\Grid\Extended implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('User Role');
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
        return !$this->getCurrentUser()->getIsSuperUser();
    }
    
    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Wiki\VendorsSubAccount\Model\ResourceModel\Role\CollectionFactory
     */
    protected $userRolesFactory;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $vendorSession;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Wiki\VendorsSubAccount\Model\ResourceModel\Role\CollectionFactory $userRolesFactory
     * @param \Wiki\Vendors\Model\Session $vendorSession
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Registry $coreRegistry,
        \Wiki\VendorsSubAccount\Model\ResourceModel\Role\CollectionFactory $userRolesFactory,
        \Wiki\Vendors\Model\Session $vendorSession,
        array $data = []
    ) {
        $this->jsonEncoder = $jsonEncoder;
        $this->userRolesFactory = $userRolesFactory;
        $this->coreRegistry = $coreRegistry;
        $this->vendorSession = $vendorSession;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('permissionsUserRolesGrid');
        $this->setDefaultSort('sort_order');
        $this->setDefaultDir('asc');
        $this->setTitle(__('User Roles Information'));
        $this->setUseAjax(true);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->userRolesFactory->create()->addFieldToFilter('vendor_id', $this->vendorSession->getVendor()->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'assigned_user_role',
            [
                'header_css_class' => 'data-grid-actions-cell',
                'header' => __('Assigned'),
                'type' => 'radio',
                'html_name' => 'role_id',
                'values' => $this->getSelectedRoles(),
                'align' => 'center',
                'index' => 'role_id'
            ]
        );

        $this->addColumn('assigned_user_role_name', ['header' => __('Role'), 'index' => 'role_name']);

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        $userPermissions = $this->getCurrentUser();
        return $this->getUrl('*/*/rolesGrid', ['user_id' => $userPermissions->getId()]);
    }

    /**
     * Get Current User
     * 
     * @return Ambigous <\Magento\Framework\mixed, NULL, multitype:>
     */
    public function getCurrentUser(){
        return $this->coreRegistry->registry('current_user');
    }
    
    /**
     * @param bool $json
     * @return array|string
     */
    public function getSelectedRoles($json = false)
    {
        return [$this->coreRegistry->registry('current_user')->getRoleId()];
    }
}
