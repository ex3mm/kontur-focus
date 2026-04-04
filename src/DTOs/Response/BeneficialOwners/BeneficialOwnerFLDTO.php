<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

/**
 * Конечный владелец - физическое лицо
 */
readonly class BeneficialOwnerFLDTO
{
    public function __construct(
        /** ФИО */
        public ?string $fio,
        /** ИНН физического лица */
        public ?string $innfl,
        /** Размер доли в процентах. Доля вычисляется по цепочке учредителей и акционеров. */
        public ?float $share,
        /** Признак точной доли */
        public ?bool $isAccurate,
    ) {
    }
}
