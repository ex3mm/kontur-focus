<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

/**
 * Информация о контракте или договоре.
 */
final readonly class PurchaseContractInfoDto
{
    public function __construct(
        /** Цена контракта */
        public ?PurchasePriceDto $price = null,
        /** Номер контракта */
        public ?string $number = null,
        /** Дата контракта */
        public ?string $date = null,
        /** Срок исполнения */
        public ?string $executionDate = null,
        /** Вид обеспечения исполнения контракта */
        public ?string $enforcement = null,
        /** Статус исполнения */
        public ?string $stage = null,
        /** Причина расторжения контракта/договора */
        public ?string $canceledReason = null,
        /** Признак частичного исполнения контракта/договора */
        public ?bool $partiallyExecuted = null,
    ) {
    }
}
