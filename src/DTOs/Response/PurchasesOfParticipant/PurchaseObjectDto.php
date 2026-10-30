<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Объект закупки.
 */
final readonly class PurchaseObjectDto
{
    /**
     * @param array<PurchaseProductCodeDto> $okpds Коды объекта по ОКПД
     * @param array<PurchaseProductCodeDto> $okdps Коды объекта по ОКДП
     * @param array<PurchaseProductCodeDto> $okpd2s Коды объекта по ОКПД2
     * @param array<PurchaseProductCodeDto> $ktrus Коды позиции КТРУ
     */
    public function __construct(
        /** Наименование объекта закупки */
        public ?string $name = null,
        #[ArrayOf(PurchaseProductCodeDto::class)]
        public array $okdps = [],
        #[ArrayOf(PurchaseProductCodeDto::class)]
        public array $okpds = [],
        #[ArrayOf(PurchaseProductCodeDto::class)]
        public array $okpd2s = [],
        #[ArrayOf(PurchaseProductCodeDto::class)]
        public array $ktrus = [],
    ) {
    }
}
