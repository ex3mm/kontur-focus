<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Exceptions\ConfigurationException;

it('разбирает типизированный конфиг из массива', function (): void {
    $config = KonturFocusConfig::fromArray([
        'key' => 'secret',
        'base_url' => 'https://focus-api.kontur.ru',
        'http' => ['timeout' => 15, 'connect_timeout' => 5, 'verify_ssl' => false],
        'retry' => ['enabled' => true, 'max_attempts' => 4, 'delay_ms' => 200, 'multiplier' => 2, 'max_delay_ms' => 1000],
        'cache' => ['enabled' => true, 'ttl' => 600, 'store' => 'default', 'namespace' => 'kf'],
        'logging' => ['enabled' => true, 'level' => 'basic', 'channel' => 'stack', 'max_body_size' => 1000],
    ]);

    expect($config->key)->toBe('secret')
        ->and($config->http->timeout)->toBe(15.0)
        ->and($config->retry->maxAttempts)->toBe(4)
        ->and($config->cache->ttl)->toBe(600)
        ->and($config->logging->level)->toBe('basic');
});

it('выбрасывает исключение если api ключ не передан', function (): void {
    KonturFocusConfig::fromArray([
        'key' => '',
    ]);
})->throws(ConfigurationException::class);
