<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ArbitrationManagerDto
{
    public function __construct(
        /** ФИО */
        public ?string $fio = null,
        /** ИНН */
        public ?string $inn = null,
        /** ОГРН */
        public ?string $ogrn = null,
    ) {
    }
}
