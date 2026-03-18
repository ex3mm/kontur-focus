<?php

declare(strict_types=1);

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Endpoints\ReqEndpoint;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;

function retryConfig(array $override = []): KonturFocusConfig
{
    $base = [
        'key' => 'test-key',
        'base_url' => 'https://focus-api.kontur.ru',
        'retry' => [
            'enabled' => true,
            'max_attempts' => 2,
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

it('повторяет запрос при 5xx и успешно выполняется со второй попытки', function (): void {
    $mock = new MockHandler([
        new Response(500, ['Content-Type' => 'application/json'], '{"error":"temporary"}'),
        new Response(200, ['Content-Type' => 'application/json'], '{"inn":"7707083893"}'),
    ]);

    $config = retryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key))
        ->inn('7707083893')
        ->asArray()
        ->get();

    expect($result['inn'])->toBe('7707083893')
        ->and(count($mock))->toBe(0);
});

it('повторяет запрос при 429 с retry-after и успешно завершается', function (): void {
    $mock = new MockHandler([
        new Response(429, ['Retry-After' => '0', 'Content-Type' => 'application/json'], '{"error":"rate limit"}'),
        new Response(200, ['Content-Type' => 'application/json'], '{"inn":"7707083893"}'),
    ]);

    $config = retryConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key))
        ->inn('7707083893')
        ->asArray()
        ->get();

    expect($result['inn'])->toBe('7707083893')
        ->and(count($mock))->toBe(0);
});
