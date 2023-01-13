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

namespace Elightwalk\Core\Api;

interface RestoreQuoteInterface
{
    /**
     * Get Restore Quote
     *
     * @param string $incrementId
     * @return mixed|null
     */
    public function getRestoreQuote(string $incrementId);
}
