<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Model\Config\Source;

use Dhl\Express\Api\Data\ShippingProductsInterface;

/**
 * Class DomesticDefaultProduct
 *
 * @package   Dhl\ExpressRates\Model\Backend\Config\Source
 * @author    Ronny Gertler <ronny.gertler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link      http://www.netresearch.de/
 */
class DomesticProducts implements \Magento\Framework\Option\ArrayInterface
{
    const DELIMITER = ';';

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $options = ShippingProductsInterface::PRODUCT_NAMES_DOMESTIC;

        return array_map(
            function ($value, $label) {
                $value = implode(self::DELIMITER, $value);
                return [
                    'value' => $value,
                    'label' => $label,
                ];
            },
            $options,
            array_keys($options)
        );
    }
}
