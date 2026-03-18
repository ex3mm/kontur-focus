<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseIPDto
{
    /**
 * @param array<EgrDetailsEgrRecordDto>|null $egrRecords
 */
    public function __construct(
        /** ОКПО */
        public ?string $okpo = null,
        /** Регистрационный номер ПФР / Единый регистрационный номер страхователя СФР. При отсутствии единого регистрационного номера страхователя в ЕГРИП – выгружается код ПФР */
        public ?string $pfrRegNumber = null,
        /** Регистрационный номер ФСС / Единый регистрационный номер страхователя СФР. При отсутствии единого регистрационного номера страхователя в ЕГРИП – выгружается код ФСС */
        public ?string $fssRegNumber = null,
        /** Регистрационный номер ФОМС */
        public ?string $fomsRegNumber = null,
        /** ОКАТО (может отсутствовать или устареть) */
        public ?string $okato = null,
        /** Информация о местонахождении ИП в формате административно-территориального деления (КЛАДР). Может отсутствовать или устареть */
        public ?EgrDetailsResponseIPShortenedAddressDto $shortenedAddress = null,
        /** Виды деятельности */
        public ?EgrDetailsResponseIPActivitiesDto $activities = null,
        /** Сведения о регистрации */
        public ?EgrDetailsResponseIPRegInfoDto $regInfo = null,
        /** Сведения о постановке на учет в налоговом органе */
        public ?EgrDetailsNalogRegBodyDto $nalogRegBody = null,
        /** Сведения регистрирующего органа */
        public ?EgrDetailsNalogRegBodyDto $regBody = null,
        #[ArrayOf(EgrDetailsEgrRecordDto::class)]
        /** @var array<EgrDetailsEgrRecordDto>|null Записи в ЕГРИП */
        public ?array $egrRecords = null,
    ) {
    }
}
