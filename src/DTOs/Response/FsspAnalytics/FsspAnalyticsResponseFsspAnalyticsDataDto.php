<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FsspAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/fsspAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FsspAnalyticsResponseFsspAnalyticsDataDto
{
    public function __construct(
        /** Количество найденных исполнительных производств в отношении организаций со схожими реквизитами (за 12 месяцев) */
        public ?FsspAnalyticsMarkerIntegerDto $count12Month = null,
        /** Сумма (в рублях) найденных исполнительных производств в отношении организаций со схожими реквизитами (за 12 месяцев) */
        public ?FsspAnalyticsMarkerNumberDto $sum12Month = null,
        /** Количество найденных исполнительных производств в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $count = null,
        /** Сумма (в рублях) найденных исполнительных производств в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $sum = null,
        /** Количество найденных исполнительных производств, предметом которых являются страховые взносы, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $insuranceCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых являются страховые взносы, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $insuranceSum = null,
        /** Количество найденных исполнительных производств, предметом которых являются налоги и сборы, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $taxCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых являются налоги и сборы, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $taxSum = null,
        /** Количество найденных исполнительных производств, предметом которых являются коммунальные платежи, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $communalCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых являются коммунальные платежи, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $communalSum = null,
        /** Количество найденных исполнительных производств, предметом которых являются штрафы, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $fineCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых являются штрафы, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $fineSum = null,
        /** Количество найденных исполнительных производств, предметом которых является заработная плата, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $salaryCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых является заработная плата, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $salarySum = null,
        /** Количество найденных исполнительных производств, предметом которых являются кредитные платежи, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $creditCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых являются кредитные платежи, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $creditSum = null,
        /** Количество найденных исполнительных производств, предметом которых является взыскание на заложенное имущество, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $propertyCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых является взыскание на заложенное имущество, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $propertySum = null,
        /** Количество найденных исполнительных производств, предметом которых является арест какого-либо имущества, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $arrestCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых является арест какого-либо имущества, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $arrestSum = null,
        /** Количество найденных исполнительных производств, предметом которых является взыскание в пользу физ.лица, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerIntegerDto $fineForPersonCount = null,
        /** Сумма (в рублях) найденных исполнительных производств, предметом которых является взыскание в пользу физ.лица, в отношении организаций со схожими реквизитами */
        public ?FsspAnalyticsMarkerNumberDto $fineForPersonSum = null,
    ) {
    }
}
