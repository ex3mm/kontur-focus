<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\LegalAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/legalAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class LegalAnalyticsMarkerDateDto
{
    public function __construct(
        /** Значение */
        public ?string $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
