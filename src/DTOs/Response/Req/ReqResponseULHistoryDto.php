<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseULHistoryDto
{
    /**
 * @param array<ReqKppWithDateDto>|null $kpps
 * @param array<ReqLegalNameDto>|null $legalNames
 * @param array<ReqLegalAddressDto>|null $legalAddresses
 * @param array<ReqManagementCompanyDto>|null $managementCompanies
 * @param array<ReqHeadDto>|null $heads
 */
    public function __construct(
        #[ArrayOf(ReqKppWithDateDto::class)]
        /** @var array<ReqKppWithDateDto>|null КПП */
        public ?array $kpps = null,
        #[ArrayOf(ReqLegalNameDto::class)]
        /** @var array<ReqLegalNameDto>|null Наименование юридического лица */
        public ?array $legalNames = null,
        #[ArrayOf(ReqLegalAddressDto::class)]
        /** @var array<ReqLegalAddressDto>|null Список юридических адресов из истории */
        public ?array $legalAddresses = null,
        #[ArrayOf(ReqManagementCompanyDto::class)]
        /** @var array<ReqManagementCompanyDto>|null Управляющие компании */
        public ?array $managementCompanies = null,
        #[ArrayOf(ReqHeadDto::class)]
        /** @var array<ReqHeadDto>|null Лица, имеющие право подписи без доверенности (руководители) из истории */
        public ?array $heads = null,
    ) {
    }
}
