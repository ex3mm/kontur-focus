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
use Ex3mm\KonturFocus\Endpoints\BeneficiaryEndpoint;
use Ex3mm\KonturFocus\Endpoints\CourtAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\CustomEndpoint;
use Ex3mm\KonturFocus\Endpoints\EgrDetailsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FinanceAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FsspAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\LegalAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\LicensesEndpoint;
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

    public function licenses(): RequestBuilderInterface
    {
        return $this->builder(new LicensesEndpoint());
    }

    public function beneficiary(): RequestBuilderInterface
    {
        return $this->builder(new BeneficiaryEndpoint());
    }

    public function custom(string $endpoint): RequestBuilderInterface
    {
        $normalized = $endpoint;
        if ($normalized !== '' && $normalized[0] !== '/') {
            $normalized = '/'.$normalized;
        }

        return $this->builder(new CustomEndpoint($normalized));
    }

    /**
     * Получить данные из endpoint req
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getReq(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new ReqEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint egrDetails
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getEgrDetails(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new EgrDetailsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint legalAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getLegalAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new LegalAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint bankruptcyAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getBankruptcyAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new BankruptcyAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint courtAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getCourtAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new CourtAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint financeAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getFinanceAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new FinanceAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint fsspAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getFsspAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new FsspAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint linkAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getLinkAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new LinkAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint purchasesAnalytics
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getPurchasesAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new PurchasesAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint licenses
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getLicenses(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new LicensesEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint beneficiary
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getBeneficiary(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new BeneficiaryEndpoint(), $inn, $ogrn);
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

    /**
     * Выполнить запрос к endpoint с параметрами inn/ogrn
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    private function execute(EndpointInterface $endpoint, ?string $inn, ?string $ogrn): DTOs\CollectionResponse
    {
        $builder = $this->builder($endpoint);

        if ($inn !== null) {
            $builder->inn($inn);
        }

        if ($ogrn !== null) {
            $builder->ogrn($ogrn);
        }

        return $builder->get();
    }
}
