<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class ShippingOptionDisplay
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Max Melzer <max.melzer@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class ShippingOptionDisplay implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'Cost only'],
            ['value' => '1', 'label' => 'Cost and estimated delivery dates (Only available on v2.2+)'],
        ];
    }
}
