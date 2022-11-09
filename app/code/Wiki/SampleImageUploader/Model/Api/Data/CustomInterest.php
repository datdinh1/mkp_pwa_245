<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\SampleImageUploader\Model\Api\Data;
use Magento\Framework\Model\AbstractModel;
use Wiki\SampleImageUploader\Api\Data\CustomInterestInterface;

class CustomInterest extends AbstractModel implements CustomInterestInterface
{




    /**
     * Get General
     *
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterface

     */
    public function getGeneral()
    {
        return $this->getData(self::GENERAL);
    }

    /**
     * Set General
     *
     * @param \Wiki\SampleImageUploader\Api\Data\ImageInterface $general
     * @return $this
     */
    public function setGeneral($general)
    {
        return $this->setData(self::GENERAL, $general);
    }

    /**
     * Get Info
     *
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterestInterface[]
     */
    public function getInfo()
    {
        return $this->getData(self::INFO);
    }

    /**
     * Set Info
     *
     * @param \Wiki\SampleImageUploader\Api\Data\ImageInterestInterface[] $info
     * @return $this
     */
    public function setInfo($info)
    {
        return $this->setData(self::INFO, $info);
    }

}
