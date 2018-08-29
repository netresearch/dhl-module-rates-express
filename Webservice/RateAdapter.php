<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Webservice;

use Dhl\Express\Exception\RateRequestException;
use Dhl\Express\Exception\SoapException;
use Dhl\ExpressRates\Webservice\Rate\RequestDataMapperInterface;
use Dhl\ExpressRates\Webservice\Rate\ResponseDataMapperInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Class RateAdapter
 *
 * @package Dhl\ExpressRates\Webservice
 */
class RateAdapter implements RateAdapterInterface
{
    /**
     * @var RequestDataMapperInterface
     */
    private $requestDataMapper;

    /**
     * @var ResponseDataMapperInterface;
     */
    private $responseDataMapper;

    /**
     * @var RateClientInterface
     */
    private $client;

    /**
     * RateAdapter constructor.
     *
     * @param RequestDataMapperInterface $requestDataMapper
     * @param ResponseDataMapperInterface $responseDataMapper
     * @param RateClientInterface $client
     */
    public function __construct(
        RequestDataMapperInterface $requestDataMapper,
        ResponseDataMapperInterface $responseDataMapper,
        RateClientInterface $client
    ) {
        $this->requestDataMapper = $requestDataMapper;
        $this->responseDataMapper = $responseDataMapper;
        $this->client = $client;
    }

    /**
     * Fetch Rates through API client
     *
     * @param RateRequest $request
     * @return array
     * @throws LocalizedException
     */
    public function getRates(RateRequest $request): array
    {
        $requestModel = $this->requestDataMapper->mapRequest($request);

        try {
            $response = $this->client->performRatesRequest($requestModel);
            $result = $this->responseDataMapper->mapResult($response);
        } catch (RateRequestException | SoapException $e) {
            throw new LocalizedException(__('Error during rate request.'), $e, $e->getCode());
        }

        return $result;
    }
}
