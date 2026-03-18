<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqStructuredFioDto
{
    public function __construct(
        /** Имя */
        public ?string $firstName = null,
        /** Фамилия */
        public ?string $lastName = null,
        /** Отчество */
        public ?string $middleName = null,
    ) {
    }
}
