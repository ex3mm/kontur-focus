<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Fssp;

/**
 * Исполнительное производство.
 */
final readonly class FsspDataDto
{
    public function __construct(
        /** Номер исполнительного производства */
        public ?string $officialNum = null,
        /** Номер сводного исполнительного производства */
        public ?string $officialAggregatedNum = null,
        /** Дата возбуждения исполнительного производства */
        public ?string $startDate = null,
        /** Сумма в рублях */
        public ?float $sum = null,
        /** Предмет исполнительного производства */
        public ?string $topic = null,
        /** Описание исполнительного документа */
        public ?string $executoryDocument = null,
        /** Номер исполнительного документа */
        public ?string $executoryDocumentNumber = null,
        /** Дата исполнительного документа */
        public ?string $executoryDocumentDate = null,
        /** Наименование должника */
        public ?string $debtorName = null,
        /** Адрес должника */
        public ?string $debtorAddress = null,
        /** Производство возвращено взыскателю */
        public ?bool $returnedToClaimer = null,
        /** Производство окончено в связи с банкротством */
        public ?bool $cancelledBecauseOfBancruptcy = null,
        /** Производство окончено в связи с ликвидацией */
        public ?bool $cancelledBecauseOfDissolvement = null,
        /** Дата окончания исполнительного производства */
        public ?string $cancelDate = null,
        /** Отдел судебных приставов */
        public ?string $bailiffDepartment = null,
        /** Адрес отдела судебных приставов */
        public ?string $bailiffDepartmentAddress = null,
    ) {
    }
}
