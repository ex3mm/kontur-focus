<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FsspAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/fsspAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FsspAnalyticsMarkerNumberDto
{
    public function __construct(
        /** Значение */
        public ?float $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
