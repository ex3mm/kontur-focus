<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CourtAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/courtAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class CourtAnalyticsResponseCourtAnalyticsDataDto
{
    public function __construct(
        /** Дела в качестве ответчика. Количество арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantAllCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantAllSum12Month = null,
        /** Дела в качестве ответчика. Количество арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantAllCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantAllSum3Year = null,
        /** Дела в качестве истца. Количество арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerAllCount12Month = null,
        /** Дела в качестве истца. Исковая сумма арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerAllSum12Month = null,
        /** Дела в качестве истца. Количество арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerAllCount3Year = null,
        /** Дела в качестве истца. Исковая сумма арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerAllSum3Year = null,
        /** Дела в качестве ответчика. Количество проигранных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantLostCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма проигранных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantLostSum12Month = null,
        /** Дела в качестве ответчика. Количество проигранных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantLostCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма проигранных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantLostSum3Year = null,
        /** Дела в качестве истца. Количество проигранных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerLostCount12Month = null,
        /** Дела в качестве истца. Исковая сумма проигранных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerLostSum12Month = null,
        /** Дела в качестве истца. Количество проигранных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerLostCount3Year = null,
        /** Дела в качестве истца. Исковая сумма проигранных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerLostSum3Year = null,
        /** Дела в качестве ответчика. Количество частично проигранных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantPartialLostCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма частично проигранных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantPartialLostSum12Month = null,
        /** Дела в качестве ответчика. Количество частично проигранных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantPartialLostCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма частично проигранных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantPartialLostSum3Year = null,
        /** Дела в качестве истца. Количество частично проигранных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerPartialLostCount12Month = null,
        /** Дела в качестве истца. Исковая сумма частично проигранных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerPartialLostSum12Month = null,
        /** Дела в качестве истца. Количество частично проигранных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerPartialLostCount3Year = null,
        /** Дела в качестве истца. Исковая сумма частично проигранных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerPartialLostSum3Year = null,
        /** Дела в качестве ответчика. Количество выигранных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantWinCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма выигранных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantWinSum12Month = null,
        /** Дела в качестве ответчика. Количество выигранных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantWinCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма выигранных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantWinSum3Year = null,
        /** Дела в качестве истца. Количество выигранных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerWinCount12Month = null,
        /** Дела в качестве истца. Исковая сумма выигранных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerWinSum12Month = null,
        /** Дела в качестве истца. Количество выигранных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerWinCount3Year = null,
        /** Дела в качестве истца. Исковая сумма выигранных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerWinSum3Year = null,
        /** Дела в качестве ответчика. Количество арбитражных дел в процессе рассмотрения за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantInProgressCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел в процессе рассмотрения за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantInProgressSum12Month = null,
        /** Дела в качестве ответчика. Количество арбитражных дел в процессе рассмотрения за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantInProgressCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел в процессе рассмотрения за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantInProgressSum3Year = null,
        /** Дела в качестве истца. Количество арбитражных дел в процессе рассмотрения за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerInProgressCount12Month = null,
        /** Дела в качестве истца. Исковая сумма арбитражных дел в процессе рассмотрения за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerInProgressSum12Month = null,
        /** Дела в качестве истца. Количество арбитражных дел в процессе рассмотрения за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerInProgressCount3Year = null,
        /** Дела в качестве истца. Исковая сумма арбитражных дел в процессе рассмотрения за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerInProgressSum3Year = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, исход которых определить не удалось, за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantUnknownCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, исход которых определить не удалось, за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantUnknownSum12Month = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, исход которых определить не удалось, за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantUnknownCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, исход которых определить не удалось, за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantUnknownSum3Year = null,
        /** Дела в качестве истца. Количество арбитражных дел, исход которых определить не удалось, за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerUnknownCount12Month = null,
        /** Дела в качестве истца. Исковая сумма арбитражных дел, исход которых определить не удалось, за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerUnknownSum12Month = null,
        /** Дела в качестве истца. Количество арбитражных дел, исход которых определить не удалось, за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerUnknownCount3Year = null,
        /** Дела в качестве истца. Исковая сумма арбитражных дел, исход которых определить не удалось, за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerUnknownSum3Year = null,
        /** Дела в качестве ответчика. Количество прекращенных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantStoppedCount12Month = null,
        /** Дела в качестве ответчика. Исковая сумма прекращенных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantStoppedSum12Month = null,
        /** Дела в качестве ответчика. Количество прекращенных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantStoppedCount3Year = null,
        /** Дела в качестве ответчика. Исковая сумма прекращенных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantStoppedSum3Year = null,
        /** Дела в качестве истца. Количество прекращенных арбитражных дел за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerStoppedCount12Month = null,
        /** Дела в качестве истца. Исковая сумма прекращенных арбитражных дел за 12 месяцев (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerStoppedSum12Month = null,
        /** Дела в качестве истца. Количество прекращенных арбитражных дел за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $petitionerStoppedCount3Year = null,
        /** Дела в качестве истца. Исковая сумма прекращенных арбитражных дел за 3 года (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $petitionerStoppedSum3Year = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, которые связаны с проведением процедуры банкротства */
        public ?CourtAnalyticsMarkerIntegerDto $defendantBankruptcyAllCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, которые связаны с проведением процедуры банкротства (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantBankruptcyAllSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел в процессе рассмотрения, которые связаны с проведением процедуры банкротства */
        public ?CourtAnalyticsMarkerIntegerDto $defendantBankruptcyInProgressCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел в процессе рассмотрения, которые связаны с проведением процедуры банкротства (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantBankruptcyInProgressSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, исход которых определить не удалось, которые связаны с проведением процедуры банкротства */
        public ?CourtAnalyticsMarkerIntegerDto $defendantBankruptcyUnknownCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, исход которых определить не удалось, которые связаны с проведением процедуры банкротства (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantBankruptcyUnknownSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, которые связаны с обязательствами по договорам займа, кредита, лизинга */
        public ?CourtAnalyticsMarkerIntegerDto $defendantCreditCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, которые связаны с обязательствами по договорам займа, кредита, лизинга (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantCreditSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, которые связаны с налогами: иски налоговых органов, взыскание налогов, оспаривание решений налоговых органов */
        public ?CourtAnalyticsMarkerIntegerDto $defendantTaxCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, которые связаны с налогами: иски налоговых органов, взыскание налогов, оспаривание решений налоговых органов (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantTaxSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, которые связаны с обязательствами по договорам на оказание услуг */
        public ?CourtAnalyticsMarkerIntegerDto $defendantServiceCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, которые связаны с обязательствами по договорам на оказание услуг (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantServiceSum = null,
        /** Дела в качестве ответчика. Количество арбитражных дел, которые связаны с обязательствами по договорам поставки */
        public ?CourtAnalyticsMarkerIntegerDto $defendantSupplyCount = null,
        /** Дела в качестве ответчика. Исковая сумма арбитражных дел, которые связаны с обязательствами по договорам поставки (в рублях) */
        public ?CourtAnalyticsMarkerNumberDto $defendantSupplySum = null,
        /** Дела в качестве ответчика. Суды общей юрисдикции. Количество найденных дел в отношении организаций со схожими реквизитами, за исключением дел по административным правонарушениям за 12 месяцев */
        public ?CourtAnalyticsMarkerIntegerDto $defendantGeneralCourt12Month = null,
        /** Дела в качестве ответчика. Суды общей юрисдикции. Количество найденных дел в отношении организаций со схожими реквизитами, за исключением дел по административным правонарушениям за 3 года */
        public ?CourtAnalyticsMarkerIntegerDto $defendantGeneralCourt3Year = null,
    ) {
    }
}
