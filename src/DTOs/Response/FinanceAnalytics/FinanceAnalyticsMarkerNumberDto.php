<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FinanceAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/financeAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FinanceAnalyticsMarkerNumberDto
{
    public function __construct(
        /** Значение */
        public ?float $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
