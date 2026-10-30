<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

/**
 * Связь между проверяемой и связанной компаниями.
 */
final readonly class CompanyAffiliationConnectionDto
{
    public function __construct(
        /** Признак связи */
        public ?string $connectionType = null,
        /** Признак актуальности связи */
        public ?string $actualityType = null,
        /** Информация о юридическом лице, через которое построена связь */
        public ?CompanyAffiliatedCompanyInfoDto $companyInfo = null,
        /** Информация о физическом лице, через которое построена связь */
        public ?CompanyAffiliatedPersonInfoDto $personInfo = null,
        /** Доля владения участника или учредителя */
        public ?CompanyAffiliationShareDto $founderShare = null,
        /** Доля акций */
        public ?CompanyAffiliationShareholderShareDto $shareholderShare = null,
    ) {
    }
}
