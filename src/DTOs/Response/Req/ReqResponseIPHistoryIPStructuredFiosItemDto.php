<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseIPHistoryIPStructuredFiosItemDto
{
    public function __construct(
        /** Структурированное ФИО */
        public ?ReqStructuredFioDto $structuredFio = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
