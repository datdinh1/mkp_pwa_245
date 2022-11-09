<?php
/*
 * Wiki_SampleImageUploader

 * @category   Wiki
 * @package    Wiki_SampleImageUploader
 * @copyright  Copyright (c) 2017 Wiki
 * @license    https://github.com/Wiki/magento2-sample-imageuploader/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Wiki\SampleImageUploader\Ui\Component\Listing\Column;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Wiki\SampleImageUploader\Model\Uploader;
class ImageUrl extends Column
{
    const ALT_FIELD = 'image_url';
    protected $escaper;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Wiki\HomeSliders\Model\Uploader
     */
    protected $imageModel;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Image constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Uploader $imageModel
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        UrlInterface $urlBuilder,
        Uploader $imageModel,
        array $components = [],
        array $data = []
    ) {
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageModel = $imageModel;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                    $url = 'test';      
            }
        }
        return $dataSource;
    }

}
