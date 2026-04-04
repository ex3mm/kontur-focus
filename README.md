# kontur-focus

PHP 8.5+ пакет для интеграции с API Контур.Фокус.

## Возможности

- standalone режим (чистый PHP, без фреймворка)
- Laravel интеграция (ServiceProvider, Facade, публикация конфига)
- fluent API для запросов (`inn()`, `ogrn()`, `param()`, `asDto()`, `asArray()`)
- строгий маппинг ответа в readonly DTO через Reflection
- retry middleware (сетевые ошибки, `5xx`, `429`)
- cache middleware с кешированием только успешных `2xx` ответов
- logging middleware с маскированием API ключа в query-параметре `key`

## Требования

- PHP `^8.5`
- расширение `ext-json`

## Установка

```bash
composer require ex3mm/kontur-focus
```

## Быстрый старт (standalone)

```php
<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\KonturFocusManager;

$config = KonturFocusConfig::fromArray(
    require __DIR__ . '/config/kontur-focus.standalone.php'
);

$focus = new KonturFocusManager($config);

$result = $focus->req()
    ->inn('7707083893')
    ->asDto()
    ->get();
```

## Быстрый старт (Laravel)

Provider и Facade подключаются через auto-discovery.

```php
use Ex3mm\KonturFocus\Laravel\Facades\KonturFocus;

// Вариант 1: Упрощённый синтаксис (рекомендуется)
$result = KonturFocus::getReq(inn: '7707083893');

// Вариант 2: Fluent API для гибкой настройки
$result = KonturFocus::req()
    ->inn('7707083893')
    ->asArray()
    ->get();
```

Публикация конфига:

```bash
php artisan vendor:publish --tag=kontur-focus-config
```

## Конфигурация

Файл: `config/kontur-focus.php`

Пример полного конфига:

```php
return [
    'key' => env('KONTUR_FOCUS_API_KEY', ''),
    'base_url' => env('KONTUR_FOCUS_BASE_URL', 'https://focus-api.kontur.ru'),

    'http' => [
        'timeout' => (float) env('KONTUR_FOCUS_TIMEOUT', 30),
        'connect_timeout' => (float) env('KONTUR_FOCUS_CONNECT_TIMEOUT', 10),
        'verify_ssl' => (bool) env('KONTUR_FOCUS_VERIFY_SSL', true),
    ],

    'retry' => [
        'enabled' => (bool) env('KONTUR_FOCUS_RETRY_ENABLED', true),
        'max_attempts' => (int) env('KONTUR_FOCUS_RETRY_ATTEMPTS', 3),
        'delay_ms' => (int) env('KONTUR_FOCUS_RETRY_DELAY', 500),
        'multiplier' => (float) env('KONTUR_FOCUS_RETRY_MULTIPLIER', 2),
        'max_delay_ms' => (int) env('KONTUR_FOCUS_RETRY_MAX_DELAY', 30000),
    ],

    'cache' => [
        'enabled' => (bool) env('KONTUR_FOCUS_CACHE_ENABLED', true),
        'ttl' => (int) env('KONTUR_FOCUS_CACHE_TTL', 3600),
        'store' => env('KONTUR_FOCUS_CACHE_STORE', 'default'),
        'namespace' => env('KONTUR_FOCUS_CACHE_NAMESPACE', 'kontur-focus'),
    ],

    'logging' => [
        'enabled' => (bool) env('KONTUR_FOCUS_LOG_ENABLED', true),
        'level' => env('KONTUR_FOCUS_LOG_LEVEL', 'basic'),
        'channel' => env('KONTUR_FOCUS_LOG_CHANNEL', 'default'),
        'max_body_size' => (int) env('KONTUR_FOCUS_LOG_MAX_BODY_SIZE', 10000),
    ],
];
```

### Параметры конфигурации

