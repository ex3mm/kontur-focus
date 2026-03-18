<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseBriefReportDto
{
    public function __construct(
        /** Сводная информация из экспресс-отчета */
        public ?ReqResponseBriefReportSummaryDto $summary = null,
    ) {
    }
}
