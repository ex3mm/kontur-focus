<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus;

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\Contracts\EndpointInterface;
use Ex3mm\KonturFocus\Contracts\RequestBuilderInterface;
use Ex3mm\KonturFocus\Contracts\ResponseMapperInterface;
use Ex3mm\KonturFocus\Endpoints\BankruptcyAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\CourtAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\CustomEndpoint;
use Ex3mm\KonturFocus\Endpoints\EgrDetailsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FinanceAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FsspAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\LegalAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\LinkAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\PurchasesAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\ReqEndpoint;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;

final class KonturFocusManager
{
    private readonly ClientInterface $client;

    private readonly ResponseMapperInterface $mapper;

    public function __construct(
        private readonly KonturFocusConfig $config,
        ?GuzzleClientFactory $factory = null,
        ?ResponseMapperInterface $mapper = null,
        ?ClientInterface $client = null,
    ) {
        $factory ??= new GuzzleClientFactory();
        $this->mapper = $mapper ?? new ResponseMapper();
        $this->client = $client ?? new KonturFocusClient($config, $factory);
    }

    public function req(): RequestBuilderInterface
    {
        return $this->builder(new ReqEndpoint());
    }

    public function egrDetails(): RequestBuilderInterface
    {
        return $this->builder(new EgrDetailsEndpoint());
    }

    public function legalAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new LegalAnalyticsEndpoint());
    }

    public function bankruptcyAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new BankruptcyAnalyticsEndpoint());
    }

    public function courtAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new CourtAnalyticsEndpoint());
    }

    public function financeAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new FinanceAnalyticsEndpoint());
    }

    public function fsspAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new FsspAnalyticsEndpoint());
    }

    public function linkAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new LinkAnalyticsEndpoint());
    }

    public function purchasesAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new PurchasesAnalyticsEndpoint());
    }

    public function custom(string $endpoint): RequestBuilderInterface
    {
        $normalized = $endpoint;
        if ($normalized !== '' && $normalized[0] !== '/') {
            $normalized = '/'.$normalized;
        }

        return $this->builder(new CustomEndpoint($normalized));
    }

    private function builder(EndpointInterface $endpoint): RequestBuilderInterface
    {
        return new RequestBuilder(
            client: $this->client,
            mapper: $this->mapper,
            endpoint: $endpoint,
            apiKey: $this->config->key,
        );
    }
}
