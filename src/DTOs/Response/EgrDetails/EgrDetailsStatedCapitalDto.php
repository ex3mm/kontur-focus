<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsStatedCapitalDto
{
    public function __construct(
        /** Сумма в рублях */
        public ?float $sum = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
