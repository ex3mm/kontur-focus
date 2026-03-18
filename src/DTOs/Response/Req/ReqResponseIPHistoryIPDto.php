<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseIPHistoryIPDto
{
    /**
 * @param array<ReqResponseIPHistoryIPFiosItemDto>|null $fios
 * @param array<ReqResponseIPHistoryIPStructuredFiosItemDto>|null $structuredFios
 */
    public function __construct(
        #[ArrayOf(ReqResponseIPHistoryIPFiosItemDto::class)]
        /** @var array<ReqResponseIPHistoryIPFiosItemDto>|null ФИО из истории */
        public ?array $fios = null,
        #[ArrayOf(ReqResponseIPHistoryIPStructuredFiosItemDto::class)]
        /** @var array<ReqResponseIPHistoryIPStructuredFiosItemDto>|null Структурированные ФИО из истории */
        public ?array $structuredFios = null,
    ) {
    }
}
