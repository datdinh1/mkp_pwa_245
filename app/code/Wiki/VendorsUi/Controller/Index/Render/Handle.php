<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsUi\Controller\Index\Render;

use Magento\Framework\View\Element\Template;
use Magento\Ui\Component\Control\ActionPool;
use Magento\Ui\Component\Wrapper\UiComponent;
use Wiki\VendorsUi\Controller\Vendors\AbstractAction;

/**
 * Class Handle
 */
class Handle extends AbstractAction
{
    /**
     * Render UI component by namespace in handle context
     *
     * @return void
     */
    public function execute()
    {
        $handle = $this->_request->getParam('handle');
        $namespace = $this->_request->getParam('namespace');
        $buttons = $this->_request->getParam('buttons', false);

        $this->_view->loadLayout(['default', $handle], true, true, false);

        $uiComponent = $this->_view->getLayout()->getBlock($namespace);
        $response = $uiComponent instanceof UiComponent ? $uiComponent->toHtml() : '';

        if ($buttons) {
            $actionsToolbar = $this->_view->getLayout()->getBlock(ActionPool::ACTIONS_PAGE_TOOLBAR);
            $response .= $actionsToolbar instanceof Template ? $actionsToolbar->toHtml() : '';
        }

        $this->_response->appendBody($response);
    }
}
