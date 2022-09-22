<?php

namespace Wiki\Cms\Model\Resolver;

use Magento\CmsGraphQl\Model\Resolver\DataProvider\Block as BlockDataProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Cms\Model\BlockFactory;

/**
 * CMS blocks field resolver, used for GraphQL request processing
 */
class Blocks extends \Magento\CmsGraphQl\Model\Resolver\Blocks implements ResolverInterface
{
    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var BlockDataProvider
     */
    private $blockDataProvider;

    /**
     * @param BlockDataProvider $blockDataProvider
     */
    public function __construct(
        BlockDataProvider $blockDataProvider,
        BlockFactory $blockFactory
    ) {
        $this->blockDataProvider = $blockDataProvider;
        $this->blockFactory = $blockFactory;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $blockIdentifiers = $this->getBlockIdentifiers($args);
        $blocksData = $this->getBlocksData($blockIdentifiers);
        $data = [];
        foreach ($blockIdentifiers as $key) {
           if(!count($blocksData[$key])){
            throw new NoSuchEntityException(
                __('The CMS block with the "%1" ID doesn\'t exist.', $key)
            );
           }
           $data += array_merge($data, $blocksData[$key]);
        }
        $resultData = [
            'items' => $data,
        ];
        return $resultData;
    }

    /**
     * Get block identifiers
     *
     * @param array $args
     * @return string[]
     * @throws GraphQlInputException
     */
    private function getBlockIdentifiers(array $args): array
    {
        if (!isset($args['identifiers']) || !is_array($args['identifiers']) || count($args['identifiers']) === 0) {
            throw new GraphQlInputException(__('"identifiers" of CMS blocks should be specified'));
        }
        return $args['identifiers'];
    }

    /**
     * Get blocks data
     *
     * @param array $blockIdentifiers
     * @return array
     * @throws GraphQlNoSuchEntityException
     */

     private function getBlocksData(array $blockIdentifiers): array
    {
        $blocksData = [];
        foreach ($blockIdentifiers as $blockIdentifier) {
            try {
                $blocksData[$blockIdentifier] = $this->blockDataProvider->getData($blockIdentifier);
            } catch (NoSuchEntityException $e) {
                $blocksData[$blockIdentifier] = new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
            }
        }
        return $blocksData;
    }
}