| Ключ | По умолчанию | Описание |
| --- | --- | --- |
| `key` | `''` | API ключ Контур.Фокус |
| `base_url` | `https://focus-api.kontur.ru` | Базовый URL API |
| `http.timeout` | `30` | Таймаут запроса в секундах |
| `http.connect_timeout` | `10` | Таймаут соединения в секундах |
| `http.verify_ssl` | `true` | Проверка SSL сертификата |
| `retry.enabled` | `true` | Включить retry middleware |
| `retry.max_attempts` | `3` | Максимум попыток (включая первую) |
| `retry.delay_ms` | `500` | Начальная задержка между попытками |
| `retry.multiplier` | `2` | Множитель backoff |
| `retry.max_delay_ms` | `30000` | Верхний лимит задержки |
| `cache.enabled` | `true` | Включить cache middleware |
| `cache.ttl` | `3600` | TTL кеша в секундах |
| `cache.store` | `default` | Имя store (оставлено для совместимости конфига) |
| `cache.namespace` | `kontur-focus` | Префикс namespace кеша |
| `logging.enabled` | `true` | Включить логирование |
| `logging.level` | `basic` | Уровень детализации контекста |
| `logging.channel` | `default` | Логический канал в конфиге пакета |
| `logging.max_body_size` | `10000` | Максимальный размер body в логах |

## Endpoint-ы

| Метод менеджера | URI | DTO по умолчанию | Требует `inn`/`ogrn` |
| --- | --- | --- | --- |
| `req()` | `/api3/req` | `ReqResponseDto` | Да |
| `egrDetails()` | `/api3/egrDetails` | `EgrDetailsResponseDto` | Да |
| `legalAnalytics()` | `/api3/legalAnalytics` | `LegalAnalyticsResponseDto` | Да |
| `bankruptcyAnalytics()` | `/api3/bankruptcyAnalytics` | `BankruptcyAnalyticsResponseDto` | Да |
| `courtAnalytics()` | `/api3/courtAnalytics` | `CourtAnalyticsResponseDto` | Да |
| `financeAnalytics()` | `/api3/financeAnalytics` | `FinanceAnalyticsResponseDto` | Да |
| `fsspAnalytics()` | `/api3/fsspAnalytics` | `FsspAnalyticsResponseDto` | Да |
| `linkAnalytics()` | `/api3/linkAnalytics` | `LinkAnalyticsResponseDto` | Да |
| `purchasesAnalytics()` | `/api3/purchasesAnalytics` | `PurchasesAnalyticsResponseDto` | Да |
| `licenses()` | `/api3/licences` | `LicensesResponseDto` | Да |
| `beneficiary()` | `/api3/beneficialOwners` | `BeneficiaryResponseDTO` | Да |
| `custom('/api3/...')` | произвольный | нет | Нет |

## Использование RequestBuilder

### Упрощённые методы фассада

```php
use Ex3mm\KonturFocus\Laravel\Facades\KonturFocus;

// Получить данные по ИНН
$result = KonturFocus::getReq(inn: '7707083893');

// Получить данные по ОГРН
$result = KonturFocus::getEgrDetails(ogrn: '1027700132195');

// Можно передать оба параметра
$result = KonturFocus::getLegalAnalytics(
    inn: '7707083893',
    ogrn: '1027700132195'
);

// Доступные методы:

| Метод | Параметры | Возвращает |
| --- | --- | --- |
| `getReq()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getEgrDetails()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getLegalAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getBankruptcyAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getCourtAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getFinanceAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getFsspAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getLinkAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getPurchasesAnalytics()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getLicenses()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |
| `getBeneficiary()` | `?string $inn = null, ?string $ogrn = null` | `CollectionResponse` |

// Все методы возвращают CollectionResponse
$result->items;      // array<DTO>
$result->first();    // DTO|null
$result->isEmpty();  // bool
```

### Режим `asArray()`

```php
$data = $focus->req()
    ->inn('7707083893')
    ->asArray()
    ->get();
```

### Режим `asDto()`

```php
$result = $focus->req()
    ->inn('7707083893')
    ->asDto()
    ->get();

// $result - это CollectionResponse с полями:
// - items: array<DTO> - массив DTO объектов
// - raw: string - сырой JSON ответ
// - total: int - количество элементов

