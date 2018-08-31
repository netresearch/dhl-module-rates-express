<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Model\Method;

use Dhl\ExpressRates\Api\Data\MethodAdditionalInfoInterface;
use Magento\Framework\DataObject;

/**
 * Class AdditionalInfo
 *
 * @package Dhl\ExpressRates\Model
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
final class AdditionalInfo extends DataObject implements MethodAdditionalInfoInterface
{
    /**
     * @inheritdoc
     */
    public function getDeliveryDate(): string
    {
        return (string)$this->getData(self::DELIVERY_DATE);
    }

    /**
     * @inheritdoc
     */
    public function setDeliveryDate(string $deliveryDate)
    {
        $this->setData(self::DELIVERY_DATE, $deliveryDate);
    }

    /**
     * @inheritdoc
     */
    public function getCarrierLogoUrl(): string
    {
        return (string)$this->getData(self::CARRIER_LOGO_URL);
    }

    /**
     * @inheritdoc
     */
    public function setCarrierLogoUrl(string $carrierLogoUrl)
    {
        $this->setData(self::CARRIER_LOGO_URL, $carrierLogoUrl);
    }
}
