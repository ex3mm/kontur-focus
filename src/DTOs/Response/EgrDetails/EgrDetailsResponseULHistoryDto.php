<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseULHistoryDto
{
    /**
 * @param array<EgrDetailsShareholdersDto>|null $shareholdersManual
 * @param array<EgrDetailsStatedCapitalDto>|null $statedCapitals
 * @param array<EgrDetailsFounderFLDto>|null $foundersFL
 * @param array<EgrDetailsFounderULDto>|null $foundersUL
 * @param array<EgrDetailsFounderForeignDto>|null $foundersForeign
 */
    public function __construct(
        /** Бывшие акционеры или акционеры, переставшие относиться к группе аффилированных лиц */
        public ?EgrDetailsShareholdersDto $shareholders = null,
        #[ArrayOf(EgrDetailsShareholdersDto::class)]
        /** @var array<EgrDetailsShareholdersDto>|null Бывшие акционеры или акционеры, переставшие публиковаться на сайте источника */
        public ?array $shareholdersManual = null,
        #[ArrayOf(EgrDetailsStatedCapitalDto::class)]
        /** @var array<EgrDetailsStatedCapitalDto>|null Уставный капитал (история изменений) */
        public ?array $statedCapitals = null,
        #[ArrayOf(EgrDetailsFounderFLDto::class)]
        /** @var array<EgrDetailsFounderFLDto>|null Учредители - физлица (история изменений) */
        public ?array $foundersFL = null,
        #[ArrayOf(EgrDetailsFounderULDto::class)]
        /** @var array<EgrDetailsFounderULDto>|null Учредители - юрлица (история изменений) */
        public ?array $foundersUL = null,
        #[ArrayOf(EgrDetailsFounderForeignDto::class)]
        /** @var array<EgrDetailsFounderForeignDto>|null Учредители - иностранные компании (история изменений) */
        public ?array $foundersForeign = null,
    ) {
    }
}
