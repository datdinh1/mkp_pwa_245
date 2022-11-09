<?php
/*
 * Wiki_SampleImageUploader

 * @category   Wiki
 * @package    Wiki_SampleImageUploader


 */
namespace Wiki\VendorsFaq\Api;

use Wiki\VendorsFaq\Api\Data\FaqInterface;

use Magento\Framework\Exception\InputException;


/**
 * @api
 */
interface FaqRepositoryInterface
{
    /**
     * Save page.
     *
     * @param Wiki\VendorsFaq\Api\Data\FaqInterface $entity
     * @return \Wiki\VendorsFaq\Api\Data\FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveFaq( $entity);

     /**
     *
     * @param string $vendorId
     * @return \Wiki\VendorsFaq\Api\Data\FaqInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFaqByVendorId( $vendorId);

    /**
     *
     * @param int $idFaq
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteFaq( $idFaq);

}
