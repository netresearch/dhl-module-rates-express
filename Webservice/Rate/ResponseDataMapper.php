<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Webservice\Rate;

use Dhl\Express\Api\Data\RateResponseInterface;
use Dhl\ExpressRates\Model\Carrier\Express;
use Dhl\ExpressRates\Model\Carrier\CarrierLogo;
use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Dhl\Express\Model\Response\Rate\Rate;
use Dhl\ExpressRates\Api\Data\MethodAdditionalInfoInterface;
use Dhl\ExpressRates\Model\Method\AdditionalInfoFactory;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Framework\Stdlib\DateTime\DateTimeFormatterInterface;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ResponseDataMapper
 *
 * @package Dhl\ExpressRates\Webservice\Rate
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class ResponseDataMapper implements ResponseDataMapperInterface
{
    /**
     * @var AdditionalInfoFactory
     */
    private $additionalInfoFactory;

    /**
     * @var MethodFactory
     */
    private $methodFactory;

    /**
     * @var ModuleConfigInterface
     */
    private $moduleConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CurrencyFactory
     */
    private $currencyFactory;

    /**
     * @var DateTimeFormatterInterface
     */
    private $dateTimeFormatter;

    /**
     * @var CarrierLogo
     */
    private $logo;

    /**
     * ResponseDataMapper constructor.
     *
     * @param AdditionalInfoFactory      $additionalInfoFactory
     * @param MethodFactory              $methodFactory
     * @param ModuleConfigInterface      $moduleConfig
     * @param StoreManagerInterface      $storeManager
     * @param CurrencyFactory            $currencyFactory
     * @param DateTimeFormatterInterface $dateTimeFormatter
     * @param CarrierLogo                $logo
     */
    public function __construct(
        AdditionalInfoFactory $additionalInfoFactory,
        MethodFactory $methodFactory,
        ModuleConfigInterface $moduleConfig,
        StoreManagerInterface $storeManager,
        CurrencyFactory $currencyFactory,
        DateTimeFormatterInterface $dateTimeFormatter,
        CarrierLogo $logo
    ) {
        $this->additionalInfoFactory = $additionalInfoFactory;
        $this->methodFactory = $methodFactory;
        $this->moduleConfig = $moduleConfig;
        $this->storeManager = $storeManager;
        $this->currencyFactory = $currencyFactory;
        $this->dateTimeFormatter = $dateTimeFormatter;
        $this->logo = $logo;
    }

    /**
     * @param RateResponseInterface $rateResponse
     *
     * @return Method[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \InvalidArgumentException
     */
    public function mapResult(RateResponseInterface $rateResponse)
    {
        $result = [];

        /** @var Rate $rate */
        foreach ($rateResponse->getRates() as $rate) {
            $priceInBaseCurrency = $this->convertPriceToCurrency($rate->getAmount(), $rate->getCurrencyCode());

            $result[] = $this->methodFactory->create(
                [
                    'data' => [
                        'carrier' => Express::CARRIER_CODE,
                        'carrier_title' => $this->moduleConfig->getTitle(),
                        'method' => $rate->getServiceCode(),
                        'method_title' => $rate->getLabel(),
                        'price' => $priceInBaseCurrency,
                        'cost' => $priceInBaseCurrency,

                        // Pass delivery date through the method description
                        MethodAdditionalInfoInterface::ATTRIBUTE_KEY => $this->getMethodAdditionalInformation($rate),
                    ],
                ]
            );
        }

        return $result;
    }

    /**
     * Returns the formatted delivery date based on the current locale.
     *
     * @param \DateTime $dateTime The date/time object to format
     *
     * @return string
     */
    private function getFormattedDeliveryDate(\DateTime $dateTime)
    {
        return $this->dateTimeFormatter->formatObject(
            $dateTime,
            [
                \IntlDateFormatter::MEDIUM, // Date part
                \IntlDateFormatter::NONE    // Time part
            ]
        );
    }

    /**
     * @param float $value
     * @param string $inputCurrencyCode
     *
     * @return float
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \InvalidArgumentException
     */
    private function convertPriceToCurrency($value, $inputCurrencyCode)
    {
        /** @var string $baseCurrencyCode */
        $baseCurrencyCode = $this->storeManager->getStore()->getBaseCurrencyCode();

        if ($inputCurrencyCode === $baseCurrencyCode || $inputCurrencyCode === '') {
            return $value;
        }

        $rateCurrency = $this->currencyFactory->create(['data' => ['currency_code' => $inputCurrencyCode]]);

        try {
            return $rateCurrency->convert($value, $baseCurrencyCode);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("The given currency code $inputCurrencyCode is not valid.");
        }
    }

    /**
     * @param Rate $rate
     * @return MethodAdditionalInfoInterface
     */
    private function getMethodAdditionalInformation(Rate $rate)
    {
        $data = [];

        if ($this->moduleConfig->isCheckoutLogoEnabled()) {
            $logoUrl = $this->logo->getImageUrl();
            $data[MethodAdditionalInfoInterface::CARRIER_LOGO_URL] = $logoUrl;
        }

        if ($this->moduleConfig->isCheckoutDeliveryTimeEnabled()) {
            $deliveryDate = $this->getFormattedDeliveryDate($rate->getDeliveryTime());
            $data[MethodAdditionalInfoInterface::DELIVERY_DATE] = $deliveryDate;
        }

        return $this->additionalInfoFactory->create([
            'data' => $data
        ]);
    }
}
