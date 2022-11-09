<?php

namespace Wiki\VAT\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Catalog\Model\Product\Attribute\Repository as AttributeRepository;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Repository $_productAttributeRepository
     */
    protected $_productAttributeRepository;

    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var BlockFactory
     */
    protected $_blockFactory;

    /**
     * UpgradeData constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeRepository $attributeRepository
     * @param PageFactory $pageFactory
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        AttributeRepository $attributeRepository,
        PageFactory $pageFactory,
        BlockFactory $blockFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_productAttributeRepository = $attributeRepository;

        $this->_pageFactory = $pageFactory;
        $this->_blockFactory = $blockFactory;
    }
    

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // version 1.0.1
        if (version_compare($context->getVersion(), '1.0.1') < 0) {

            $block = [
                'title' => 'Block Popular Categories Menu Mobile',
                'identifier' => 'block_popular_categories_menu_mobile',
                'stores' => [0],
                'is_active' => 1,
                'content' => '
                <div class="nav-back">
                    <span>◄</span> Back to Main Menu
                </div>
                <div class="searchterms">
                    <ul>
                        <li class="list-heading">Popular Categories</li>
                        <li><a href="women-shopby-newarrivals/?icid=search_top_category">New Arrivals</a></li>
                        <li><a href="women-ourshops-wintercollection/?icid=search_top_category">Winter Collection</a></li>
                        <li><a href="keds-keds-she-bestsellers/?icid=search_top_category">Best Sellers</a></li>
                        <li><a href="women-styles-laceups/?icid=search_top_category">Lace Ups</a></li>
                        <li><a href="women-styles-slipons/?icid=search_top_category">Slip Ons</a></li>
                        <li><a href="women-styles-viewallkeds/?icid=search_top_category">View All</a></li>
                        <li><a href="women-ourcollections-riflepaperco/?icid=search_top_category">Keds x Rifle Paper Co.</a></li>
                        <li><a href="women-ourshops-kedsxkatespadenewyork-1/?icid=search_top_category">Keds x kate spade new york</a></li>
                    </ul>
                </div>'
            ];
            $this->_blockFactory->create()->setData($block)->save();
        }
    }
}