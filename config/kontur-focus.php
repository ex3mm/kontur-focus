<?php

declare(strict_types=1);

return [
    // API ключ Контур.Фокус
    'key' => env('KONTUR_FOCUS_API_KEY', ''),

    // Базовый URL API
    'base_url' => env('KONTUR_FOCUS_BASE_URL', 'https://focus-api.kontur.ru'),

    'http' => [
        // Таймаут запроса в секундах
        'timeout' => (float) env('KONTUR_FOCUS_TIMEOUT', 30),

        // Таймаут соединения в секундах
        'connect_timeout' => (float) env('KONTUR_FOCUS_CONNECT_TIMEOUT', 10),

        // Проверка SSL сертификата
        'verify_ssl' => (bool) env('KONTUR_FOCUS_VERIFY_SSL', true),
    ],

    'retry' => [
        // Включить retry middleware
        'enabled' => (bool) env('KONTUR_FOCUS_RETRY_ENABLED', true),

        // Максимум попыток (включая первую)
        'max_attempts' => (int) env('KONTUR_FOCUS_RETRY_ATTEMPTS', 3),

        // Начальная задержка между попытками (мс)
        'delay_ms' => (int) env('KONTUR_FOCUS_RETRY_DELAY', 500),

        // Множитель backoff
        'multiplier' => (float) env('KONTUR_FOCUS_RETRY_MULTIPLIER', 2),

        // Верхний лимит задержки (мс)
        'max_delay_ms' => (int) env('KONTUR_FOCUS_RETRY_MAX_DELAY', 30_000),
    ],

    'cache' => [
        // Включить cache middleware
        'enabled' => (bool) env('KONTUR_FOCUS_CACHE_ENABLED', true),

        // TTL кеша в секундах
        'ttl' => (int) env('KONTUR_FOCUS_CACHE_TTL', 3600),


        // Имя store (оставлено для совместимости конфига)
        'store' => env('KONTUR_FOCUS_CACHE_STORE', 'default'),

        // Префикс namespace кеша
        'namespace' => env('KONTUR_FOCUS_CACHE_NAMESPACE', 'kontur-focus'),
    ],

    'logging' => [
        // Включить логирование
        'enabled' => (bool) env('KONTUR_FOCUS_LOG_ENABLED', true),

        // Уровень детализации контекста (none, error, basic, headers, body, debug)
        'level' => env('KONTUR_FOCUS_LOG_LEVEL', 'basic'),

        // Логический канал в конфиге пакета
        'channel' => env('KONTUR_FOCUS_LOG_CHANNEL', 'default'),

        // Максимальный размер body в логах
        'max_body_size' => (int) env('KONTUR_FOCUS_LOG_MAX_BODY_SIZE', 10_000),
    ],
];
