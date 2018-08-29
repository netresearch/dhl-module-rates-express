<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Model\Carrier;

use Dhl\ExpressRates\Model\Rate\CheckoutProvider as RateProvider;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Xml\Security;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Tracking\Result as TrackingResult;

/**
 * Class Express
 *
 * @package Dhl\ExpressRates\Model\Carrier
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class Express extends \Magento\Shipping\Model\Carrier\AbstractCarrierOnline implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    public const CARRIER_CODE = 'dhlexpress';

    /**
     * @var string
     */
    protected $_code = self::CARRIER_CODE;

    /**
     * @var RateProvider
     */
    private $rateProvider;

    /**
     * Express constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param Security $xmlSecurity
     * @param \Magento\Shipping\Model\Simplexml\ElementFactory $xmlElFactory
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param \Magento\Shipping\Model\Tracking\ResultFactory $trackFactory
     * @param TrackingResult\ErrorFactory $trackErrorFactory
     * @param TrackingResult\StatusFactory $trackStatusFactory
     * @param \Magento\Directory\Model\RegionFactory $regionFactory
     * @param \Magento\Directory\Model\CountryFactory $countryFactory
     * @param \Magento\Directory\Model\CurrencyFactory $currencyFactory
     * @param \Magento\Directory\Helper\Data $directoryData
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param RateProvider $rateProvider
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        Security $xmlSecurity,
        \Magento\Shipping\Model\Simplexml\ElementFactory $xmlElFactory,
        \Magento\Shipping\Model\Rate\ResultFactory $rateFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Shipping\Model\Tracking\ResultFactory $trackFactory,
        \Magento\Shipping\Model\Tracking\Result\ErrorFactory $trackErrorFactory,
        \Magento\Shipping\Model\Tracking\Result\StatusFactory $trackStatusFactory,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Magento\Directory\Helper\Data $directoryData,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        RateProvider $rateProvider,
        array $data = []
    ) {
        $this->rateProvider = $rateProvider;
        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $xmlSecurity,
            $xmlElFactory,
            $rateFactory,
            $rateMethodFactory,
            $trackFactory,
            $trackErrorFactory,
            $trackStatusFactory,
            $regionFactory,
            $countryFactory,
            $currencyFactory,
            $directoryData,
            $stockRegistry,
            $data
        );
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        try {
            return $this->rateProvider->getRates($request);
        } catch (LocalizedException $e) {
            $this->_logger->error($e->getMessage(), ['exception' => $e->getPrevious() ?? $e]);
            $result = $this->_rateFactory->create();
            $result->append($this->getErrorMessage());

            return $result;
        }
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        // @TODO: Fill in functionality
        return [];
    }

    /**
     * @param DataObject $request
     * @return DataObject
     */
    protected function _doShipmentRequest(DataObject $request): DataObject
    {
        return false;
    }

    /**
     * Perform additional validation:
     *  - check shipping origin being valid
     *  - check for weightless items (will result in error)
     *
     * @param \Magento\Framework\DataObject|RateRequest $request
     * @return bool|\Magento\Framework\DataObject|\Magento\Shipping\Model\Carrier\AbstractCarrierOnline
     */
    public function proccessAdditionalValidation(\Magento\Framework\DataObject $request)
    {
        $errorMsg = false;

        if (!$this->validateItemWeight($request)) {
            $errorMsg = __('Some items have no configured weight.');
        }

        if ($errorMsg) {
            $this->_logger->error($errorMsg);

            return $this->getErrorMessage();
        }

        return parent::proccessAdditionalValidation($request);
    }

    /**
     * Check if all request items have a weight configured
     *
     * @param \Magento\Framework\DataObject|RateRequest $request
     * @return bool
     */
    private function validateItemWeight(\Magento\Framework\DataObject $request): bool
    {
        /** @var $item \Magento\Quote\Model\Quote\Item */
        foreach ($request->getAllItems() as $item) {
            $product = $item->getProduct();
            if ($product && $product->getWeight()) {
                // we have weight, continue
                continue;
            }
            if ($product && !$product->isVirtual()) {
                // no weight and product is not virtual!

                return false;
            }
        }

        return true;
    }
}
