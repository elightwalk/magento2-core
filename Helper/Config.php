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

namespace Elightwalk\Core\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Module\Manager;
use Psr\Log\LoggerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\HTTP\Header;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Cache\ConfigInterface;
use Magento\Framework\App\Helper\Context;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Helper module name
     *
     * @var string
     */
    protected $_moduleName;

    /**
     * Request object
     *
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var Manager
     */
    protected $_moduleManager;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var Header
     */
    protected $_httpHeader;

    /**
     * Event manager
     *
     * @var ManagerInterface
     */
    protected $_eventManager;

    /**
     * @var RemoteAddress
     */
    protected $_remoteAddress;

    /**
     * @var EncoderInterface
     */
    protected $_urlEncoder;

    /**
     * @var DecoderInterface
     */
    protected $_urlDecoder;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var ConfigInterface
     */
    protected $_cacheConfig;

    /**
     * __construct
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context
    ) {
        $this->_moduleManager = $context->getModuleManager();
        $this->_logger = $context->getLogger();
        $this->_request = $context->getRequest();
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_httpHeader = $context->getHttpHeader();
        $this->_eventManager = $context->getEventManager();
        $this->_remoteAddress = $context->getRemoteAddress();
        $this->_cacheConfig = $context->getCacheConfig();
        $this->_urlEncoder = $context->getUrlEncoder();
        $this->_urlDecoder = $context->getUrlDecoder();
        $this->_scopeConfig = $context->getScopeConfig();

        parent::__construct($context);
    }

    /**
     * GetModuleConfig
     *
     * @param string $path
     * @param int|null $storeId
     * @return void
     */
    public function getModuleConfig($path, $storeId = null)
    {
        return $this->_scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
