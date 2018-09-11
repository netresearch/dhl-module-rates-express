<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Api\Data;

/**
 * Interface MethodAdditionalInfoInterface
 *
 * @package Dhl\ExpressRates\Api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
interface MethodAdditionalInfoInterface
{
    const ATTRIBUTE_KEY = 'additional_info';
    const DELIVERY_DATE = 'delivery_date';

    /**
     * @return string
     */
    public function getDeliveryDate();

    /**
     * @param string $deliveryDate
     * @return void
     */
    public function setDeliveryDate($deliveryDate);
}