// Получить первый элемент
$dto = $result->first();

// Проверить пустоту
if ($result->isEmpty()) {
    // нет данных
}

// Получить массив DTO
$items = $result->toArray();
```

### Выброс исключения при пустом результате

```php
use Ex3mm\KonturFocus\Exceptions\EmptyResponseException;

try {
    $result = $focus->req()
        ->inn('7707083893')
        ->asDto()
        ->throwOnEmpty() // выбросит EmptyResponseException если total === 0
        ->get();
} catch (EmptyResponseException $e) {
    // обработка пустого результата
}
```

### Кастомный endpoint

```php
$result = $focus->custom('/api3/someEndpoint')
    ->param('foo', 'bar')
    ->param('limit', 10)
    ->asArray()
    ->get();
```

### Валидация параметров

Для стандартных endpoint-ов запрос должен содержать хотя бы один параметр: `inn` или `ogrn`.
Если оба пустые, выбрасывается `RequestValidationException`.

## DTO и маппинг

`ResponseMapper` строит DTO через Reflection-конструктор и имена параметров.

- скалярные поля валидируются по типу
- вложенные DTO создаются рекурсивно
- массивы DTO/скаляров требуют `#[ArrayOf(...)]`
- все DTO-ответы оборачиваются в `CollectionResponse` с полями `items`, `raw`, `total`

### CollectionResponse

Все запросы в режиме `asDto()` возвращают `CollectionResponse`:

```php
$result = $focus->req()->inn('7707083893')->asDto()->get();

// Доступные методы:
$result->items;      // array<DTO> - массив DTO объектов
$result->raw;        // string - сырой JSON ответ
$result->total;      // int - количество элементов
$result->first();    // DTO|null - первый элемент или null
$result->toArray();  // array<DTO> - массив DTO
$result->count();    // int - количество элементов
$result->isEmpty();  // bool - проверка на пустоту
$result->isNotEmpty(); // bool - проверка на наличие данных
```

Пример DTO с массивом вложенных объектов:

```php
use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

final readonly class ParentDto
{
    /**
     * @param array<ChildDto> $children
     */
    public function __construct(
        #[ArrayOf(ChildDto::class)]
        public array $children,
    ) {
    }
}
```

## Ошибки и исключения

### HTTP ошибки

| Статус | Исключение |
| --- | --- |
| `400`, `422` | `ValidationException` |
| `401` | `AuthenticationException` |
| `403` | `AuthorizationException` |
| `404` | `NotFoundException` |
| `409` | `ConflictException` |
| `429` | `RateLimitException` (`retryAfterSeconds` заполнен при наличии `Retry-After`) |
| `5xx` | `ServerException` |
| другое `4xx/5xx` | `HttpException` |

### Прочие ошибки

- `NetworkException` — сетевые/транспортные проблемы Guzzle
- `InvalidResponseException` — пустой `2xx` body, не-JSON `Content-Type`, невалидный JSON
- `DtoMappingException` — mismatch типов/структуры при маппинге
- `ConfigurationException` — неверная конфигурация (`key`, `base_url`, `logging.level`, и т.д.)
- `RequestValidationException` — не переданы обязательные query-параметры (`inn`/`ogrn`)

## Retry / Cache / Logging

### Retry middleware

Повтор выполняется если:

- есть transport-исключение
- ответ `429`
- ответ `>= 500`

Задержка рассчитывается из `retry.delay_ms` + `retry.multiplier`, с ограничением `retry.max_delay_ms`.
Для `429` при наличии `Retry-After` используется значение заголовка.

### Cache middleware

- кешируются только ответы со статусом `2xx`
- ключ кеша нормализует query-параметры
- значение query-параметра `key` хешируется (`sha256`) и не попадает в кеш-ключ в открытом виде

### Logging middleware

Поддерживаемые уровни: `none`, `error`, `basic`, `headers`, `body`, `debug`.

- в лог всегда пишется краткая строка запроса (`METHOD URL`)
- API ключ в query-параметре `key` маскируется (`***`)
- в зависимости от уровня добавляются заголовки и body
