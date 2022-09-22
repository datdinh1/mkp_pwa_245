<?php

namespace Wiki\VendorsCustomTheme\Controller\Vendors\Index;

use Magento\Framework\Exception\LocalizedException;

class Customize extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCustomTheme::theme';
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Wiki\VendorsCustomTheme\Model\ThemeFactory
     */
    protected $themeFactory;
    
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsCustomTheme\Model\ThemeFactory $themeFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Wiki\VendorsCustomTheme\Model\ThemeFactory $themeFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->themeFactory = $themeFactory;
        $this->_coreRegistry = $context->getCoreRegistry();
    }

    /**
     * Edit configuration section
     *
     * @return \Magento\Framework\App\ResponseInterface|void
     */
    public function execute()
    {
        try{
            $themeId = $this->getRequest()->getParam('id');
            $theme = $this->themeFactory->create()->load($themeId);
            if(!$themeId || !$theme->getId()){
                throw new LocalizedException(__("The theme is no longer available"));
            }
            $this->_coreRegistry->register('current_theme', $theme);
            $this->_coreRegistry->register('theme', $theme);
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $this->setActiveMenu('Wiki_VendorsConfig::configuration');
            $resultPage->getConfig()->getTitle()->set(__('Customize Theme'));
        }catch (LocalizedException $e){
            $this->messageManager->addError($e->getMessage());
            $resultPage = $this->resultRedirectFactory->create()->setUrl($this->getUrl('config/index/edit',['section' => 'custom_theme']));
        }catch(\Exception $e){
            $this->messageManager->addError(__('Something went wrong'));
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            $resultPage = $this->resultRedirectFactory->create()->setUrl($this->getUrl('config/index/edit',['section' => 'custom_theme']));
        }
        return $resultPage;
    }
}
