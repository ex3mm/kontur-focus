<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\LegalAnalytics;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/legalAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class LegalAnalyticsMarkerObjectDto
{
    /**
 * @param array<LegalAnalyticsDefinitionMarkerObjectDataItemDto>|null $data
 */
    public function __construct(
        #[ArrayOf(LegalAnalyticsDefinitionMarkerObjectDataItemDto::class)]
        /** @var array<LegalAnalyticsDefinitionMarkerObjectDataItemDto>|null data */
        public ?array $data = null,
        /** Признак актуальности */
        public ?bool $isActual = null,
    ) {
    }
}
