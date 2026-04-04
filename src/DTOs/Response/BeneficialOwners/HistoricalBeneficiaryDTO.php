<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BeneficialOwners;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Исторические конечные владельцы
 */
readonly class HistoricalBeneficiaryDTO
{
    /**
     * @param BeneficialOwnerFLDTO[] $beneficialOwnersFL Конечные владельцы - физлица
     * @param BeneficialOwnerULDTO[] $beneficialOwnersUL Конечные владельцы - юрлица
     * @param BeneficialOwnerForeignDTO[] $beneficialOwnersForeign Конечные владельцы - иностранные компании
     * @param BeneficialOwnerOtherDTO[] $beneficialOwnersOther Конечные владельцы - без категории
     */
    public function __construct(
        #[ArrayOf(BeneficialOwnerFLDTO::class)]
        public array $beneficialOwnersFL = [],
        #[ArrayOf(BeneficialOwnerULDTO::class)]
        public array $beneficialOwnersUL = [],
        #[ArrayOf(BeneficialOwnerForeignDTO::class)]
        public array $beneficialOwnersForeign = [],
        #[ArrayOf(BeneficialOwnerOtherDTO::class)]
        public array $beneficialOwnersOther = [],
    ) {
    }
}
