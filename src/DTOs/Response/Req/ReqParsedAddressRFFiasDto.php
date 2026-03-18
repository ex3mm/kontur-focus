<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqParsedAddressRFFiasDto
{
    /**
 * @param array<ReqToponymDto>|null $buildings
 */
    public function __construct(
        /** Уникальный идентификатор адресного объекта в ГАР */
        public ?float $fiasId = null,
        /** Уникальный номер адреса объекта адресации в ГАР (GUID) */
        public ?string $fiasGUID = null,
        /** Индекс */
        public ?string $zipCode = null,
        /** Код региона */
        public ?string $regionCode = null,
        /** Регион */
        public ?ReqToponymDto $region = null,
        /** Муниципальный район */
        public ?ReqToponymDto $municipalDistrict = null,
        /** Городское или сельское поселение в составе муниципального района или внутригородской район городского округа */
        public ?ReqToponymDto $urbanSettlement = null,
        /** Город */
        public ?ReqToponymDto $city = null,
        /** Населенный пункт */
        public ?ReqToponymDto $settlement = null,
        /** Элемент планировочной структуры */
        public ?ReqToponymDto $planningStructure = null,
        /** Улица */
        public ?ReqToponymDto $street = null,
        #[ArrayOf(ReqToponymDto::class)]
        /** @var array<ReqToponymDto>|null Дом,Строение,Корпус,Литера */
        public ?array $buildings = null,
        /** Офис/квартира/комната */
        public ?ReqToponymDto $flat = null,
        /** Помещение в помещении */
        public ?ReqToponymDto $room = null,
        /** Адрес сконвертирован Фокусом из адреса административного деления, указанного в выписке ЕГРЮЛ, в муниципальное деление с использованием базы ФИАС ГАР */
        public ?bool $isConverted = null,
        /** Адрес одной строкой в формате муниципального деления */
        public ?string $oneLineFormatOfAddressFias = null,
    ) {
    }
}
