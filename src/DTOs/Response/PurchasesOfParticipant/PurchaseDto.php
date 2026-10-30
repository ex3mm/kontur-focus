<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Закупка, в которой организация принимала участие.
 */
final readonly class PurchaseDto
{
    /**
     * @param array<PurchaseCustomerDto> $customers Заказчики
     * @param array<PurchaseParticipantDto> $participants Участники
     * @param array<PurchaseObjectDto> $purchaseObjects Объекты закупки
     */
    public function __construct(
        /** Тип закупки */
        public ?string $type = null,
        /** Номер закупки */
        public ?string $number = null,
        /** Неформализованное описание способа отбора */
        public ?string $selectionTypeDescription = null,
        /** Неформализованное описание статуса закупки */
        public ?string $stateDescription = null,
        /** Описание предмета закупки */
        public ?string $topicDescription = null,
        /** Дата публикации */
        public ?string $publicationDate = null,
        /** Начальная цена */
        public ?PurchasePriceDto $startPrice = null,
        /** Цена победителя */
        public ?PurchasePriceDto $winnerPrice = null,
        #[ArrayOf(PurchaseCustomerDto::class)]
        public array $customers = [],
        #[ArrayOf(PurchaseParticipantDto::class)]
        public array $participants = [],
        /** Информация о контракте/договоре */
        public ?PurchaseContractInfoDto $contractInfo = null,
        #[ArrayOf(PurchaseObjectDto::class)]
        public array $purchaseObjects = [],
    ) {
    }
}
