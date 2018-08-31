<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Carrier;

use Dhl\ExpressRates\Model\Rate\CheckoutProvider as RateProvider;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Class Express
 *
 * @package Dhl\ExpressRates\Model\Carrier
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class Express extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    const CARRIER_CODE = 'dhlexpress';

    /**
     * @var string
     */
    protected $_code = self::CARRIER_CODE;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateFactory;

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
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateFactory
     * @param RateProvider $rateProvider
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateFactory,
        RateProvider $rateProvider,
        array $data = []
    ) {
        $this->rateFactory = $rateFactory;
        $this->rateProvider = $rateProvider;

        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
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
            $this->_logger->error($e->getMessage(), ['exception' => $e->getPrevious() ?: $e]);
            $result = $this->rateFactory->create();
            $result->append($this->getErrorMessage());

            return $result;
        }
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
     * @return array
     */
    public function getAllowedMethods()
    {
        return [];
    }

    /**
     * Get error messages
     *
     * @return bool|\Magento\Quote\Model\Quote\Address\RateResult\Error
     */
    private function getErrorMessage()
    {
        if ($this->getConfigData('showmethod')) {
            $error = $this->_rateErrorFactory->create();
            $error->setCarrier($this->getCarrierCode());
            $error->setCarrierTitle($this->getConfigData('title'));
            $error->setErrorMessage($this->getConfigData('specificerrmsg'));

            return $error;
        }

        return false;
    }

    /**
     * Check if all request items have a weight configured
     *
     * @param \Magento\Framework\DataObject|RateRequest $request
     * @return bool
     */
    private function validateItemWeight(\Magento\Framework\DataObject $request)
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
