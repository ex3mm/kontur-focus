<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseIPStatusDto
{
    public function __construct(
        /** Неформализованное описание статуса */
        public ?string $statusString = null,
        /** В стадии ликвидации (либо планируется исключение из ЕГРИП) */
        public ?bool $dissolving = null,
        /** Недействующий */
        public ?bool $dissolved = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
