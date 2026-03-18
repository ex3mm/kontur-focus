<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsFounderForeignDto
{
    /**
 * @param array<EgrDetailsPledgeInfoDto>|null $pledges
 * @param array<EgrDetailsDetailOfInaccuracyDto>|null $detailsOfInaccuracy
 */
    public function __construct(
        /** Полное наименование юридического лица */
        public ?string $fullName = null,
        /** Страна */
        public ?string $country = null,
        /** Доля */
        public ?EgrDetailsShareDto $share = null,
        #[ArrayOf(EgrDetailsPledgeInfoDto::class)]
        /** @var array<EgrDetailsPledgeInfoDto>|null Сведения об обременении доли участника */
        public ?array $pledges = null,
        /** Дата последнего внесения изменений */
        public ?string $date = null,
        /** Дата первого внесения сведений */
        public ?string $firstDate = null,
        /** В ЕГРЮЛ указан признак недостоверности сведений */
        public ?bool $isInaccuracy = null,
        #[ArrayOf(EgrDetailsDetailOfInaccuracyDto::class)]
        /** @var array<EgrDetailsDetailOfInaccuracyDto>|null Дополнительная информация о признаке недостоверности сведений в ЕГРЮЛ */
        public ?array $detailsOfInaccuracy = null,
        /** Дата указания признака недостоверности сведений. Если у соответствующего объекта в выписке одновременно несколько записей о недостоверности, то указывается меньшая актуальная дата из всех. Все даты записей можно узнать в detailsOfInaccuracy */
        public ?string $inaccuracyDate = null,
        /** Сведения об участниках акционерного общества относятся к сведениям о единственном акционере или лицах, выступающих от его имени. Маркер указывается только для актуальных учредителей */
        public ?bool $isSoleShareholder = null,
    ) {
    }
}
