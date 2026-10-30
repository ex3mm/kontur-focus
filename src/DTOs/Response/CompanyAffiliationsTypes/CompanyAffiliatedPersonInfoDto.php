<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Информация о физическом лице, через которое построена связь.
 */
final readonly class CompanyAffiliatedPersonInfoDto
{
    /**
     * @param array<CompanyAffiliationRoleDto>|null $roleInTheConnectedCompany Роли в связанной компании
     * @param array<CompanyAffiliationRoleDto>|null $roleInTheAuditedCompany Роли в проверяемой компании
     */
    public function __construct(
        /** ИНН физического лица */
        public ?string $inn = null,
        #[ArrayOf(CompanyAffiliationRoleDto::class)]
        public ?array $roleInTheConnectedCompany = null,
        #[ArrayOf(CompanyAffiliationRoleDto::class)]
        public ?array $roleInTheAuditedCompany = null,
        /** ФИО физического лица */
        public ?string $fio = null,
    ) {
    }
}
