<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Webservice\Rate;

use Dhl\Express\Api\Data\RateRequestInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Interface RequestDataMapperInterface
 *
 * @package Dhl\ExpressRates\Webservice\Rate
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
interface RequestDataMapperInterface
{
    /**
     * Maps the available application data to the DHL Express specific request object
     *
     * @param RateRequest $request
     * @return RateRequestInterface
     */
    public function mapRequest(RateRequest $request);
}
