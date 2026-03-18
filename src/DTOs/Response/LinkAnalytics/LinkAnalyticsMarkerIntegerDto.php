<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\LinkAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/linkAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class LinkAnalyticsMarkerIntegerDto
{
    public function __construct(
        /** Значение */
        public ?int $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
