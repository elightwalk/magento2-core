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
 * @category  Elightwalk
 * @package   Elightwalk_Core
 * @copyright Copyright (c) Elightwalk (https://www.elightwalk.com/)
 * @license   https://store.elightwalk.com/licence
 */

declare(strict_types=1);

namespace Elightwalk\Core\Model;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
use Elightwalk\Core\Helper\Quote;
use Elightwalk\Core\Api\RestoreQuoteInterface;

class RestoreQuote implements RestoreQuoteInterface
{
    /**
     * @var CartRepositoryInterface
     */
    protected $_quoteRepository;

    /**
     * @var OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var Quote
     */
    protected $_quoteHelper;

    /**
     * __construct
     *
     * @param CartRepositoryInterface $quoteRepository
     * @param OrderFactory $orderFactory
     * @param Quote $quoteHelper
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        OrderFactory $orderFactory,
        Quote $quoteHelper
    ) {
        $this->_quoteRepository = $quoteRepository;
        $this->_orderFactory    = $orderFactory;
        $this->_quoteHelper     = $quoteHelper;
    }

    /**
     * @inheritdoc
     */
    public function restoreQuote(string $incrementId)
    {
        if (empty($incrementId)) {
            throw __('Required parameter "incrementId" is missing');
        }

        $order = $this->_orderFactory->create()->loadByIncrementId($incrementId);
        $this->_quoteHelper->restoreQuote($order);
        $quote = $this->_quoteRepository->get($order->getQuoteId());
        return [
            'model' => $quote->getData(),
        ];
    }
}
