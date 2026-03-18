<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsShareDto
{
    public function __construct(
        /** Сумма в рублях */
        public ?float $sum = null,
        /** Размер доли в процентах */
        public ?float $percentagePlain = null,
        /** Размер доли в виде простой дроби (числитель) */
        public ?int $percentageNominator = null,
        /** Размер доли в виде простой дроби (знаменатель) */
        public ?int $percentageDenominator = null,
    ) {
    }
}
