<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsUi\Controller\Vendors\Export;

use Wiki\VendorsUi\Controller\Vendors\AbstractAction;
use Wiki\Vendors\App\Action\Context;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Model\Export\ConvertToCsv;
use Magento\Framework\App\Response\Http\FileFactory;

/**
 * Class Render
 */
class GridToCsv extends AbstractAction
{
    /**
     * @var ConvertToCsv
     */
    protected $converter;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @param Context $context
     * @param ConvertToCsv $converter
     * @param UiComponentFactory $factory
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        ConvertToCsv $converter,
        UiComponentFactory $factory,
        FileFactory $fileFactory
    ) {
        parent::__construct($context, $factory);
        $this->converter = $converter;
        $this->fileFactory = $fileFactory;
    }

    /**
     * Export data provider to CSV
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        return $this->fileFactory->create('export.csv', $this->converter->getCsvFile(), 'var');
    }
}
