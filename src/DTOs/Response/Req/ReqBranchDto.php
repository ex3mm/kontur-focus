<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqBranchDto
{
    public function __construct(
        /** Наименование филиала или представительства */
        public ?string $name = null,
        /** КПП */
        public ?string $kpp = null,
        /** Адрес в РФ в формате административно-территориального деления (КЛАДР) */
        public ?ReqParsedAddressRFDto $parsedAddressRF = null,
        /** Адрес в РФ в формате муниципального деления (ФИАС ГАР) */
        public ?ReqParsedAddressRFFiasDto $parsedAddressRFFias = null,
        /** Адрес вне РФ */
        public ?ReqForeignAddressDto $foreignAddress = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
