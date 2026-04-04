<?php

declare(strict_types=1);

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Endpoints\LicensesEndpoint;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;

function licensesConfig(array $override = []): KonturFocusConfig
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

it('возвращает список лицензий для корректного ответа', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/licenses_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = licensesConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new LicensesEndpoint(), $config->key))
        ->inn('7707083893')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(\Ex3mm\KonturFocus\DTOs\CollectionResponse::class)
        ->and($result->items)->toBeArray()->toHaveCount(1)
        ->and($result->items[0]->inn)->toBe('7707083893')
        ->and($result->items[0]->ogrn)->toBe('1027700132195')
        ->and($result->items[0]->licenses)->toBeArray()->toHaveCount(2)
        ->and($result->items[0]->licenses[0]->source)->toBe('Росалкогольрегулирование')
        ->and($result->items[0]->licenses[0]->officialNum)->toBe('№ 50РПО0002118')
        ->and($result->items[0]->licenses[0]->addresses)->toBeArray()->toHaveCount(1)
        ->and($result->items[0]->licenses[1]->services)->toBeArray()->toHaveCount(2);
});

it('возвращает пустые массивы для отсутствующих services и addresses', function (): void {
    $json = '[{"inn":"7707083893","ogrn":"1027700132195","licenses":[{"source":"test"}]}]';

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $json),
    ]);

    $config = licensesConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new LicensesEndpoint(), $config->key))
        ->inn('7707083893')
        ->asDto()
        ->get();

    expect($result->items[0]->licenses[0]->services)->toBeArray()->toBeEmpty()
        ->and($result->items[0]->licenses[0]->addresses)->toBeArray()->toBeEmpty();
});

it('выбрасывает NotFoundException при ответе 404', function (): void {
    $mock = new MockHandler([
        new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
    ]);

    $config = licensesConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new LicensesEndpoint(), $config->key))
        ->inn('7707083893')
        ->asArray()
        ->get();
})->throws(NotFoundException::class);
