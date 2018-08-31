<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

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
    const CARRIER_LOGO_URL = 'carrier_logo_url';

    /**
     * @return string
     */
    public function getDeliveryDate(): string;

    /**
     * @param string $deliveryDate
     * @return void
     */
    public function setDeliveryDate(string $deliveryDate);

    /**
     * @return string
     */
    public function getCarrierLogoUrl(): string;

    /**
     * @param string $carrierLogoUrl
     * @return void
     */
    public function setCarrierLogoUrl(string $carrierLogoUrl);
}
