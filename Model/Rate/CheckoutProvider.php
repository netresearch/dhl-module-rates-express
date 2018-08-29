<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Model\Rate;

use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Dhl\ExpressRates\Webservice\RateAdapterInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;

/**
 * Class CheckoutProvider
 *
 * @package Dhl\ExpressRates\Model\Rate
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class CheckoutProvider
{
    /**
     * @var RateAdapterInterface
     */
    private $rateAdapter;

    /**
     * @var ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var RateProcessorInterface[]
     */
    private $rateProcessors;

    /**
     * CheckoutProvider constructor.
     *
     * @param RateAdapterInterface $rateAdapter
     * @param ResultFactory $rateResultFactory
     * @param RateProcessorInterface[] $rateProcessors
     */
    public function __construct(
        RateAdapterInterface $rateAdapter,
        ResultFactory $rateResultFactory,
        array $rateProcessors = []
    ) {
        $this->rateAdapter = $rateAdapter;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateProcessors = $rateProcessors;
    }

    /**
     * @param RateRequest $request
     * @return Result
     * @throws LocalizedException
     */
    public function getRates(RateRequest $request): Result
    {
        $methods = $this->rateAdapter->getRates($request);

        $rateResult = $this->rateResultFactory->create();

        foreach ($this->rateProcessors as $rateProcessor) {
            $methods = $rateProcessor->processMethods($methods, $request);
        }

        foreach ($methods as $method) {
            $rateResult->append($method);
        }

        if (empty($methods)) {
            throw new LocalizedException(__('No rates returned from API.'));
        }

        return $rateResult;
    }
}
