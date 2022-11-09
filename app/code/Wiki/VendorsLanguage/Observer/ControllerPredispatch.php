<?php
namespace Wiki\VendorsLanguage\Observer;

use Magento\Framework\Event\ObserverInterface;

class ControllerPredispatch implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $localeResolver;

    /**
     * @var \Magento\Framework\TranslateInterface
     */
    protected $translate;
    
    /**
     * @var \Wiki\VendorsConfig\Helper\Data
     */
    protected $vendorConfig;

    /**
     * @var \Wiki\VendorsLanguage\Helper\Data
     */
    protected $adminConfig;

    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $vendorSession;

    /**
     * ControllerPredispatch constructor.
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param \Magento\Framework\TranslateInterface $translate
     * @param \Wiki\VendorsConfig\Helper\Data $vendorConfig
     * @param Wiki\VendorsLanguage\Helper\Data $adminConfig
     * @param \Wiki\Vendors\Model\Session $vendorSession
     */
    public function __construct(
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Magento\Framework\TranslateInterface $translate,
        \Wiki\VendorsConfig\Helper\Data $vendorConfig,
        \Wiki\VendorsLanguage\Helper\Data $adminConfig,
        \Wiki\Vendors\Model\Session $vendorSession
    ) {
        $this->localeResolver = $localeResolver;
        $this->translate = $translate;
        $this->vendorConfig = $vendorConfig;
        $this->adminConfig = $adminConfig;
        $this->vendorSession = $vendorSession;
    }

    /**
     * Add the notification if there are any vendor awaiting for approval.
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $vendorLocaleCode = $this->vendorConfig->getVendorConfig('general/locale/code', $this->vendorSession->getVendor()->getId());
        $adminLocaleCode = $this->adminConfig->getDefaultLanguageVendor();

        if (!$vendorLocaleCode && $adminLocaleCode) {
            $vendorLocaleCode = $adminLocaleCode;
        }
        $this->localeResolver->setLocale($vendorLocaleCode);
        $this->translate->setLocale($vendorLocaleCode);
        $this->translate->loadData(\Wiki\Vendors\app\Area\FrontNameResolver::AREA_CODE, false);
    }
}
