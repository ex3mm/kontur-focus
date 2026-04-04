<?php

declare(strict_types=1);

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Endpoints\BeneficiaryEndpoint;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;

function beneficiaryConfig(array $override = []): KonturFocusConfig
{
    $base = [
        'key' => 'test-key',
        'base_url' => 'https://focus-api.kontur.ru',
        'retry' => [
            'enabled' => false,
            'max_attempts' => 1,
            'delay_ms' => 0,
            'multiplier' => 1,
            'max_delay_ms' => 0,
        ],
        'cache' => [
            'enabled' => false,
            'ttl' => 60,
            'store' => 'default',
            'namespace' => 'test',
        ],
    ];

    return KonturFocusConfig::fromArray(array_replace_recursive($base, $override));
}

it('возвращает информацию о конечных бенефициарах для корректного ответа', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/beneficial_owners_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(\Ex3mm\KonturFocus\DTOs\CollectionResponse::class)
        ->and($result->items)->toBeArray()->toHaveCount(1)
        ->and($result->items[0]->inn)->toBe('7704305026')
        ->and($result->items[0]->ogrn)->toBe('1157746092349')
        ->and($result->items[0]->focusHref)->toBe('https://focus.kontur.ru/entity?query=1157746092349');
});

it('корректно маппит уставный капитал', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/beneficial_owners_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asDto()
        ->get();

    expect($result->items[0]->statedCapital)->not->toBeNull()
        ->and($result->items[0]->statedCapital->sum)->toBe(101000000.0)
        ->and($result->items[0]->statedCapital->date)->toBe('2022-01-27');
});

it('корректно маппит конечных владельцев физлиц', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/beneficial_owners_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asDto()
        ->get();

    $beneficialOwners = $result->items[0]->beneficialOwners;
    expect($beneficialOwners)->not->toBeNull()
        ->and($beneficialOwners->beneficialOwnersFL)->toBeArray()->toHaveCount(1)
        ->and($beneficialOwners->beneficialOwnersFL[0]->fio)->toBe('Осеевский Михаил Эдуардович')
        ->and($beneficialOwners->beneficialOwnersFL[0]->innfl)->toBe('780601120366')
        ->and($beneficialOwners->beneficialOwnersFL[0]->share)->toBe(0.258416111170811)
        ->and($beneficialOwners->beneficialOwnersFL[0]->isAccurate)->toBeTrue();
});

it('корректно маппит конечных владельцев юрлиц', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/beneficial_owners_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asDto()
        ->get();

    $beneficialOwners = $result->items[0]->beneficialOwners;
    expect($beneficialOwners->beneficialOwnersUL)->toBeArray()->toHaveCount(3)
        ->and($beneficialOwners->beneficialOwnersUL[0]->ogrn)->toBe('1087746829994')
        ->and($beneficialOwners->beneficialOwnersUL[0]->inn)->toBe('7710723134')
        ->and($beneficialOwners->beneficialOwnersUL[0]->fullName)->toBe('Федеральное агентство по управлению государственным имуществом')
        ->and($beneficialOwners->beneficialOwnersUL[0]->share)->toBe(48.4708981095003)
        ->and($beneficialOwners->beneficialOwnersUL[0]->isAccurate)->toBeTrue();
});

it('корректно маппит конечных владельцев без категории', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/beneficial_owners_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asDto()
        ->get();

    $beneficialOwners = $result->items[0]->beneficialOwners;
    expect($beneficialOwners->beneficialOwnersOther)->toBeArray()->toHaveCount(4)
        ->and($beneficialOwners->beneficialOwnersOther[0]->fullName)->toBe('Нко АО Нрд – номинальный держатель')
        ->and($beneficialOwners->beneficialOwnersOther[0]->share)->toBe(26.9307217690039)
        ->and($beneficialOwners->beneficialOwnersOther[0]->isAccurate)->toBeTrue();
});

it('корректно маппит исторических конечных владельцев', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/beneficial_owners_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asDto()
        ->get();

    $historical = $result->items[0]->historicalBeneficialOwners;
    expect($historical)->not->toBeNull()
        ->and($historical->beneficialOwnersFL)->toBeArray()->toHaveCount(3)
        ->and($historical->beneficialOwnersFL[0]->fio)->toBe('Шишханов Микаил Османович')
        ->and($historical->beneficialOwnersFL[0]->innfl)->toBe('773205164190')
        ->and($historical->beneficialOwnersUL)->toBeArray()->toHaveCount(1)
        ->and($historical->beneficialOwnersForeign)->toBeArray()->toHaveCount(2)
        ->and($historical->beneficialOwnersForeign[0]->country)->toBe('Нидерланды')
        ->and($historical->beneficialOwnersOther)->toBeArray()->toHaveCount(2);
});

it('выбрасывает NotFoundException при ответе 404', function (): void {
    $mock = new MockHandler([
        new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
    ]);

    $config = beneficiaryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new BeneficiaryEndpoint(), $config->key))
        ->inn('7704305026')
        ->asArray()
        ->get();
})->throws(NotFoundException::class);
