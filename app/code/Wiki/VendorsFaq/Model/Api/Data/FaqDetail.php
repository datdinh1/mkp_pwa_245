<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsFaq\Model\Api\Data;
use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsFaq\Api\Data\FaqDetailInterface;

class FaqDetail extends AbstractModel implements FaqDetailInterface
{

    const CACHE_TAG = 'Wiki_faq_detail';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsFaq\Model\ResourceModel\FaqDetail');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * Get FAQ Id
     *
     * @return int
     */
    public function getFaqId()
    {
        return $this->getData(self::FAQ_ID);
    }

    /**
     * Set FAQ Id
     *
     * @param int $idFaq
     * @return $this
     */
    public function setFaqId($idFaq)
    {
        return $this->setData(self::FAQ_ID, $idFaq);
    }

    /**
     * Get Question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Set Question
     *
     * @param string $ques
     * @return $this
     */
    public function setQuestion($ques)
    {
        return $this->setData(self::QUESTION, $ques);
    }

    /**
     * Get Answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Set Answer
     *
     * @param string $anw
     * @return $this
     */
    public function setAnswer($anw)
    {
        return $this->setData(self::ANSWER, $anw);
    }
}
