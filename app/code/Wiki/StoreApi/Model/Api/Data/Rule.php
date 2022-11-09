<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\StoreApi\Model\Api\Data;

class Rule extends \Magento\Framework\Api\AbstractExtensibleObject implements 
    \Wiki\StoreApi\Api\Data\RuleInterface
{

      /**
     * Get image
     *
     * @return $this
     */
    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }
     

    /**
     * Set image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

}
