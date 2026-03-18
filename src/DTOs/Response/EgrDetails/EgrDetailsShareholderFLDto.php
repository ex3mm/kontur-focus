<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsShareholderFLDto
{
    public function __construct(
        /** ФИО */
        public ?string $fio = null,
        /** Местожительство физлица */
        public ?string $address = null,
        /** Доля обыкновенных акций в процентах */
        public ?float $votingSharesPercent = null,
        /** Доля участия в уставном капитале в процентах */
        public ?float $capitalSharesPercent = null,
        /** Дата последнего изменения в долях */
        public ?string $date = null,
    ) {
    }
}
