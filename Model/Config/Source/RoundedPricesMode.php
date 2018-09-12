<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class Rounded prices
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Ronny Gertler <ronny.gertler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class RoundedPricesMode implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Round up key.
     */
    const ROUND_UP = 'round_up';

    /**
     * Round off key.
     */
    const ROUND_OFF = 'round_off';

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ROUND_UP,  'label' => __('Round up')],
            ['value' => self::ROUND_OFF, 'label' => __('Round down')],
        ];
    }
}
