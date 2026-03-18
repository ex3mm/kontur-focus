<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqLegalNameDto
{
    public function __construct(
        /** Краткое наименование организации */
        public ?string $short = null,
        /** Полное наименование организации */
        public ?string $full = null,
        /** Полное наименование, приведенное к нижнему регистру с сокращением аббревиатур */
        public ?string $readable = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
