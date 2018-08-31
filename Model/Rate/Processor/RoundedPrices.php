<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Rate\Processor;

use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Dhl\ExpressRates\Model\Rate\RateProcessorInterface;
use Dhl\ExpressRates\Model\Config\Source\RoundedPricesFormat;
use Dhl\ExpressRates\Model\Config\Source\RoundedPricesMode;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * A rate processor to round prices.
 *
 * @package  Dhl\ExpressRates\Model
 * @author   Ronny Gertler <ronny.gertler@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class RoundedPrices implements RateProcessorInterface
{
    /**
     * @var ModuleConfigInterface
     */
    private $moduleConfig;

    /**
     * RoundedPrices constructor.
     *
     * @param ModuleConfigInterface $moduleConfig
     */
    public function __construct(
        ModuleConfigInterface $moduleConfig
    ) {
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * @inheritdoc
     */
    public function processMethods(array $methods, $request = null)
    {
        foreach ($methods as $method) {
            $method->setPrice(
                $this->roundPrice($method->getPrice())
            );
        }

        return $methods;
    }

    /**
     * Round a given price on the basis of the internal module configuration.
     *
     * @param float $price
     * @return float
     */
    private function roundPrice($price)
    {
        $mode = $this->moduleConfig->getRoundedPricesMode();

        // Do not round
        if ($mode === RoundedPricesMode::DO_NOT_ROUND) {
            return $price;
        }

        $format = $this->moduleConfig->getRoundedPricesFormat();

        // Price should be rounded to a given decimal value
        if ($format === RoundedPricesFormat::STATIC_DECIMAL) {
            if ($this->moduleConfig->roundUp()) {
                $roundedPrice = $this->roundUpToStaticDecimal($price);
            } else {
                $roundedPrice = $this->roundOffToStaticDecimal($price);
            }
            return $roundedPrice;
        }

        // Price should be rounded to the next integral number.
        return $this->moduleConfig->roundUp() ? ceil($price) : floor($price);
    }

    /**
     * Round given price down to a configured decimal value.
     *
     * @param float $price
     * @return float
     */
    private function roundOffToStaticDecimal($price)
    {
        $roundedDecimal = $this->moduleConfig->getRoundedPricesStaticDecimal();
        $decimal = $price - floor($price);

        if ($decimal === $roundedDecimal) {
            return $price;
        }

        if ($decimal < $roundedDecimal) {
            $roundedPrice = floor($price) - 1 + $roundedDecimal;
            return $roundedPrice < 0 ? 0 : floor($price) - 1 + $roundedDecimal;
        }

        return floor($price) + $roundedDecimal;
    }

    /**
     * Round given price up to a configured decimal value.
     *
     * @param float $price
     * @return float
     */
    private function roundUpToStaticDecimal($price)
    {
        $roundedDecimal = $this->moduleConfig->getRoundedPricesStaticDecimal();
        $decimal = $price - floor($price);

        if ($decimal === $roundedDecimal) {
            return $price;
        }

        if ($decimal < $roundedDecimal) {
            return floor($price) + $roundedDecimal;
        }

        return ceil($price) + $roundedDecimal;
    }
}
