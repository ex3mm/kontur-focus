<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

/**
 * Ответ API с информацией о конечных бенефициарах компании
 */
readonly class BeneficiaryResponseDTO
{
    public function __construct(
        /** ИНН(ИП) */
        public ?string $inn,
        /** ОГРН(ИП) */
        public ?string $ogrn,
        /** Ссылка на карточку юридического лица (ИП) в Контур.Фокусе */
        public ?string $focusHref,
        /** Уставный капитал */
        public ?StatedCapitalDTO $statedCapital,
        /** Предполагаемые конечные владельцы */
        public ?BeneficiaryDTO $beneficialOwners,
        /** Исторические конечные владельцы */
        public ?HistoricalBeneficiaryDTO $historicalBeneficialOwners,
    ) {
    }
}
