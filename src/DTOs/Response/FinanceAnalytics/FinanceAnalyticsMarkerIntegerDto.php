<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FinanceAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/financeAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FinanceAnalyticsMarkerIntegerDto
{
    public function __construct(
        /** Значение */
        public ?int $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
