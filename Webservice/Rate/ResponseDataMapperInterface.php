<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Webservice\Rate;

use Dhl\Express\Api\Data\RateResponseInterface;
use Magento\Quote\Model\Quote\Address\RateResult\Method;

/**
 * Interface ResponseDataMapperInterface
 *
 * @package Dhl\ExpressRates\Webservice\Rate
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
interface ResponseDataMapperInterface
{
    /**
     * Map rate response shipping products into Magento rate result methods
     *
     * @param RateResponseInterface $rateResponse
     * @return Method[]
     */
    public function mapResult(RateResponseInterface $rateResponse);
}
