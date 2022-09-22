<?php

namespace Wiki\VendorsImportExport\Api;

interface ImportExportManagementInterface
{

    /** 
     * @param string $vendorId
     * @return \Wiki\VendorsImportExport\Api\ImportExportManagementInterface
     */
    public function getCSVProductByVendorId($vendorId);

    /**
     * @param string $vendorId
     * @return bool
     */
    public function importProductByVendorId($vendorId);
}
