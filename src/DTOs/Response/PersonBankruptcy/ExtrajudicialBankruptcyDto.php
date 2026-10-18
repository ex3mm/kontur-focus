<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ExtrajudicialBankruptcyDto
{
    /**
     * @param array<string> $reasonsForReturn
     */
    public function __construct(
        /** Статус внесудебного банкротства */
        public ?string $status = null,
        /** Дата начала процедуры */
        public ?string $startDate = null,
        /** Дата завершения, прекращения или отмены процедуры */
        public ?string $endDate = null,
        /** Причина прекращения процедуры */
        public ?string $reasonForTermination = null,
        /** Причина возврата заявления */
        public ?string $reasonForReturn = null,
        /** Причины возврата заявления */
        #[ArrayOf('string')]
        public array $reasonsForReturn = [],
    ) {
    }
}
