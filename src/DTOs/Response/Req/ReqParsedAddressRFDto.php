<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqParsedAddressRFDto
{
    public function __construct(
        /** Индекс */
        public ?string $zipCode = null,
        /** Код региона */
        public ?string $regionCode = null,
        /** Регион */
        public ?ReqToponymDto $regionName = null,
        /** Район */
        public ?ReqToponymDto $district = null,
        /** Город */
        public ?ReqToponymDto $city = null,
        /** Населенный пункт */
        public ?ReqToponymDto $settlement = null,
        /** Улица */
        public ?ReqToponymDto $street = null,
        /** Дом */
        public ?ReqToponymDto $house = null,
        /** Корпус */
        public ?ReqToponymDto $bulk = null,
        /** Офис/квартира/комната */
        public ?ReqToponymDto $flat = null,
        /** Код КЛАДР */
        public ?string $kladrCode = null,
        /** Полное значение поля "Дом" из ЕГРЮЛ */
        public ?string $houseRaw = null,
        /** Полное значение поля "Корпус" из ЕГРЮЛ */
        public ?string $bulkRaw = null,
        /** Полное значение поля "Квартира" из ЕГРЮЛ */
        public ?string $flatRaw = null,
        /** Адрес сконвертирован Фокусом из адреса муниципального деления, указанного в выписке ЕГРЮЛ, в административное деление с использованием базы ФИАС ГАР */
        public ?bool $isConverted = null,
        /** Адрес одной строкой в формате административно-территориального деления */
        public ?string $oneLineFormatOfAddress = null,
    ) {
    }
}
