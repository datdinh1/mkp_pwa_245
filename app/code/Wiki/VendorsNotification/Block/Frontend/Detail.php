<?php
namespace Wiki\VendorsNotification\Block\Frontend;

use Wiki\SmsNotification\Model\NewsFactory;
class Detail extends \Magento\Framework\View\Element\Template
{
	

	protected $request;

    protected $_newsFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        NewsFactory $newsFactory
    )
	{
		parent::__construct($context);
        $this->request = $request;
        $this->_newsFactory = $newsFactory;
	}

	public function getNotibyId()
    {
        // use 
      
            $idPost = $this->request->getParam('id');

            $notiAdmin = $this->_newsFactory->create()->getCollection();
            $listNotiAdmin = $notiAdmin->addFieldToFilter('id', $idPost)->getFirstItem();

            return ($listNotiAdmin->getData());
                        
    }

}