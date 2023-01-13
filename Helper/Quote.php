<?php

/**
 * Elightwalk
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Elightwalk.com license that is
 * available through the world-wide-web at this URL:
 * https://store.elightwalk.com/licence
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Elightwalk
 * @package     Elightwalk_Core
 * @copyright   Copyright (c) Elightwalk (https://www.elightwalk.com/)
 * @license     https://store.elightwalk.com/licence
 */

namespace Elightwalk\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\Session\StorageInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Sales\Model\Order;

class Quote extends AbstractHelper
{
    /**
     * @var CartRepositoryInterface
     */
    protected $_quoteRepository;
    /**
     * @var StorageInterface
     */
    protected $_storageInterface;
    /**
     * @var ManagerInterface
     */
    protected $_eventManager;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * __construct
     *
     * @param Context $context
     * @param CartRepositoryInterface $quoteRepository
     * @param StorageInterface $storageInterface
     * @param ManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        CartRepositoryInterface $quoteRepository,
        StorageInterface $storageInterface,
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_quoteRepository  = $quoteRepository;
        $this->_storageInterface = $storageInterface;
        $this->_eventManager     = $eventManager;
        $this->_storeManager     = $storeManager;
    }
    public function restoreQuote($order)
    {
        /** @var Order $order */
        if ($order->getId()) {
            try {
                $quote = $this->_quoteRepository->get($order->getQuoteId());
                $quote->setIsActive(1)->setReservedOrderId(null);
                $this->_quoteRepository->save($quote);
                $this->replaceQuote($quote, $order);
                $this->_eventManager->dispatch('restore_quote', ['order' => $order, 'quote' => $quote]);
                return true;
            } catch (NoSuchEntityException $e) {
                throw new GraphQlInputException(__($e->getMessage()));
            }
        }
        return false;
    }

    /**
     * Replace the quote in the session with a specified object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @return $this
     */
    public function replaceQuote($quote, $order)
    {
        $this->setQuoteId($quote->getId(), $order);
        return $this;
    }
    
    /**
     * Set the current session's quote id
     *
     * @param int $quoteId
     * @return void
     * @codeCoverageIgnore
     */
    public function setQuoteId($quoteId, $order)
    {
        $quoteIdKey = 'quote_id_' . $this->_storeManager->getStore($order->getStoreId())->getWebsiteId();
        $this->_storageInterface->setData($quoteIdKey, $quoteId);
    }
}
