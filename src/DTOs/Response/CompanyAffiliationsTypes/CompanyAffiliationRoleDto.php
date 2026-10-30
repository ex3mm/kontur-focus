<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

/**
 * Роль лица в компании.
 */
final readonly class CompanyAffiliationRoleDto
{
    public function __construct(
        /** Роль в компании */
        public ?string $roleType = null,
        /** Доля владения участника или учредителя */
        public ?CompanyAffiliationShareDto $founderShare = null,
        /** Доля акций */
        public ?CompanyAffiliationShareholderShareDto $shareholderShare = null,
        /** Признак актуальности роли */
        public ?string $actualityType = null,
    ) {
    }
}
