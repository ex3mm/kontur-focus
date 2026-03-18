<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseIPShortenedAddressDto
{
    public function __construct(
        /** Код региона */
        public ?string $regionCode = null,
        /** Регион */
        public ?EgrDetailsToponymDto $regionName = null,
        /** Район */
        public ?EgrDetailsToponymDto $district = null,
        /** Город */
        public ?EgrDetailsToponymDto $city = null,
        /** Населенный пункт */
        public ?EgrDetailsToponymDto $settlement = null,
        /** Адрес местонахождения ИП одной строкой в формате административно-территориального деления */
        public ?string $oneLineFormatOfAddress = null,
    ) {
    }
}
