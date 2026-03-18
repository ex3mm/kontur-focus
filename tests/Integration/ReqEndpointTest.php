<?php

declare(strict_types=1);

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Endpoints\ReqEndpoint;
use Ex3mm\KonturFocus\Exceptions\AuthenticationException;
use Ex3mm\KonturFocus\Exceptions\NetworkException;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;

function integrationConfig(array $override = []): KonturFocusConfig
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

it('возвращает список dto для корректного ответа req', function (): void {
    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], '[{"inn":"7707083893"}]'),
    ]);

    $config = integrationConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key))
        ->inn('7707083893')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(\Ex3mm\KonturFocus\DTOs\CollectionResponse::class)
        ->and($result->items)->toBeArray()
        ->and($result->items[0]->inn)->toBe('7707083893')
        ->and($result->raw)->toContain('7707083893');
});

it('выбрасывает NotFoundException при ответе 404', function (): void {
    $mock = new MockHandler([
        new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
    ]);

    $config = integrationConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key))
        ->inn('7707083893')
        ->asArray()
        ->get();
})->throws(NotFoundException::class);

it('выбрасывает AuthenticationException при ответе 401', function (): void {
    $mock = new MockHandler([
        new Response(401, ['Content-Type' => 'application/json'], '{"error":"unauthorized"}'),
    ]);

    $config = integrationConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key))
        ->inn('7707083893')
        ->asArray()
        ->get();
})->throws(AuthenticationException::class);

it('выбрасывает NetworkException при ошибке соединения', function (): void {
    $request = new Request('GET', '/api3/req');

    $mock = new MockHandler([
        new ConnectException('network down', $request),
    ]);

    $config = integrationConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key))
        ->inn('7707083893')
        ->asArray()
        ->get();
})->throws(NetworkException::class);
