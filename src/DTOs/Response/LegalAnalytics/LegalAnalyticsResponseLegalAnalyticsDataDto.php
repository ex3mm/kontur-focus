<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\LegalAnalytics;

/**
 * DTO сгенерирован из docs/endpoints/legalAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class LegalAnalyticsResponseLegalAnalyticsDataDto
{
    public function __construct(
        /** Общие сведения об организации. Маркер 'Рекомендована дополнительная проверка' */
        public ?LegalAnalyticsMarkerBooleanDto $additionalCheckNeeded = null,
        /** Общие сведения об организации. Число потенциальных сайтов компании */
        public ?LegalAnalyticsMarkerIntegerDto $potentialSitesCount = null,
        /** Общие сведения об организации. Количество товарных знаков, действующих или недействующих, в которых упоминается текущая компания */
        public ?LegalAnalyticsMarkerIntegerDto $trademarksCount = null,
        /** Вакансии. Количество открытых вакансий на сайте HeadHunter */
        public ?LegalAnalyticsMarkerIntegerDto $headHunterOpenVacancies = null,
        /** Вакансии. Количество открытых вакансий на сайте SuperJob */
        public ?LegalAnalyticsMarkerIntegerDto $superJobOpenVacancies = null,
        /** Вакансии. Количество открытых вакансий на сайте Работа России */
        public ?LegalAnalyticsMarkerIntegerDto $workInRussiaOpenVacancies = null,
        /** Регистрация. Организация зарегистрирована менее 3 месяцев тому назад */
        public ?LegalAnalyticsMarkerBooleanDto $register3Month = null,
        /** Регистрация. Организация зарегистрирована менее 6 месяцев тому назад */
        public ?LegalAnalyticsMarkerBooleanDto $register6Month = null,
        /** Регистрация. Организация зарегистрирована менее 12 месяцев тому назад */
        public ?LegalAnalyticsMarkerBooleanDto $register12Month = null,
        /** Недостоверные сведения. В ЕГРЮЛ указан признак недостоверности сведений в отношении адреса */
        public ?LegalAnalyticsMarkerBooleanDto $unreliableAddress = null,
        /** Недостоверные сведения. В ЕГРЮЛ указан признак недостоверности сведений в отношении руководителя */
        public ?LegalAnalyticsMarkerBooleanDto $unreliableManager = null,
        /** Недостоверные сведения. В ЕГРЮЛ указан признак недостоверности сведений в отношении учредителей */
        public ?LegalAnalyticsMarkerBooleanDto $unreliableFounder = null,
        /** Недостоверные сведения. В ЕГРЮЛ указан признак недостоверности сведений в отношении управляющей компании */
        public ?LegalAnalyticsMarkerBooleanDto $unreliableGroup = null,
        /** Банковские счета. Дата, когда в последний раз осуществлялась проверка на наличие ограничений на операции по банковским счетам организации, установленных ФНС */
        public ?LegalAnalyticsMarkerDateDto $lastBankAccountFnsBlockDate = null,
        /** Банковские счета. Наличие ограничений на операции по банковским счетам организации, установленных ФНС, по состоянию на lastBankAccountFnsBlockDate */
        public ?LegalAnalyticsMarkerBooleanDto $bankAccountFnsBlock = null,
        /** У организации высокий риск совершения подозрительных операций согласно платформе «Знай своего клиента». Высокая вероятность блокировки счетов */
        public ?LegalAnalyticsMarkerBooleanDto $highRiskOfBlockingOperations = null,
        /** Сотрудники. Дата, за которую доступна последняя среднесписочная численность работников (ФНС) */
        public ?LegalAnalyticsMarkerDateDto $staffNumberDate = null,
        /** Сотрудники. Последняя опубликованная среднесписочная численность работников на staffNumberDate (ФНС) */
        public ?LegalAnalyticsMarkerIntegerDto $staffNumber = null,
        /** История по среднесписочной численности сотрудников. Отображается за 4 года. Количество лет считается от года, когда в последний раз была опубликована среднесписочная численность работников */
        public ?LegalAnalyticsMarkerObjectDto $historyStaffNumbers = null,
        /** Малое и среднее предпринимательство. Дата последнего изменения в реестре субъектов малого и среднего предпринимательства (ФНС) */
        public ?LegalAnalyticsMarkerDateDto $enterpriseChangeDate = null,
        /** Малое и среднее предпринимательство. Дата включения лица в реестр субъектов малого и среднего предпринимательства (ФНС) */
        public ?LegalAnalyticsMarkerDateDto $enterpriseIncludeDate = null,
        /** Малое и среднее предпринимательство. Дата последнего исключения лица из реестра субъектов малого и среднего предпринимательства (ФНС). Информация доступна, если исключение из реестра произошло за последние 6 месяцев и независимо от того, находится ли ЮЛ в реестре на текущий момент */
        public ?LegalAnalyticsMarkerDateDto $enterpriseDeleteDate = null,
        /** Малое и среднее предпринимательство. Наличие категории микропредприятия в едином реестре субъектов малого и среднего предпринимательства (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $enterpriseMicro = null,
        /** Малое и среднее предпринимательство. Наличие категории малого предприятия в едином реестре субъектов малого и среднего предпринимательства (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $enterpriseSmall = null,
        /** Малое и среднее предпринимательство. Наличие категории среднего предприятия в едином реестре субъектов малого и среднего предпринимательства (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $enterpriseMean = null,
        /** Малое и среднее предпринимательство. Организация получила меры поддержки малого и среднего предпринимательства за 12 месяцев (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $enterpriseSupport12Month = null,
        /** Малое и среднее предпринимательство. Организация находится в реестре получателей мер поддержки малого и среднего предпринимательства (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $enterpriseSupport = null,
        /** Реестры ФНС. Применяет упрощенную систему налогообложения — УСН по состоянию на fnsSpecialTaxDate (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsSimpleTax = null,
        /** Реестры ФНС. Применяет автоматизированную упрощенную систему налогообложения — АУСН по состоянию на fnsSpecialTaxDate (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsAutomateTax = null,
        /** Реестры ФНС. Является плательщиком единого сельскохозяйственного налога — ЕСХН по состоянию на fnsSpecialTaxDate (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsAgricultureTax = null,
        /** Реестры ФНС. Применяет соглашение о разделе продукции — СРП по состоянию на fnsSpecialTaxDate (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsSection = null,
        /** Реестры ФНС. Применяет патентную систему налогообложения — ПСН по состоянию на fnsSpecialTaxDate. Маркер доступен только для ИП (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsPatentTax = null,
        /** Реестры ФНС. Применяет специальный налоговый режим «Налог на профессиональный доход» - НПД (самозанятость) по состоянию на fnsSpecialTaxDate. Маркер доступен только для ИП (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsProfessionalIncomeTax = null,
        /** Реестры ФНС. Дата состояния сведений о специальных налоговых режимах, применяемых налогоплательщиками (ФНС) */
        public ?LegalAnalyticsMarkerDateDto $fnsSpecialTaxDate = null,
        /** Реестры ФНС. ФИО руководителей были найдены в реестре дисквалифицированных лиц (ФНС) или в выписке ЕГРЮЛ */
        public ?LegalAnalyticsMarkerBooleanDto $fnsDisqualified = null,
        /** Реестры ФНС. Наличие сведений о непредставлении налоговой отчетности более года (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsTaxReportMissing = null,
        /** Реестры ФНС. Наличие сведений о задолженности по уплате налогов, превышающей 1000 рублей, которая направлялась на взыскание судебному приставу-исполнителю (ФНС) */
        public ?LegalAnalyticsMarkerBooleanDto $fnsHasTaxDebt = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц организация подавала заявления в ЕГРЮЛ, связанные с планируемой ликвидацией организации */
        public ?LegalAnalyticsMarkerBooleanDto $documentsForLiquidation = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц организация подавала заявления в ЕГРЮЛ, связанные с изменением руководителя или управляющей компании. По заявлениям еще не принято решение о государственной регистрации, либо принято решение об отказе в регистрации. Указан, если был известен тип изменения, если не известен, то указывается маркер documentsP13014 */
        public ?LegalAnalyticsMarkerBooleanDto $documentsForManagementChange = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц организация подавала заявления в ЕГРЮЛ, связанные с изменением состава участников (владельцев). По заявлениям еще не принято решение о государственной регистрации, либо принято решение об отказе в регистрации. Указан, если был известен тип изменения, если не известен, то указывается маркер documentsP13014 */
        public ?LegalAnalyticsMarkerBooleanDto $documentsForOwnerChange = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц организация подавала заявления в ЕГРЮЛ, связанные с изменением юридического адреса. По заявлениям еще не принято решение о государственной регистрации, либо принято решение об отказе в регистрации. Указан, если был известен тип изменения, если не известен, то указывается маркер documentsP13014 */
        public ?LegalAnalyticsMarkerBooleanDto $documentsForAddressChange = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц организация подавала заявления в ЕГРЮЛ, связанные с изменением уставного капитала. По заявлениям еще не принято решение о государственной регистрации, либо принято решение об отказе в регистрации. Указан, если был известен тип изменения, если не известен, то указывается маркер documentsP13014 */
        public ?LegalAnalyticsMarkerBooleanDto $documentsForCapitalChange = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц были поданы заявления в ЕГРИП, связанные с прекращением деятельности лица в качестве ИП */
        public ?LegalAnalyticsMarkerBooleanDto $documentsForStop = null,
        /** Заявления в ЕГРЮЛ и ЕГРИП. За последний месяц организация подавала заявления об изменении сведений в ЕГРЮЛ по форме Р13014. По заявлениям еще не принято решение о государственной регистрации, либо принято решение об отказе в регистрации */
        public ?LegalAnalyticsMarkerBooleanDto $documentsP13014 = null,
        /** Проверки. Количество проверок за последние 12 месяцев, по которым нарушения не выявлены */
        public ?LegalAnalyticsMarkerIntegerDto $checkWithoutViolation12Month = null,
        /** Проверки. Количество проверок за последние 12 месяцев, по которым нарушения выявлены */
        public ?LegalAnalyticsMarkerIntegerDto $checkWithViolation12Month = null,
        /** Проверки. Количество проверок за последние 12 месяцев, по которым результат неизвестен */
        public ?LegalAnalyticsMarkerIntegerDto $checkUnknown12Month = null,
        /** Залоги. Число уведомлений о залогах движимого имущества (залогодатель) */
        public ?LegalAnalyticsMarkerIntegerDto $depositPledger = null,
        /** Залоги. Число уведомлений о залогах движимого имущества (залогодержатель) */
        public ?LegalAnalyticsMarkerIntegerDto $depositPledgee = null,
    ) {
    }
}
