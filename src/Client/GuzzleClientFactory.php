<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Middleware\LoggingMiddleware;
use Ex3mm\KonturFocus\Middleware\RetryMiddleware;
use Ex3mm\KonturFocus\Middleware\SuccessOnlyCacheStrategy;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

final class GuzzleClientFactory
{
    /**
     * @param callable|null $handler
     */
    public function __construct(
        private readonly ?CacheItemPoolInterface $cachePool = null,
        private readonly ?LoggerInterface $logger = null,
        private readonly mixed $handler = null,
    ) {
    }

    public function create(KonturFocusConfig $config): Client
    {
        $stack = HandlerStack::create($this->handler);

        if ($config->retry->enabled) {
            $stack->push(RetryMiddleware::create($config->retry), 'kontur-focus.retry');
        }

        if (!$config->logging->isDisabled()) {
            $stack->push(
                LoggingMiddleware::create($config->logging, $this->logger ?? new NullLogger()),
                'kontur-focus.logging',
            );
        }

        if ($config->cache->enabled) {
            $stack->push($this->cacheMiddleware($config), 'kontur-focus.cache');
        }

        return new Client([
            'base_uri' => $config->baseUrl,
            'timeout' => $config->http->timeout,
            'connect_timeout' => $config->http->connectTimeout,
            'verify' => $config->http->verifySsl,
            'handler' => $stack,
            'http_errors' => false,
        ]);
    }

    private function cacheMiddleware(KonturFocusConfig $config): CacheMiddleware
    {
        $pool = $this->cachePool ?? new FilesystemAdapter(
            $config->cache->namespace,
            $config->cache->ttl,
            sys_get_temp_dir().'/kontur-focus-cache',
        );

        $storage = new Psr6CacheStorage($pool);
        $strategy = new SuccessOnlyCacheStrategy($storage, $config->cache->ttl);

        return new CacheMiddleware($strategy);
    }
}
