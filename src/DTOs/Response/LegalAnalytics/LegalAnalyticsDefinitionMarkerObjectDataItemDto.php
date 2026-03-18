<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\LegalAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/legalAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class LegalAnalyticsDefinitionMarkerObjectDataItemDto
{
    public function __construct(
        /** Дата состояния */
        public ?string $date = null,
        /** Среднесписочная численность сотрудников */
        public ?int $staffNumber = null,
    ) {
    }
}
