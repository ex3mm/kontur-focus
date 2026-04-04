<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

/**
 * Уставный капитал
 */
readonly class StatedCapitalDTO
{
    public function __construct(
        /** Сумма в рублях */
        public ?float $sum,
        /** Дата */
        public ?string $date,
    ) {
    }
}
