<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Ui\DataProvider\Product\Related;

/**
 * Class UpSellDataProvider
 *
 * @api
 * @since 101.0.0
 */
class UpSellDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    protected function getLinkType()
    {
        return 'up_sell';
    }
}
