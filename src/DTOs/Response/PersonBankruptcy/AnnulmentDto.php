<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class AnnulmentDto
{
    public function __construct(
        /** Номер аннулируемого сообщения */
        public ?string $messageId = null,
        /** Причина аннулирования */
        public ?string $reason = null,
    ) {
    }
}
