<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqForeignAddressDto
{
    public function __construct(
        /** Наименование страны */
        public ?string $countryName = null,
        /** Строка, содержащая адрес */
        public ?string $addressString = null,
    ) {
    }
}
