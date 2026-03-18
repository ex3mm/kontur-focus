<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Config;

use Ex3mm\KonturFocus\Exceptions\ConfigurationException;

readonly class KonturFocusConfig
{
    public function __construct(
        public string $key,
        public string $baseUrl,
        public HttpConfig $http,
        public RetryConfig $retry,
        public CacheConfig $cache,
        public LoggingConfig $logging,
    ) {
    }

    /**
     * @param array<string, mixed> $config
     */
    public static function fromArray(array $config): self
    {
        $key = trim(self::string($config['key'] ?? ''));
        if ($key === '') {
            throw ConfigurationException::missingApiKey();
        }

        $baseUrl = rtrim(self::string($config['base_url'] ?? 'https://focus-api.kontur.ru'), '/');
        if (filter_var($baseUrl, FILTER_VALIDATE_URL) === false) {
            throw ConfigurationException::invalidBaseUrl($baseUrl);
        }

        $http = (array) ($config['http'] ?? []);
        $retry = (array) ($config['retry'] ?? []);
        $cache = (array) ($config['cache'] ?? []);
        $logging = (array) ($config['logging'] ?? []);

        return new self(
            key: $key,
            baseUrl: $baseUrl,
            http: new HttpConfig(
                timeout: self::float($http['timeout'] ?? 30.0),
                connectTimeout: self::float($http['connect_timeout'] ?? 10.0),
                verifySsl: self::bool($http['verify_ssl'] ?? true),
            ),
            retry: new RetryConfig(
                enabled: self::bool($retry['enabled'] ?? true),
                maxAttempts: max(1, self::int($retry['max_attempts'] ?? 3)),
                delayMs: max(0, self::int($retry['delay_ms'] ?? 500)),
                multiplier: max(1.0, self::float($retry['multiplier'] ?? 2.0)),
                maxDelayMs: max(0, self::int($retry['max_delay_ms'] ?? 30_000)),
            ),
            cache: new CacheConfig(
                enabled: self::bool($cache['enabled'] ?? true),
                ttl: max(0, self::int($cache['ttl'] ?? 3600)),
                store: self::string($cache['store'] ?? 'default'),
                namespace: self::string($cache['namespace'] ?? 'kontur-focus'),
            ),
            logging: new LoggingConfig(
                enabled: self::bool($logging['enabled'] ?? true),
                level: self::string($logging['level'] ?? LoggingConfig::LEVEL_BASIC),
                channel: self::string($logging['channel'] ?? 'default'),
                maxBodySize: max(0, self::int($logging['max_body_size'] ?? 10_000)),
            ),
        );
    }

    public function hash(): string
    {
        return hash('sha256', json_encode([
            'key' => $this->key,
            'baseUrl' => $this->baseUrl,
            'http' => [$this->http->timeout, $this->http->connectTimeout, $this->http->verifySsl],
            'retry' => [$this->retry->enabled, $this->retry->maxAttempts, $this->retry->delayMs, $this->retry->multiplier, $this->retry->maxDelayMs],
            'cache' => [$this->cache->enabled, $this->cache->ttl, $this->cache->namespace],
            'logging' => [$this->logging->enabled, $this->logging->level, $this->logging->maxBodySize],
        ], JSON_THROW_ON_ERROR));
    }

    private static function bool(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return $value === 1;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    private static function int(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value)) {
            return (int) $value;
        }

        if (is_string($value) && is_numeric($value)) {
            return (int) $value;
        }

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        return 0;
    }

    private static function float(mixed $value): float
    {
        if (is_float($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (float) $value;
        }

        if (is_string($value) && is_numeric($value)) {
            return (float) $value;
        }

        if (is_bool($value)) {
            return $value ? 1.0 : 0.0;
        }

        return 0.0;
    }

    private static function string(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_bool($value)) {
            return (string) $value;
        }

        return '';
    }
}
