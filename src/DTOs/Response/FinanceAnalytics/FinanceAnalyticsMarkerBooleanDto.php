<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FinanceAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/financeAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FinanceAnalyticsMarkerBooleanDto
{
    public function __construct(
        /** Значение */
        public ?bool $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
