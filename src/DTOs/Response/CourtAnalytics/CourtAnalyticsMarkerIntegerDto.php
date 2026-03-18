<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CourtAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/courtAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class CourtAnalyticsMarkerIntegerDto
{
    public function __construct(
        /** Значение */
        public ?int $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
