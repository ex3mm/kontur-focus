<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

/**
 * Участник закупки.
 */
final readonly class PurchaseParticipantDto
{
    public function __construct(
        /** ИНН */
        public ?string $inn = null,
        /** КПП */
        public ?string $kpp = null,
        /** Наименование */
        public ?string $name = null,
        /** Признак победителя */
        public ?bool $isWinner = null,
        /** Заключен контракт/договор */
        public ?bool $hasContract = null,
        /** Заявка отклонена */
        public ?bool $isNotAdmitted = null,
    ) {
    }
}
