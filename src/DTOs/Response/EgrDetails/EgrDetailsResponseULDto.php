<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseULDto
{
    /**
 * @param array<EgrDetailsShareholdersDto>|null $shareholdersManual
 * @param array<EgrDetailsFounderFLDto>|null $foundersFL
 * @param array<EgrDetailsFounderULDto>|null $foundersUL
 * @param array<EgrDetailsFounderForeignDto>|null $foundersForeign
 * @param array<EgrDetailsResponseULPredecessorsItemDto>|null $predecessors
 * @param array<EgrDetailsResponseULSuccessorsItemDto>|null $successors
 * @param array<EgrDetailsEgrRecordDto>|null $egrRecords
 */
    public function __construct(
        /** ОКПО */
        public ?string $okpo = null,
        /** Регистрационный номер ПФР / Единый регистрационный номер страхователя СФР. При отсутствии единого регистрационного номера страхователя в ЕГРЮЛ – выгружается код ПФР */
        public ?string $pfrRegNumber = null,
        /** Регистрационный номер ФСС / Единый регистрационный номер страхователя СФР. При отсутствии единого регистрационного номера страхователя в ЕГРЮЛ – выгружается код ФСС */
        public ?string $fssRegNumber = null,
        /** Регистрационный номер ФОМС */
        public ?string $fomsRegNumber = null,
        /** Виды деятельности */
        public ?EgrDetailsResponseULActivitiesDto $activities = null,
        /** Сведения о регистрации */
        public ?EgrDetailsResponseULRegInfoDto $regInfo = null,
        /** Сведения о постановке на учет в налоговом органе */
        public ?EgrDetailsNalogRegBodyDto $nalogRegBody = null,
        /** Сведения регистрирующего органа */
        public ?EgrDetailsNalogRegBodyDto $regBody = null,
        /** Сведения о держателе реестра акционеров акционерного общества */
        public ?EgrDetailsRegistrarOfShareholdersDto $registrarOfShareholders = null,
        /** Акционеры, являющиеся аффилированными лицами */
        public ?EgrDetailsShareholdersDto $shareholders = null,
        #[ArrayOf(EgrDetailsShareholdersDto::class)]
        /** @var array<EgrDetailsShareholdersDto>|null Акционеры, добавленные из других источников */
        public ?array $shareholdersManual = null,
        /** Уставный капитал */
        public ?EgrDetailsStatedCapitalDto $statedCapital = null,
        #[ArrayOf(EgrDetailsFounderFLDto::class)]
        /** @var array<EgrDetailsFounderFLDto>|null Учредители - физлица */
        public ?array $foundersFL = null,
        #[ArrayOf(EgrDetailsFounderULDto::class)]
        /** @var array<EgrDetailsFounderULDto>|null Учредители - юрлица */
        public ?array $foundersUL = null,
        #[ArrayOf(EgrDetailsFounderForeignDto::class)]
        /** @var array<EgrDetailsFounderForeignDto>|null Учредители - иностранные компании */
        public ?array $foundersForeign = null,
        #[ArrayOf(EgrDetailsResponseULPredecessorsItemDto::class)]
        /** @var array<EgrDetailsResponseULPredecessorsItemDto>|null Предшественники */
        public ?array $predecessors = null,
        #[ArrayOf(EgrDetailsResponseULSuccessorsItemDto::class)]
        /** @var array<EgrDetailsResponseULSuccessorsItemDto>|null Преемники */
        public ?array $successors = null,
        #[ArrayOf(EgrDetailsEgrRecordDto::class)]
        /** @var array<EgrDetailsEgrRecordDto>|null Записи в ЕГРЮЛ */
        public ?array $egrRecords = null,
        /** Исторические значения реквизитов */
        public ?EgrDetailsResponseULHistoryDto $history = null,
    ) {
    }
}
