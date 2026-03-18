<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BankruptcyAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/bankruptcyAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class BankruptcyAnalyticsMarkerStringDto
{
    public function __construct(
        /** Значение */
        public ?string $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
