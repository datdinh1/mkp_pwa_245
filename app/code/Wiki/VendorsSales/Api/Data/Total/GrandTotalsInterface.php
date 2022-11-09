<?php


namespace Wiki\VendorsSales\Api\Data\Total;
interface GrandTotalsInterface
{
    /**
     * Constants used as data array keys
     */
    const VENDOR_ID         = 'vendor_id';
    const TOTALS            = 'totals';

    /**
     * Get Vendor Id
     * @return string
     */
    public function getVendorId();

    /**
     * Set Vendor Id
     * @param string $vendorId
     *
     * @return $this
     */
    public function setVendorId($vendorId);

    /**
     * Get Totals
     * @return \Wiki\VendorsSales\Api\Data\Total\Data\TotalsInterface
     */
    public function getTotals();

    /**
     * Set Totals
     * @param \Wiki\VendorsSales\Api\Data\Total\Data\TotalsInterface $totals
     *
     * @return $this
     */
    public function setTotals($totals);
}