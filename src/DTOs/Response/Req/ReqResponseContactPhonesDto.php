<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseContactPhonesDto
{
    public function __construct(
        /** Количество найденных контактых телефонов */
        public ?int $count = null,
    ) {
    }
}
