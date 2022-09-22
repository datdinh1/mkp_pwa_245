<?php
namespace Wiki\VendorsImportExport\Model;

use Wiki\VendorsImportExport\Api\ImportExportManagementInterface;
use Wiki\VendorsImportExport\Model\Export\ExportManagement;
use Wiki\VendorsImportExport\Model\Import\ImportManagement;
use Magento\Framework\Webapi\Rest\Response\RendererInterface;
use Magento\Framework\Webapi\Exception as WebApiException;

class ImportExportManagement implements ImportExportManagementInterface
{
    /**
     * Renderer mime type.
     */
    const MIME_TYPE = 'multipart/form-data';

    /**
     * @var ExportManagement
     */
    protected $exportManagement;

    /**
     * @var ImportManagement
     */
    protected $importManagement;

    public function __construct(
        ExportManagement $exportManagement,
        ImportManagement $importManagement
    ) {
        $this->exportManagement = $exportManagement;
        $this->importManagement = $importManagement;
    }

    /**
     * @inheritdoc
     */
    public function getCSVProductByVendorId($vendorId)
    {
        return $this->exportManagement->exportProductByVendorId($vendorId);
    }

    public function importProductByVendorId($vendorId)
    {
        
        $this->importManagement->importProductByVendorId($vendorId);
    }
}
