<?php

/**
 * This block serves as a skeleton class to change the scope of a block definition. 
 * The template attribute on the block will now default to this module rather than the 
 * core module on the original block definition.
 */

namespace Wiki\VendorsProduct\Plugin\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\Data\ProductAttributeInterface;

class General extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\General
{
    /**
     * Add links for fields depends of product name
     *
     * @param  array $meta
     * @return array
     * @since  101.0.0
     */
    protected function customizeNameListeners(array $meta)
    {
        $listeners = [
            ProductAttributeInterface::CODE_SKU,
            ProductAttributeInterface::CODE_SEO_FIELD_META_TITLE,
            ProductAttributeInterface::CODE_SEO_FIELD_META_KEYWORD,
            ProductAttributeInterface::CODE_SEO_FIELD_META_DESCRIPTION,
        ];
        $textListeners = [
            ProductAttributeInterface::CODE_SEO_FIELD_META_KEYWORD,
            ProductAttributeInterface::CODE_SEO_FIELD_META_DESCRIPTION
        ];

        foreach ($listeners as $listener) {
            $listenerPath = $this->arrayManager->findPath($listener, $meta, null, 'children');
            $importsConfig = [
                'mask' => $this->locator->getStore()->getConfig('catalog/fields_masks/' . $listener),
                'component' => 'Magento_Catalog/js/components/import-handler',
                'allowImport' => !$this->locator->getProduct()->getId(),
            ];

            if (in_array($listener, $textListeners)) {
                $importsConfig['cols'] = 15;
                $importsConfig['rows'] = 2;
                $importsConfig['elementTmpl'] = 'ui/form/element/textarea';
            }

            $meta = $this->arrayManager->merge($listenerPath . static::META_CONFIG_PATH, $meta, $importsConfig);
        }

        $skuPath = $this->arrayManager->findPath(ProductAttributeInterface::CODE_SKU, $meta, null, 'children');
        $meta = $this->arrayManager->merge(
            $skuPath . static::META_CONFIG_PATH,
            $meta,
            [
                'autoImportIfEmpty' => true,
                'validation' => [
                    'no-marginal-whitespace' => true,
                    'letters-with-basic-punc' => true
                ]
            ]
        );

        $namePath = $this->arrayManager->findPath(ProductAttributeInterface::CODE_NAME, $meta, null, 'children');

        return $this->arrayManager->merge(
            $namePath . static::META_CONFIG_PATH,
            $meta,
            [
                'valueUpdate' => 'keyup'
            ]
        );
    }
}
