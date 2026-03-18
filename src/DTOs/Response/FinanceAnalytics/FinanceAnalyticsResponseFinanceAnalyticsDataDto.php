<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FinanceAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/financeAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FinanceAnalyticsResponseFinanceAnalyticsDataDto
{
    public function __construct(
        /** Год, за который доступна последняя бухгалтерская отчетность по организации */
        public ?FinanceAnalyticsMarkerIntegerDto $lastBuhYear = null,
        /** Есть бухгалтерская отчетность за последний отчетный год (на момент, когда такая отчетность становится доступна в Контур.Фокусе) */
        public ?FinanceAnalyticsMarkerBooleanDto $lastBuh = null,
        /** Выручка на начало отчетного периода (за последний отчетный год, в рублях) */
        public ?FinanceAnalyticsMarkerNumberDto $incomeStart = null,
        /** Выручка на конец отчетного периода (за последний отчетный год, в рублях) */
        public ?FinanceAnalyticsMarkerNumberDto $incomeEnd = null,
        /** Баланс на начало отчетного периода (за последний отчетный год, в рублях) */
        public ?FinanceAnalyticsMarkerNumberDto $balanceStart = null,
        /** Баланс на конец отчетного периода (за последний отчетный год, в рублях) */
        public ?FinanceAnalyticsMarkerNumberDto $balanceEnd = null,
        /** Чистая прибыль на начало отчетного периода (за последний отчетный год, в рублях) */
        public ?FinanceAnalyticsMarkerNumberDto $profitStart = null,
        /** Чистая прибыль на конец отчетного периода (за последний отчетный год, в рублях) */
        public ?FinanceAnalyticsMarkerNumberDto $profitEnd = null,
        /** Общая сумма уплаченных налогов и сборов на taxSumDate (ФНС) */
        public ?FinanceAnalyticsMarkerNumberDto $taxSum = null,
        /** Дата состояния сведений о сумме уплаченных налогов и сборов (ФНС) */
        public ?FinanceAnalyticsMarkerDateDto $taxSumDate = null,
        /** Сумма доходов по данным бухгалтерской отчетности на incomeSumDate (ФНС) */
        public ?FinanceAnalyticsMarkerNumberDto $incomeSum = null,
        /** Дата состояния сведений о сумме доходов по данным бухгалтерской отчетности (ФНС) */
        public ?FinanceAnalyticsMarkerDateDto $incomeSumDate = null,
        /** Сумма расходов по данным бухгалтерской отчетности на expenseSumDate (ФНС) */
        public ?FinanceAnalyticsMarkerNumberDto $expenseSum = null,
        /** Дата состояния сведений о сумме расходов по данным бухгалтерской отчетности (ФНС) */
        public ?FinanceAnalyticsMarkerDateDto $expenseSumDate = null,
        /** Общая сумма задолженности по налогам на debtSumDate (ФНС) */
        public ?FinanceAnalyticsMarkerNumberDto $debtSum = null,
        /** Дата состояния сведений о сумме задолженности по налогам (ФНС) */
        public ?FinanceAnalyticsMarkerDateDto $debtSumDate = null,
        /** Общая сумма штрафов за налоговые правонарушения на fineSumDate (ФНС) */
        public ?FinanceAnalyticsMarkerNumberDto $fineSum = null,
        /** Дата состояния сведений о сумме штрафов за налоговые правонарушения (ФНС) */
        public ?FinanceAnalyticsMarkerDateDto $fineSumDate = null,
        /** Год, за который доступен последний финансовый анализ и экспертный рейтинг отчётности, указанный в маркере exRating. Может не совпадать с годом по бух. отчетности */
        public ?FinanceAnalyticsMarkerIntegerDto $exRatingYear = null,
        /** Экспертный рейтинг отчётности, вычисляемый по эвристической методике, за год, указанный в маркере exRatingYear */
        public ?FinanceAnalyticsMarkerStringDto $exRating = null,
    ) {
    }
}
