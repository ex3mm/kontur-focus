<?php

declare(strict_types=1);

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Endpoints\ReqEndpoint;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

function cacheConfig(array $override = []): KonturFocusConfig
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
            'enabled' => true,
            'ttl' => 3600,
            'store' => 'default',
            'namespace' => 'test',
        ],
    ];

    return KonturFocusConfig::fromArray(array_replace_recursive($base, $override));
}

it('кеширует успешные ответы 2xx', function (): void {
    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], '{"inn":"7707083893"}'),
    ]);

    $config = cacheConfig();
    $factory = new GuzzleClientFactory(new ArrayAdapter(), null, $mock);
    $client = new KonturFocusClient($config, $factory);

    $builder = new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key);

    $first = $builder->inn('7707083893')->asArray()->get();
    $second = $builder->inn('7707083893')->asArray()->get();

    expect($first['inn'])->toBe('7707083893')
        ->and($second['inn'])->toBe('7707083893')
        ->and(count($mock))->toBe(0);
});

it('не кеширует ответы 4xx', function (): void {
    $mock = new MockHandler([
        new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
        new Response(200, ['Content-Type' => 'application/json'], '{"inn":"7707083893"}'),
    ]);

    $config = cacheConfig();
    $factory = new GuzzleClientFactory(new ArrayAdapter(), null, $mock);
    $client = new KonturFocusClient($config, $factory);

    $builder = new RequestBuilder($client, new ResponseMapper(), new ReqEndpoint(), $config->key);

    expect(fn () => $builder->inn('7707083893')->asArray()->get())->toThrow(NotFoundException::class);

    $result = $builder->inn('7707083893')->asArray()->get();

    expect($result['inn'])->toBe('7707083893')
        ->and(count($mock))->toBe(0);
});
