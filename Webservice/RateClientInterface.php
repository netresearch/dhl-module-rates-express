<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Webservice;

use Dhl\Express\Api\Data\RateRequestInterface;
use Dhl\Express\Api\Data\RateResponseInterface;

/**
 * Interface RateClientInterface
 *
 * @package Dhl\ExpressRates\Webservice
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
interface RateClientInterface
{
    /**
     * @param RateRequestInterface $request
     * @return RateResponseInterface
     * @throws \Dhl\Express\Exception\RateRequestException
     * @throws \Dhl\Express\Exception\SoapException
     */
    public function performRatesRequest(RateRequestInterface $request);
}
