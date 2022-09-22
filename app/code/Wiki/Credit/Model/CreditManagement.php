<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Model;

use Wiki\Credit\Api\CreditManagementInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CreditManagement implements CreditManagementInterface
{
    /**
     * Quote repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;
    
    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $creditAccountFactory;
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * Constructs a coupon read service object.
     *
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository Quote repository.
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->creditAccountFactory = $creditAccountFactory;
        $this->_scopeConfig                 = $scopeConfig;
    }
    
    /**
     * {@inheritdoc}
     */
    public function get($cartId)
    {
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        return $quote->getCreditAmount();
    }
    
    /**
     * {@inheritdoc}
     */
    public function set($cartId, $creditAmount)
    {
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $customerId = $quote->getCustomerId();
        
        if(!$customerId){
            throw new CouldNotSaveException(__('You need to login to use this action'));
        }
        
        /*Check if the used credit amount is greater than credit balance*/
        $creditAccount = $this->creditAccountFactory->create();
        $creditAccount->loadByCustomerId($customerId);
        if($creditAmount > $creditAccount->getCredit()){
            throw new CouldNotSaveException(__('You can\'t apply the amount which is greater than your credit balance'));
        }
        
        $quote->getShippingAddress()->setCollectShippingRates(true);
    
        try {
            $quote->setBaseCreditAmount($creditAmount)->collectTotals();
            $this->quoteRepository->save($quote);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not apply credit'));
        }

        return [$quote->getBaseCreditAmount(), $quote->getCreditAmount()];
    }
    
    /**
     * {@inheritdoc}
     */
    public function remove($cartId)
    {
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $quote->getShippingAddress()->setCollectShippingRates(true);
        try {
            $quote->setBaseCreditAmount(0)->setCreditAmount(0)->collectTotals();
            $this->quoteRepository->save($quote);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not remove credit'));
        }
        if ($quote->getCreditAmount() != 0) {
            throw new CouldNotDeleteException(__('Could not remove credit'));
        }
        return true;
    }

     /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $data = $this->_scopeConfig ->getValue(
            'credit',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $data;
    }
}
