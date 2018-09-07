<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class CustomizeApplicableCountries
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Max Melzer <max.melzer@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class CustomizeApplicableCountries implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'Use default countries from General > Country'],
            ['value' => '1', 'label' => 'Create a customized country list'],
        ];
    }
}
