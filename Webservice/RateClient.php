<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Webservice;

use Dhl\Express\Api\Data\RateRequestInterface;
use Dhl\Express\Api\Data\RateResponseInterface;
use Dhl\Express\Api\ServiceFactoryInterface;
use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Psr\Log\LoggerInterface;

/**
 * Class RateClient
 *
 * @package Dhl\ExpressRates\Webservice
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class RateClient implements RateClientInterface
{
    /**
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

    /**
     * @var ModuleConfigInterface
     */
    private $moduleConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RateClient constructor.
     *
     * @param ServiceFactoryInterface $serviceFactory
     * @param ModuleConfigInterface $moduleConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        ServiceFactoryInterface $serviceFactory,
        ModuleConfigInterface $moduleConfig,
        LoggerInterface $logger
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->moduleConfig = $moduleConfig;
        $this->logger = $logger;
    }

    /**
     * @param RateRequestInterface $request
     * @return RateResponseInterface
     * @throws \Dhl\Express\Exception\RateRequestException
     * @throws \Dhl\Express\Exception\SoapException
     */
    public function performRatesRequest(RateRequestInterface $request)
    {
        $rateService = $this->serviceFactory->createRateService(
            $this->moduleConfig->getUserName(),
            $this->moduleConfig->getPassword(),
            $this->logger
        );

        return $rateService->collectRates($request);
    }
}
