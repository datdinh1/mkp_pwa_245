<?php
/**
 * Default application path for backend area
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\App;

/**
 * Backend config accessor
 */
interface ConfigInterface
{
    /**
     * Retrieve config value by path
     *
     * @param string $path
     * @return mixed
     * @api
     */
    public function getValue($path);

    /**
     * Set config value
     *
     * @param string $path
     * @param mixed $value
     * @return void
     * @api
     */
    public function setValue($path, $value);

    /**
     * Retrieve config flag
     *
     * @param string $path
     * @return bool
     * @api
     */
    public function isSetFlag($path);
}
