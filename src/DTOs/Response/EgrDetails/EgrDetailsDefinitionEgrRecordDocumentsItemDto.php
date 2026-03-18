<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsDefinitionEgrRecordDocumentsItemDto
{
    public function __construct(
        /** Имя документа */
        public ?string $name = null,
        /** Дата документа */
        public ?string $date = null,
    ) {
    }
}
