<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\Attribute\Backend;

use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;

class Avatar extends AbstractBackend
{
    /**
     * @var File
     */
    private $io;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param File $io
     * @param Filesystem $filesystem
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        File $io,
        Filesystem $filesystem,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->io = $io;
        $this->filesystem = $filesystem;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    public function beforeSave($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        if ($attrCode == 'profile_picture') {
            $image = $object->getData('profile_picture');
            if (!empty($image) && base64_decode($image, true) == true) {
                $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                $uploadPath = $mediaPath . 'avatar/';
                if (!is_dir($uploadPath)) {
                    $this->io->mkdir($uploadPath, 0777);
                }
                $dataBase64 = base64_decode($image);
                $f = finfo_open();
                $mimeType = finfo_buffer($f, $dataBase64, FILEINFO_MIME_TYPE);
                $type = explode('/', $mimeType)[1];
                $imageUrl = strtotime("now") . "-" . uniqid() . '.' . $type;
                file_put_contents($uploadPath . $imageUrl, $dataBase64);
                $object->setData('profile_picture', $imageUrl);
                try {
                    $customer = $this->customerRepository->getById($object->getId());
                    if ($customer->getId()) {
                        $attrAvatar = $customer->getCustomAttribute('profile_picture');
                        if ($attrAvatar !== null) {
                            $value = $attrAvatar->getValue();
                            if (!empty($value)) {
                                @unlink($uploadPath . $value);
                            }
                        }
                    }
                }
                catch (\Exception $e) { }
            }
            else {
                $object->unsetData('profile_picture');
            }
        }
        return parent::beforeSave($object);
    }
}
