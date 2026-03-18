<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseIPDto
{
    public function __construct(
        /** ФИО */
        public ?string $fio = null,
        /** Дата ФИО */
        public ?string $fioDate = null,
        /** Структурированное ФИО */
        public ?ReqStructuredFioDto $structuredFio = null,
        /** ОКПО */
        public ?string $okpo = null,
        /** ОКАТО */
        public ?string $okato = null,
        /** ОКФС */
        public ?string $okfs = null,
        /** ОКОГУ */
        public ?string $okogu = null,
        /** Код ОКОПФ */
        public ?string $okopf = null,
        /** Наименование организационно-правовой формы */
        public ?string $opf = null,
        /** ОКТМО */
        public ?string $oktmo = null,
        /** Дата образования */
        public ?string $registrationDate = null,
        /** Дата прекращения деятельности */
        public ?string $dissolutionDate = null,
        /** Статус ИП */
        public ?ReqResponseIPStatusDto $status = null,
        /** Исторические значения реквизитов */
        public ?ReqResponseIPHistoryIPDto $historyIP = null,
    ) {
    }
}
