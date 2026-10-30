<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Ответ endpoint /api3/purchasesOfParticipant.
 */
final readonly class PurchasesOfParticipantResponseDto
{
    /**
     * @param array<PurchaseDto> $purchasesOfParticipant Закупки участника
     */
    public function __construct(
        /** ИНН организации */
        public ?string $inn = null,
        /** ОГРН организации */
        public ?string $ogrn = null,
        /** Ссылка на карточку организации в Контур.Фокусе */
        public ?string $focusHref = null,
        #[ArrayOf(PurchaseDto::class)]
        public array $purchasesOfParticipant = [],
    ) {
    }
}
