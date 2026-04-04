<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

/**
 * Конечный владелец - иностранная компания
 */
readonly class BeneficialOwnerForeignDTO
{
    public function __construct(
        /** Полное наименование юридического лица */
        public ?string $fullName,
        /** Страна */
        public ?string $country,
        /** Размер доли в процентах. Доля вычисляется по цепочке учредителей и акционеров. */
        public ?float $share,
        /** Признак точной доли */
        public ?bool $isAccurate,
    ) {
    }
}
