<?php

namespace Wiki\VendorsSales\Cron;

use Magento\Framework\App\ResourceConnection;

class ResetIncrementEveryMonths
{

	protected $_logger;
	/**
	 * @param \Psr\Log\LoggerInterface $logger
	 */
	public function __construct(

		\Magento\Indexer\Model\Processor $processor,
		\Psr\Log\LoggerInterface $logger,
		ResourceConnection $resourceConnection
	) {
		$this->_logger                          = $logger;
		$this->_processor                       = $processor;
		$this->resourceConnection = $resourceConnection;
	}
	public function execute()
	{
		$this->_logger->info('Cron reset increment every months is works');

		$connection = $this->resourceConnection->getConnection();

		// set auto increment
		$tblSequenceOrder1 = $connection->getTableName('sequence_order_1');
		$query = "DELETE FROM `" . $tblSequenceOrder1 . "`";
		$connection->query($query);
		$query = "ALTER TABLE `" . $tblSequenceOrder1 . "` AUTO_INCREMENT=1";
		$connection->query($query);

		$this->_processor->reindexAll();
		$this->_processor->updateMview();
	}
}
