<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsDefinitionEgrRecordCertificatesItemDto
{
    public function __construct(
        /** Серия и номер */
        public ?string $serialNumber = null,
        /** Дата выдачи */
        public ?string $date = null,
    ) {
    }
}
