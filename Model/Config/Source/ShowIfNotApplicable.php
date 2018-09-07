<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class ShowIfNotApplicable
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Max Melzer <max.melzer@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class ShowIfNotApplicable implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'Hide this option from customer'],
            ['value' => '1', 'label' => 'Display customized message'],
        ];
    }
}
