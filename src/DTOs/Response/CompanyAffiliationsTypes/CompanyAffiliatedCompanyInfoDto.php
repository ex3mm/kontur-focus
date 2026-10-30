<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Информация о юридическом лице, через которое построена связь.
 */
final readonly class CompanyAffiliatedCompanyInfoDto
{
    /**
     * @param array<CompanyAffiliationRoleDto>|null $roleInTheConnectedCompany Роли в связанной компании
     * @param array<CompanyAffiliationRoleDto>|null $roleInTheAuditedCompany Роли в проверяемой компании
     */
    public function __construct(
        /** ИНН */
        public ?string $inn = null,
        #[ArrayOf(CompanyAffiliationRoleDto::class)]
        public ?array $roleInTheConnectedCompany = null,
        #[ArrayOf(CompanyAffiliationRoleDto::class)]
        public ?array $roleInTheAuditedCompany = null,
        /** ОГРН(ИП) */
        public ?string $ogrn = null,
        /** Наименование юридического лица или ИП */
        public ?string $name = null,
        /** Статус организации или ИП */
        public ?CompanyAffiliationStatusDto $status = null,
    ) {
    }
}
