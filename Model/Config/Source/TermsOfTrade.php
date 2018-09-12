<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

/**
 * Class TermsOfTrade
 *
 * @package Dhl\ExpressRates\Model
 */
class TermsOfTrade
{
    const TOD_DDP = 'DDP';

    const TOD_DDU = 'DDU';

    /**
     * Options getter
     *
     * @return mixed[]
     */
    public function toOptionArray()
    {
        $optionArray = [];

        $options = $this->toArray();
        foreach ($options as $value => $label) {
            $optionArray[] = ['value' => $value, 'label' => $label];
        }

        return $optionArray;
    }

    /**
     * Get options
     *
     * @return mixed[]
     */
    public function toArray()
    {
        return [
            self::TOD_DDU => __('Customer pays duties and taxes (DDU)'),
            self::TOD_DDP => __('I will pay duties and taxes (DTP)'),
        ];
    }
}
