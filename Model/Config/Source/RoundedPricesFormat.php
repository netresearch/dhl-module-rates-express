<?php
/**
 * See LICENSE.md for license details.
 */

namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class Rounded prices type
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Ronny Gertler <ronny.gertler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class RoundedPricesFormat implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * No rounding key.
     */
    const DO_NOT_ROUND = 'no_rounding';

    /**
     * Full price key.
     */
    const FULL_PRICE = 'full_price';

    /**
     * Static decimal key.
     */
    const STATIC_DECIMAL = 'static_decimal';
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [

            ['value' => self::DO_NOT_ROUND, 'label' => 'Don\'t round prices'],
            ['value' => self::FULL_PRICE, 'label' => 'Round to a whole number (ex. 1 or 37)'],
            ['value' => self::STATIC_DECIMAL, 'label' => 'Round to a specific decimal value (99 cents)'],
        ];
    }
}
