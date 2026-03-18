<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseULDto
{
    /**
 * @param array<ReqBranchDto>|null $branches
 * @param array<ReqHeadDto>|null $heads
 * @param array<ReqManagementCompanyDto>|null $managementCompanies
 */
    public function __construct(
        /** КПП */
        public ?string $kpp = null,
        /** Код ОКПО */
        public ?string $okpo = null,
        /** Код ОКАТО */
        public ?string $okato = null,
        /** Код ОКФС */
        public ?string $okfs = null,
        /** Код ОКТМО */
        public ?string $oktmo = null,
        /** Код ОКОГУ */
        public ?string $okogu = null,
        /** Код ОКОПФ */
        public ?string $okopf = null,
        /** Наименование организационно-правовой формы */
        public ?string $opf = null,
        /** Наименование юридического лица */
        public ?ReqLegalNameDto $legalName = null,
        /** Юридический адрес */
        public ?ReqLegalAddressDto $legalAddress = null,
        #[ArrayOf(ReqBranchDto::class)]
        /** @var array<ReqBranchDto>|null Филиалы и представительства */
        public ?array $branches = null,
        /** Статус организации */
        public ?ReqResponseULStatusDto $status = null,
        /** Дата образования */
        public ?string $registrationDate = null,
        /** Дата прекращения деятельности в результате ликвидации, реорганизации или других событий */
        public ?string $dissolutionDate = null,
        #[ArrayOf(ReqHeadDto::class)]
        /** @var array<ReqHeadDto>|null Лица, имеющие право подписи без доверенности (руководители) */
        public ?array $heads = null,
        #[ArrayOf(ReqManagementCompanyDto::class)]
        /** @var array<ReqManagementCompanyDto>|null Управляющие компании */
        public ?array $managementCompanies = null,
        /** Исторические значения реквизитов */
        public ?ReqResponseULHistoryDto $history = null,
    ) {
    }
}
