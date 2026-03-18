<?php

declare(strict_types=1);

return [
    'key' => (static function (): string {
        $value = getenv('KONTUR_FOCUS_API_KEY');

        return $value !== false ? (string) $value : '';
    })(),

    'base_url' => (static function (): string {
        $value = getenv('KONTUR_FOCUS_BASE_URL');

        return $value !== false ? (string) $value : 'https://focus-api.kontur.ru';
    })(),

    'http' => [
        'timeout' => (float) (static function (): int|float {
            $value = getenv('KONTUR_FOCUS_TIMEOUT');

            return $value !== false ? (float) $value : 30;
        })(),
        'connect_timeout' => (float) (static function (): int|float {
            $value = getenv('KONTUR_FOCUS_CONNECT_TIMEOUT');

            return $value !== false ? (float) $value : 10;
        })(),
        'verify_ssl' => filter_var(
            (static function (): string|bool {
                $value = getenv('KONTUR_FOCUS_VERIFY_SSL');

                return $value !== false ? $value : true;
            })(),
            FILTER_VALIDATE_BOOL
        ),
    ],

    'retry' => [
        'enabled' => filter_var(
            (static function (): string|bool {
                $value = getenv('KONTUR_FOCUS_RETRY_ENABLED');


                return $value !== false ? $value : true;
            })(),
            FILTER_VALIDATE_BOOL
        ),
        'max_attempts' => (int) (static function (): int {
            $value = getenv('KONTUR_FOCUS_RETRY_ATTEMPTS');

            return $value !== false ? (int) $value : 3;
        })(),
        'delay_ms' => (int) (static function (): int {
            $value = getenv('KONTUR_FOCUS_RETRY_DELAY');

            return $value !== false ? (int) $value : 500;
        })(),
        'multiplier' => (float) (static function (): int|float {
            $value = getenv('KONTUR_FOCUS_RETRY_MULTIPLIER');

            return $value !== false ? (float) $value : 2;
        })(),
        'max_delay_ms' => (int) (static function (): int {
            $value = getenv('KONTUR_FOCUS_RETRY_MAX_DELAY');

            return $value !== false ? (int) $value : 30_000;
        })(),
    ],

    'cache' => [
        'enabled' => filter_var(
            (static function (): string|bool {
                $value = getenv('KONTUR_FOCUS_CACHE_ENABLED');

                return $value !== false ? $value : true;
            })(),
            FILTER_VALIDATE_BOOL
        ),
        'ttl' => (int) (static function (): int {
            $value = getenv('KONTUR_FOCUS_CACHE_TTL');

            return $value !== false ? (int) $value : 3600;
        })(),
        'store' => (string) (static function (): string {
            $value = getenv('KONTUR_FOCUS_CACHE_STORE');

            return $value !== false ? (string) $value : 'default';
        })(),
        'namespace' => (string) (static function (): string {
            $value = getenv('KONTUR_FOCUS_CACHE_NAMESPACE');

            return $value !== false ? (string) $value : 'kontur-focus';
        })(),
    ],

    'logging' => [
        'enabled' => filter_var(
            (static function (): string|bool {
                $value = getenv('KONTUR_FOCUS_LOG_ENABLED');

                return $value !== false ? $value : true;
            })(),
            FILTER_VALIDATE_BOOL
        ),
        'level' => (string) (static function (): string {
            $value = getenv('KONTUR_FOCUS_LOG_LEVEL');

            return $value !== false ? (string) $value : 'basic';
        })(),
        'channel' => (string) (static function (): string {
            $value = getenv('KONTUR_FOCUS_LOG_CHANNEL');

            return $value !== false ? (string) $value : 'default';
        })(),
        'max_body_size' => (int) (static function (): int {
            $value = getenv('KONTUR_FOCUS_LOG_MAX_BODY_SIZE');

            return $value !== false ? (int) $value : 10_000;
        })(),
    ],
];
