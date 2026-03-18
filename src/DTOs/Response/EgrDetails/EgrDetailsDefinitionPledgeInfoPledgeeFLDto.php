<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsDefinitionPledgeInfoPledgeeFLDto
{
    public function __construct(
        /** ФИО физического лица */
        public ?string $fio = null,
        /** ИННФЛ */
        public ?string $innfl = null,
        /** Сведения о нотариальном удостоверении договора залога */
        public ?EgrDetailsNotarizationDto $notarization = null,
    ) {
    }
}
