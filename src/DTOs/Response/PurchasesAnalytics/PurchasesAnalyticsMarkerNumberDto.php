<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/purchasesAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class PurchasesAnalyticsMarkerNumberDto
{
    public function __construct(
        /** Значение */
        public ?float $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
