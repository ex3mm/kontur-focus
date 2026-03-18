<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\BankruptcyAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/bankruptcyAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class BankruptcyAnalyticsResponseBankruptcyAnalyticsDataDto
{
    public function __construct(
        /** Дела в качестве ответчика. Количество арбитражных дел, которые связаны с проведением процедуры банкротства */
        public ?BankruptcyAnalyticsMarkerIntegerDto $defendantAllCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, которые связаны с проведением процедуры банкротства (в рублях) */
        public ?BankruptcyAnalyticsMarkerNumberDto $defendantAllSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел в процессе рассмотрения, которые связаны с проведением процедуры банкротства за 6 месяцев */
        public ?BankruptcyAnalyticsMarkerIntegerDto $defendantInProgressCount6Month = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел в процессе рассмотрения, которые связаны с проведением процедуры банкротства за 6 месяцев (в рублях) */
        public ?BankruptcyAnalyticsMarkerNumberDto $defendantInProgressSum6Month = null,
        /** Дела в качестве ответчика. Количество арбитражных дел в процессе рассмотрения, которые связаны с проведением процедуры банкротства */
        public ?BankruptcyAnalyticsMarkerIntegerDto $defendantInProgressCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел в процессе рассмотрения, которые связаны с проведением процедуры банкротства (в рублях) */
        public ?BankruptcyAnalyticsMarkerNumberDto $defendantInProgressSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, исход которых определить не удалось, которые связаны с проведением процедуры банкротства за 6 месяцев */
        public ?BankruptcyAnalyticsMarkerIntegerDto $defendantUnknownCount6Month = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, исход которых определить не удалось, которые связаны с проведением процедуры банкротства за 6 месяцев (в рублях) */
        public ?BankruptcyAnalyticsMarkerNumberDto $defendantUnknownSum6Month = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, исход которых определить не удалось, которые связаны с проведением процедуры банкротства */
        public ?BankruptcyAnalyticsMarkerIntegerDto $defendantUnknownCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, исход которых определить не удалось, которые связаны с проведением процедуры банкротства (в рублях) */
        public ?BankruptcyAnalyticsMarkerNumberDto $defendantUnknownSum = null,
        /** Обнаружены арбитражные дела о банкротстве за последние 3 месяца */
        public ?BankruptcyAnalyticsMarkerBooleanDto $arbitrationCase3Month = null,
        /** Обнаружены сообщения о банкротстве за последние 12 месяцев */
        public ?BankruptcyAnalyticsMarkerBooleanDto $message12Month = null,
        /** Текущая стадия банкротства по решению суда от currentStageDate (вычисляется на основе сообщений о банкротстве) */
        public ?BankruptcyAnalyticsMarkerStringDto $currentStage = null,
        /** Дата решения суда о введении текущей стадии банкротства */
        public ?BankruptcyAnalyticsMarkerDateDto $currentStageDate = null,
        /** Обнаружены сообщения о намерении обратиться в суд с заявлением о банкротстве за последний месяц */
        public ?BankruptcyAnalyticsMarkerBooleanDto $intentionMonth = null,
        /** Организация прекратила свою деятельность в результате процедуры банкротства */
        public ?BankruptcyAnalyticsMarkerBooleanDto $signEnd = null,
        /** Наличие за последние 12 месяцев сообщений о банкротстве физлица, являющегося руководителем (лицом с правом подписи без доверенности). Необходимо изучить сообщения */
        public ?BankruptcyAnalyticsMarkerBooleanDto $messageManager12Month = null,
        /** Наличие за последние 12 месяцев сообщений о банкротстве физлица, являющегося учредителем, либо индивидуальным предпринимателем. Необходимо изучить сообщения */
        public ?BankruptcyAnalyticsMarkerBooleanDto $messageFounder12Month = null,
    ) {
    }
}
