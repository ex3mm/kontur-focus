<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

/**
 * Конечный владелец - юридическое лицо
 */
readonly class BeneficialOwnerULDTO
{
    public function __construct(
        /** ОГРН */
        public ?string $ogrn,
        /** ИНН */
        public ?string $inn,
        /** Полное наименование юридического лица */
        public ?string $fullName,
        /** Размер доли в процентах. Доля вычисляется по цепочке учредителей и акционеров. */
        public ?float $share,
        /** Признак точной доли */
        public ?bool $isAccurate,
    ) {
    }
}
