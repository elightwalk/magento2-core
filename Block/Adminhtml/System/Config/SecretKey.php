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

declare(strict_types=1);

namespace Elightwalk\Core\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\Config\Storage\WriterInterface;

class SecretKey extends Field
{
    /**
     * @var WriterInterface
     */
    protected $_configWriter;

    /**
     * Constructor
     *
     * @param Context $context
     * @param WriterInterface $configWriter
     * @param array $data
     */
    public function __construct(
        Context $context,
        WriterInterface $configWriter,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_configWriter = $configWriter;
    }

    /**
     * Render
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->setReadonly(true);
        $value =  $element->getValue();
        if(!$value) {
            $key = md5(microtime().rand());
            $element->setValue($key);
            $this->_configWriter->save('elightwalk/general/secret_key',$key);
        }
        return parent::render($element);
    }
}
