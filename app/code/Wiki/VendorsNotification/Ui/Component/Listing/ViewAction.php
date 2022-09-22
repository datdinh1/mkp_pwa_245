<?php
namespace Wiki\VendorsNotification\Ui\Component\Listing;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ViewAction extends Column
{
    const VIEW_AND_EDIT = 'wiki/notification/edit';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface        $context,
        UiComponentFactory      $uiComponentFactory,
        UrlInterface            $urlBuilder,
        array                   $components = [],
        array                   $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if ( isset($dataSource['data']['items']) ){
            foreach ( $dataSource['data']['items'] as & $item ){
                if ( isset($item['notification_id']) ){
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::VIEW_AND_EDIT,
                                [
                                    'id' => $item['notification_id']
                                ]
                            ),
                            'label' => __('View')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
