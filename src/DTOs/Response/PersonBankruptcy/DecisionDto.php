<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class DecisionDto
{
    public function __construct(
        /** Идентификатор типа судебного решения */
        public ?int $typeId = null,
        /** Наименование типа судебного решения */
        public ?string $typeName = null,
        /** Основание прекращения производства по делу */
        public ?string $terminationType = null,
        /** Дата судебного решения */
        public ?string $date = null,
    ) {
    }
}
