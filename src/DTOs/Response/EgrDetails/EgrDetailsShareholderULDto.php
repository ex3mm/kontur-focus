<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsShareholderULDto
{
    public function __construct(
        /** ОГРН */
        public ?string $ogrn = null,
        /** ИНН */
        public ?string $inn = null,
        /** Полное наименование юридического лица */
        public ?string $fullName = null,
        /** Местонахождение юрлица */
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
