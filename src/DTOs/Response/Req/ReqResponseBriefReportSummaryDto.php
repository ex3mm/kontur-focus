<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseBriefReportSummaryDto
{
    public function __construct(
        /** Наличие информации, помеченной зеленым цветом */
        public ?bool $greenStatements = null,
        /** Наличие информации, помеченной желтым цветом */
        public ?bool $yellowStatements = null,
        /** Наличие информации, помеченной красным цветом */
        public ?bool $redStatements = null,
    ) {
    }
}
