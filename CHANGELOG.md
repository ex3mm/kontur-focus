# Changelog

Все заметные изменения в проекте фиксируются в этом файле.

Формат основан на [Keep a Changelog](https://keepachangelog.com/ru/1.1.0/),
проект придерживается [Semantic Versioning](https://semver.org/lang/ru/).

## [Unreleased]

## [1.3.0] - 2025-04-04

### Added

- Добавлены упрощённые методы в фасад:
  - `getReq(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getEgrDetails(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getLegalAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getBankruptcyAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getCourtAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getFinanceAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getFsspAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getLinkAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getPurchasesAnalytics(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getLicenses(?string $inn = null, ?string $ogrn = null): CollectionResponse`
  - `getBeneficiary(?string $inn = null, ?string $ogrn = null): CollectionResponse`

## [1.2.0] - 2025-04-04

### Added

- Добавлен endpoint `beneficiary()` для получения конечных бенефициаров компании (`/api3/beneficialOwners`)

## [1.1.0] - 2025-04-04

### Added

- Добавлен endpoint `licenses()` для получения лицензий (`/api3/licences`)

## [1.0.1] - 2025-04-04

### Fixed

- Исправлено логирование тела ответа.

## [1.0.0] - 2025-03-18

### Added

- Реализован пакет `kontur-focus` с standalone и Laravel интеграцией
- Поддержка PHP 8.5+
- Fluent API для построения запросов (`inn()`, `ogrn()`, `param()`, `asDto()`, `asArray()`)
- Endpoint-обертки: `req`, `egrDetails`, `legalAnalytics`, `bankruptcyAnalytics`, `courtAnalytics`, `financeAnalytics`, `fsspAnalytics`, `linkAnalytics`, `purchasesAnalytics`, `custom`
- `ResponseMapper` на Reflection с поддержкой `#[ArrayOf]` для типизации массивов
- Readonly DTO, сгенерированные из схем API
- `CollectionResponse` - обертка для всех DTO-ответов с полями `items`, `raw`, `total` и методами `first()`, `isEmpty()`, `isNotEmpty()`, `toArray()`, `count()`
- Метод `throwOnEmpty()` для выброса `EmptyResponseException` при пустом результате
- Retry middleware с exponential backoff для сетевых ошибок, 5xx и 429 ответов
- Cache middleware с кешированием только успешных 2xx ответов
- Logging middleware с уровнями детализации (none, error, basic, headers, body, debug)
- Уникальный request ID для каждого запроса в логах
- Маскирование API ключа в логах (`key=***hidden***`)
- Laravel ServiceProvider с auto-discovery
- Фасад Laravel
- Публикация конфигурации через `vendor:publish`

### Security

- API ключ маскируется в логах и не попадает в открытом виде
- Ключ хешируется (SHA-256) для формирования cache-ключей
