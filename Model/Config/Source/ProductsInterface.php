<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class ProductsInterface
 *
 * @package   Dhl\ExpressRates\Model\Backend\Config\Source
 * @author    Rico Sonntag <rico.sonntag@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link      http://www.netresearch.de/
 */
interface ProductsInterface extends \Magento\Framework\Option\ArrayInterface
{
    /**
     * Returns the list of options as plain array.
     *
     * @return array
     */
    public function toPlainArray();
}
