<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class PickupType
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Max Melzer <max.melzer@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class PickupType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => 'Regularly scheduled pickup'],
            ['value' => '0', 'label' => 'Ad hoc pickup or service point drop-off'],
        ];
    }
}
