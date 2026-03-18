<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqLegalAddressDto
{
    /**
 * @param array<ReqDetailOfInaccuracyDto>|null $detailsOfInaccuracy
 */
    public function __construct(
        /** Адрес в формате административно-территориального деления (КЛАДР) */
        public ?ReqParsedAddressRFDto $parsedAddressRF = null,
        /** Адрес в формате муниципального деления (ФИАС ГАР) */
        public ?ReqParsedAddressRFFiasDto $parsedAddressRFFias = null,
        /** Дата */
        public ?string $date = null,
        /** Дата первого внесения сведений */
        public ?string $firstDate = null,
        /** В ЕГРЮЛ указан признак недостоверности сведений */
        public ?bool $isInaccuracy = null,
        #[ArrayOf(ReqDetailOfInaccuracyDto::class)]
        /** @var array<ReqDetailOfInaccuracyDto>|null Дополнительная информация о признаке недостоверности сведений в ЕГРЮЛ */
        public ?array $detailsOfInaccuracy = null,
        /** Дата указания признака недостоверности сведений. Если у соответствующего объекта в выписке одновременно несколько записей о недостоверности, то указывается меньшая актуальная дата из всех. Все даты записей можно узнать в detailsOfInaccuracy */
        public ?string $inaccuracyDate = null,
    ) {
    }
}
