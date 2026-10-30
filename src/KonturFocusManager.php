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
use Ex3mm\KonturFocus\Endpoints\AccountingReportsEndpoint;
use Ex3mm\KonturFocus\Endpoints\BankruptcyAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\BeneficiaryEndpoint;
use Ex3mm\KonturFocus\Endpoints\CompanyAffiliationsTypesEndpoint;
use Ex3mm\KonturFocus\Endpoints\CourtAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\CustomEndpoint;
use Ex3mm\KonturFocus\Endpoints\EgrDetailsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FinanceAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FsspAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\FsspEndpoint;
use Ex3mm\KonturFocus\Endpoints\LegalAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\LicensesEndpoint;
use Ex3mm\KonturFocus\Endpoints\LinkAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\PersonBankruptcyEndpoint;
use Ex3mm\KonturFocus\Endpoints\PetitionersOfArbitrationEndpoint;
use Ex3mm\KonturFocus\Endpoints\PurchasesAnalyticsEndpoint;
use Ex3mm\KonturFocus\Endpoints\PurchasesOfParticipantEndpoint;
use Ex3mm\KonturFocus\Endpoints\ReqEndpoint;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use LogicException;

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

    public function companyAffiliationsTypes(): RequestBuilderInterface
    {
        return $this->builder(new CompanyAffiliationsTypesEndpoint());
    }

    public function financeAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new FinanceAnalyticsEndpoint());
    }

    public function fsspAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new FsspAnalyticsEndpoint());
    }

    public function fssp(): RequestBuilderInterface
    {
        return $this->builder(new FsspEndpoint());
    }

    public function linkAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new LinkAnalyticsEndpoint());
    }

    public function purchasesAnalytics(): RequestBuilderInterface
    {
        return $this->builder(new PurchasesAnalyticsEndpoint());
    }

    public function purchasesOfParticipant(): RequestBuilderInterface
    {
        return $this->builder(new PurchasesOfParticipantEndpoint());
    }

    public function petitionersOfArbitration(): RequestBuilderInterface
    {
        return $this->builder(new PetitionersOfArbitrationEndpoint());
    }

    public function personBankruptcy(): RequestBuilderInterface
    {
        return $this->builder(new PersonBankruptcyEndpoint());
    }

    public function licenses(): RequestBuilderInterface
    {
        return $this->builder(new LicensesEndpoint());
    }

    public function beneficiary(): RequestBuilderInterface
    {
        return $this->builder(new BeneficiaryEndpoint());
    }

    public function accountingReports(): RequestBuilderInterface
    {
        return $this->builder(new AccountingReportsEndpoint());
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
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getReq(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new ReqEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint egrDetails
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getEgrDetails(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new EgrDetailsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint legalAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getLegalAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new LegalAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint bankruptcyAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getBankruptcyAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new BankruptcyAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint courtAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getCourtAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new CourtAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить ближайшие связи компаний.
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getCompanyAffiliationsTypes(
        ?string $inn = null,
        ?string $ogrn = null,
        ?int $skip = null,
        ?int $take = null,
        ?int $affiliationType = null,
    ): DTOs\CollectionResponse {
        $parameters = [];

        if ($skip !== null) {
            $parameters['skip'] = $skip;
        }

        if ($take !== null) {
            $parameters['take'] = $take;
        }

        if ($affiliationType !== null) {
            $parameters['affiliationType'] = $affiliationType;
        }

        return $this->execute(new CompanyAffiliationsTypesEndpoint(), $inn, $ogrn, $parameters);
    }

    /**
     * Получить данные из endpoint financeAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getFinanceAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new FinanceAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint fsspAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getFsspAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new FsspAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить исполнительные производства.
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getFssp(
        ?string $inn = null,
        ?string $ogrn = null,
        ?int $skip = null,
    ): DTOs\CollectionResponse {
        $parameters = [];

        if ($skip !== null) {
            $parameters['skip'] = $skip;
        }

        return $this->execute(new FsspEndpoint(), $inn, $ogrn, $parameters);
    }

    /**
     * Получить данные из endpoint linkAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getLinkAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new LinkAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint purchasesAnalytics
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getPurchasesAnalytics(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new PurchasesAnalyticsEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить закупки, в которых организация принимала участие.
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getPurchasesOfParticipant(
        ?string $inn = null,
        ?string $ogrn = null,
        ?int $skip = null,
        ?int $take = null,
    ): DTOs\CollectionResponse {
        $parameters = [];

        if ($skip !== null) {
            $parameters['skip'] = $skip;
        }

        if ($take !== null) {
            $parameters['take'] = $take;
        }

        return $this->execute(new PurchasesOfParticipantEndpoint(), $inn, $ogrn, $parameters);
    }

    /**
     * Получить статистику по истцам в арбитражных делах.
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getPetitionersOfArbitration(
        ?string $inn = null,
        ?string $ogrn = null,
        ?int $skip = null,
        ?int $take = null,
    ): DTOs\CollectionResponse {
        $parameters = [];

        if ($skip !== null) {
            $parameters['skip'] = $skip;
        }

        if ($take !== null) {
            $parameters['take'] = $take;
        }

        return $this->execute(new PetitionersOfArbitrationEndpoint(), $inn, $ogrn, $parameters);
    }

    /**
     * Получить сведения о банкротстве физического лица.
     *
     * @return DTOs\CollectionResponse<object>
     */
    public function getPersonBankruptcy(
        ?string $inn = null,
        ?string $fio = null,
        ?string $birthDate = null,
    ): DTOs\CollectionResponse {
        $parameters = [];

        if ($inn !== null) {
            $parameters['innfl'] = $inn;
        }

        if ($fio !== null) {
            $parameters['fio'] = $fio;
        }

        if ($birthDate !== null) {
            $parameters['birthDate'] = $birthDate;
        }

        return $this->execute(new PersonBankruptcyEndpoint(), parameters: $parameters);
    }

    /**
     * Получить данные из endpoint licenses
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getLicenses(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new LicensesEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint beneficiary
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getBeneficiary(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new BeneficiaryEndpoint(), $inn, $ogrn);
    }

    /**
     * Получить данные из endpoint accountingReports
     *
     * @return DTOs\CollectionResponse<object>
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    public function getAccountingReports(?string $inn = null, ?string $ogrn = null): DTOs\CollectionResponse
    {
        return $this->execute(new AccountingReportsEndpoint(), $inn, $ogrn);
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
     * Выполнить запрос к endpoint с параметрами inn/ogrn и дополнительными параметрами
     *
     * @param array<string, string|int|float|bool> $parameters
     * @return DTOs\CollectionResponse<object>
     *
     * @throws \Ex3mm\KonturFocus\Exceptions\RequestValidationException
     */
    private function execute(
        EndpointInterface $endpoint,
        ?string $inn = null,
        ?string $ogrn = null,
        array $parameters = [],
    ): DTOs\CollectionResponse {
        $builder = $this->builder($endpoint);

        if ($inn !== null) {
            $builder->inn($inn);
        }

        if ($ogrn !== null) {
            $builder->ogrn($ogrn);
        }

        foreach ($parameters as $name => $value) {
            $builder->param($name, $value);
        }

        $result = $builder->get();

        if (is_array($result)) {
            throw new LogicException('Manager endpoint execution must return a DTO collection.');
        }

        return $result;
    }
}
