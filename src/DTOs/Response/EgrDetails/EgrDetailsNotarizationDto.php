<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsNotarizationDto
{
    public function __construct(
        /** ФИО нотариуса */
        public ?string $fio = null,
        /** ИННФЛ нотариуса */
        public ?string $innfl = null,
        /** Номер договора залога */
        public ?string $contractNumber = null,
        /** Дата договора залога */
        public ?string $date = null,
    ) {
    }
}
