<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

/**
 * Конечный владелец - без категории. Это могут быть юрлица, физлица и иностранные лица
 */
readonly class BeneficialOwnerOtherDTO
{
    public function __construct(
        /** Полное наименование лица */
        public ?string $fullName,
        /** Размер доли в процентах. Доля вычисляется по цепочке учредителей и акционеров. */
        public ?float $share,
        /** Признак точной доли */
        public ?bool $isAccurate,
    ) {
    }
}
