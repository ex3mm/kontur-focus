<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

use Ex3mm\KonturFocus\DTOs\Attributes\MapFrom;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class BankruptcyStageDto
{
    public function __construct(
        /** Номер сообщения */
        public ?string $id = null,
        /** Идентификатор сообщения из ЕФРСБ */
        #[MapFrom('messageID')]
        public ?string $messageId = null,
        /** Стадия банкротства или статус внесудебного банкротства */
        public ?string $stage = null,
        /** Дата и время публикации сообщения */
        public ?string $pubDate = null,
        /** Дата судебного решения */
        public ?string $decisionDate = null,
    ) {
    }
}
