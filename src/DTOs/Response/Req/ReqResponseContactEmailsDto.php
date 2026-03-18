<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseContactEmailsDto
{
    public function __construct(
        /** Количество найденных адресов электронной почты */
        public ?int $count = null,
    ) {
    }
}
