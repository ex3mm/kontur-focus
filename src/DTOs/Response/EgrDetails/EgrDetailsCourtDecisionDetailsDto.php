<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsCourtDecisionDetailsDto
{
    public function __construct(
        /** Номер решения суда, на основании которого сведения признаны недостоверными */
        public ?string $decisionNumber = null,
        /** Наименование суда, которым принято решение */
        public ?string $courtName = null,
        /** Дата решения суда */
        public ?string $date = null,
    ) {
    }
}
