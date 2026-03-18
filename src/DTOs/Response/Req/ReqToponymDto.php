<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqToponymDto
{
    public function __construct(
        /** Краткое наименование вида топонима */
        public ?string $topoShortName = null,
        /** Полное наименование вида топонима */
        public ?string $topoFullName = null,
        /** Значение топонима */
        public ?string $topoValue = null,
    ) {
    }
}
