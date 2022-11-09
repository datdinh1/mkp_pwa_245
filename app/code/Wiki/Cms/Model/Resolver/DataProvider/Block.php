<?php
namespace Wiki\Cms\Model\Resolver\DataProvider;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Template\FilterEmulate;

/**
 * Cms block data provider
 */
class Block extends \Magento\CmsGraphQl\Model\Resolver\DataProvider\Block
{
    const FIELDACTIVE = 'is_active';
    const ACTIVE = 1;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var FilterEmulate
     */
    private $widgetFilter;

    /**
     * @param BlockRepositoryInterface $blockRepository
     * @param FilterEmulate $widgetFilter
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        FilterEmulate $widgetFilter,
        BlockFactory $blockFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->blockRepository = $blockRepository;
        $this->widgetFilter = $widgetFilter;
        $this->blockFactory = $blockFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get block data
     *
     * @param string $blockIdentifier
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(string $blockIdentifier): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(self::FIELDACTIVE, self::ACTIVE)->create();
        $cmsBlocks = $this->blockRepository->getList($searchCriteria)->getItems(); //LocalizedException
        $arrayData = [];
        foreach ($cmsBlocks as $value) {
            if(strpos($value->getIdentifier(), $blockIdentifier) !== false){
                    $renderedContent = $this->widgetFilter->filterDirective($value->getContent());
                    $blockData = [
                        BlockInterface::BLOCK_ID => $value->getId(),
                        BlockInterface::IDENTIFIER => $value->getIdentifier(),
                        BlockInterface::TITLE => $value->getTitle(),
                        BlockInterface::CONTENT => $renderedContent,
                    ];
                array_push($arrayData,$blockData);
            }
        }
        return $arrayData;
    }
}
