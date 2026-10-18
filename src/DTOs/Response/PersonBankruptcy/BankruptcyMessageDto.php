<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

use Ex3mm\KonturFocus\DTOs\Attributes\MapFrom;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class BankruptcyMessageDto
{
    public function __construct(
        /** Номер сообщения */
        public ?string $id = null,
        /** Идентификатор сообщения из ЕФРСБ */
        #[MapFrom('messageID')]
        public ?string $messageId = null,
        /** Тип сообщения */
        public ?string $messageType = null,
        /** Дата и время публикации */
        public ?string $pubDate = null,
        /** Судебное решение */
        public ?DecisionDto $decision = null,
        /** Аннулирование */
        #[MapFrom('annulation')]
        public ?AnnulmentDto $annulment = null,
    ) {
    }
}
