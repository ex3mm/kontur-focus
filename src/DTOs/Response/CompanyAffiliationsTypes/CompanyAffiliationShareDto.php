<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

/**
 * Доля владения участника или учредителя.
 */
final readonly class CompanyAffiliationShareDto
{
    public function __construct(
        /** Сумма в рублях */
        public ?float $sum = null,
        /** Размер доли в процентах */
        public ?float $percentagePlain = null,
        /** Числитель размера доли в виде простой дроби */
        public ?int $percentageNominator = null,
        /** Знаменатель размера доли в виде простой дроби */
        public ?int $percentageDenominator = null,
    ) {
    }
}
