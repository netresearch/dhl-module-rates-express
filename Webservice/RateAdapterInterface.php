<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Webservice;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\AbstractResult;

/**
 * Interface RateAdapterInterface
 *
 * @package Dhl\ExpressRates\Webservice
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
interface RateAdapterInterface
{
    /**
     * Fetch Rates through API client
     *
     * @param RateRequest $request
     * @return AbstractResult[]
     */
    public function getRates(RateRequest $request): array;
}
