# Changelog

Все заметные изменения в проекте фиксируются в этом файле.

Формат основан на [Keep a Changelog](https://keepachangelog.com/ru/1.1.0/),
проект придерживается [Semantic Versioning](https://semver.org/lang/ru/).

## [Unreleased]

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
