<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqDetailOfInaccuracyDto
{
    public function __construct(
        /** Признак недостоверности внесен на основании заявления самого лица. Маркер может относиться только к физлицу, например - руководителю или участнику/учредителю. Маркер несовместим с isResultOfInspection, isCourtDecision и isUnknown */
        public ?bool $isPersonalStatement = null,
        /** Признак недостоверности внесен по результатам проверки сведений в ЕГРЮЛ. Маркер несовместим с isPersonalStatement, isCourtDecision и isUnknown */
        public ?bool $isResultOfInspection = null,
        /** Признак недостоверности внесен на основании решения суда. Детали в объекте courtDecisionDetails. Маркер несовместим с isPersonalStatement, isResultOfInspection и isUnknown */
        public ?bool $isCourtDecision = null,
        /** Неизвестно о причинах внесения недостоверности сведений из выписки ЕГРЮЛ. Маркер несовместим с isPersonalStatement, isResultOfInspection и isCourtDecision */
        public ?bool $isUnknown = null,
        /** Подробности о решении суда */
        public ?ReqCourtDecisionDetailsDto $courtDecisionDetails = null,
        /** Дата записи в ЕГРЮЛ */
        public ?string $dateOfDetails = null,
        /** ГРН записи о недостоверности сведений в ЕГРЮЛ */
        public ?string $grn = null,
    ) {
    }
}
