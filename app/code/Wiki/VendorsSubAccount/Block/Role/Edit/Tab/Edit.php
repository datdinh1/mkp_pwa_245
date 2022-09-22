<?php
namespace Wiki\VendorsSubAccount\Block\Role\Edit\Tab;

use Magento\User\Controller\Adminhtml\User\Role\SaveRole;

/**
 * Rolesedit Tab Display Block.
 *
 * @api
 * @since 100.0.2
 */
class Edit extends \Wiki\Vendors\Block\Vendors\Widget\Form implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'role/edit.phtml';

    /**
     * Root ACL Resource
     *
     * @var \Wiki\VendorsAcl\Model\AclResource\RootResource
     */
    protected $rootResource;

    /**
     * Rules collection factory
     *
     * @var \Magento\Authorization\Model\ResourceModel\Rules\CollectionFactory
     */
    protected $rulesCollectionFactory;

    /**
     * Acl builder
     *
     * @var \Magento\Authorization\Model\Acl\AclRetriever
     */
    protected $aclRetriever;

    /**
     * Acl resource provider
     *
     * @var \Magento\Framework\Acl\AclResource\ProviderInterface
     */
    protected $aclResourceProvider;

    /**
     * @var \Magento\Integration\Helper\Data
     */
    protected $integrationData;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever
     * @param \Wiki\VendorsAcl\Model\AclResource\RootResource $rootResource
     * @param \Magento\Authorization\Model\ResourceModel\Rules\CollectionFactory $rulesCollectionFactory
     * @param \Magento\Framework\Acl\AclResource\ProviderInterface $aclResourceProvider
     * @param \Magento\Integration\Helper\Data $integrationData
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever,
        \Wiki\VendorsAcl\Model\AclResource\RootResource $rootResource,
        \Magento\Authorization\Model\ResourceModel\Rules\CollectionFactory $rulesCollectionFactory,
        \Magento\Framework\Acl\AclResource\ProviderInterface $aclResourceProvider,
        \Magento\Integration\Helper\Data $integrationData,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->aclRetriever = $aclRetriever;
        $this->rootResource = $rootResource;
        $this->rulesCollectionFactory = $rulesCollectionFactory;
        $this->aclResourceProvider = $aclResourceProvider;
        $this->integrationData = $integrationData;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }


    /**
     * Get tab label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Role Resources');
    }

    /**
     * Get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Whether tab is available
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Whether tab is visible
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check if everything is allowed
     *
     * @return bool
     */
    public function isEverythingAllowed()
    {
        $selectedResources = $this->getSelectedResources();
        $id = $this->rootResource->getId();
        return in_array($id, $selectedResources);
    }

    /**
     * Get selected resources
     *
     * @return array|mixed|\string[]
     * @since 100.1.0
     */
    public function getSelectedResources()
    {
        $selectedResources = $this->getData('selected_resources');
        if (empty($selectedResources)) {
            $selectedResources = $this->coreRegistry->registry('current_role')->getSelectedResources();
            $this->setData('selected_resources', $selectedResources);
        }
        return $selectedResources;
    }

    /**
     * Get Json Representation of Resource Tree
     *
     * @return array
     */
    public function getTree()
    {
        return $this->integrationData->mapResources($this->getAclResources());
    }

    /**
     * Get lit of all ACL resources declared in the system.
     *
     * @return array
     */
    private function getAclResources()
    {
        $resources = $this->aclResourceProvider->getAclResources();        
        $configResource = array_filter(
            $resources,
            function ($node) {
                return $node['id'] == 'Wiki_Vendors::vendor';
            }
        );
        $configResource = reset($configResource);
        return isset($configResource['children']) ? $configResource['children'] : [];
    }
}
