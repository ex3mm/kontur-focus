<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

/**
 * Статус организации или ИП.
 */
final readonly class CompanyAffiliationStatusDto
{
    public function __construct(
        /** Неформализованное описание статуса */
        public ?string $statusString = null,
        /** Код статуса по справочнику СЮЛСТ */
        public ?string $code = null,
        /** Организация в процессе реорганизации */
        public ?bool $reorganizing = null,
        /** Организация в процессе банкротства */
        public ?bool $bankrupting = null,
        /** Организация в стадии ликвидации */
        public ?bool $dissolving = null,
        /** Организация недействующая */
        public ?bool $dissolved = null,
        /** Дата внесения записи в ЕГРЮЛ */
        public ?string $date = null,
    ) {
    }
}
