<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsShareholdersDto
{
    /**
 * @param array<EgrDetailsShareholderFLDto>|null $shareholdersFL
 * @param array<EgrDetailsShareholderULDto>|null $shareholdersUL
 * @param array<EgrDetailsShareholderOtherDto>|null $shareholdersOther
 */
    public function __construct(
        /** Тип источника */
        public ?string $source = null,
        /** Дата последнего внесения изменений в список акционеров */
        public ?string $date = null,
        #[ArrayOf(EgrDetailsShareholderFLDto::class)]
        /** @var array<EgrDetailsShareholderFLDto>|null Акционеры - физлица */
        public ?array $shareholdersFL = null,
        #[ArrayOf(EgrDetailsShareholderULDto::class)]
        /** @var array<EgrDetailsShareholderULDto>|null Акционеры - юрлица */
        public ?array $shareholdersUL = null,
        #[ArrayOf(EgrDetailsShareholderOtherDto::class)]
        /** @var array<EgrDetailsShareholderOtherDto>|null Акционеры - без категории. Это могут быть юрлица, физлица и иностранные лица */
        public ?array $shareholdersOther = null,
    ) {
    }
}
