<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/purchasesAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class PurchasesAnalyticsResponsePurchasesAnalyticsDataDto
{
    public function __construct(
        /** Организация найдена в реестре недобросовестных поставщиков */
        public ?PurchasesAnalyticsMarkerBooleanDto $inRnp = null,
        /** Количество заключенных госконтрактов (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) участником, за 12 месяцев */
        public ?PurchasesAnalyticsMarkerIntegerDto $participantCount12Month = null,
        /** Сумма по заключенным госконтрактам (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) участником, за 12 месяцев (в рублях) */
        public ?PurchasesAnalyticsMarkerNumberDto $participantSum12Month = null,
        /** Количество заключенных госконтрактов (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) участником */
        public ?PurchasesAnalyticsMarkerIntegerDto $participantCount = null,
        /** Сумма по заключенным госконтрактам (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) участником (в рублях) */
        public ?PurchasesAnalyticsMarkerNumberDto $participantSum = null,
        /** Количество заключенных госконтрактов (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) заказчиком, за 12 месяцев */
        public ?PurchasesAnalyticsMarkerIntegerDto $customerCount12Month = null,
        /** Сумма по заключенным госконтрактам (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) заказчиком, за 12 месяцев (в рублях) */
        public ?PurchasesAnalyticsMarkerNumberDto $customerSum12Month = null,
        /** Количество заключенных госконтрактов (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) заказчиком */
        public ?PurchasesAnalyticsMarkerIntegerDto $customerCount = null,
        /** Сумма по заключенным госконтрактам (44ФЗ, 223ФЗ, 615ПП), в которых организация является (или являлась) заказчиком (в рублях) */
        public ?PurchasesAnalyticsMarkerNumberDto $customerSum = null,
    ) {
    }
}
