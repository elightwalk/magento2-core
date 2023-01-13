<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Elightwalk\Core\Graphql\Resolver\Quote;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfig;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Model\OrderFactory;
use Elightwalk\Core\Helper\Quote;


class RestoreQuote implements ResolverInterface
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
     * @param Quote $quoteHelper
     * @param ScopeConfig $scopeConfig
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        OrderFactory $orderFactory,
        Quote $quoteHelper
    ) {
        $this->_quoteRepository  = $quoteRepository;
        $this->_orderFactory = $orderFactory;
        $this->_quoteHelper  = $quoteHelper;
    }
    
    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['input'])) {
            throw new GraphQlInputException(__('Input parameter is missing'));
        }

        if (!isset($args['input']['increment_id']) && empty($args['input']['increment_id'])) {
            throw new GraphQlInputException(__('Required parameter "incrementId" is missing'));
        }

        $incrementId = $args['input']['increment_id'];
        $order   = $this->_orderFactory->create()->loadByIncrementId($incrementId);
        $this->_quoteHelper->restoreQuote($order);
        $quote = $this->_quoteRepository->get($order->getQuoteId());
        return [
            'model' => $quote,
        ];
    }
}
