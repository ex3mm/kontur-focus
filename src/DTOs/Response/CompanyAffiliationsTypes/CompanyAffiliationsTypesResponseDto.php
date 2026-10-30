<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Связанная компания из ответа endpoint /api3/companyAffiliationsTypes.
 */
final readonly class CompanyAffiliationsTypesResponseDto
{
    /**
     * @param array<CompanyAffiliationConnectionDto>|null $connections Связи по компании
     */
    public function __construct(
        /** ИНН связанной компании или ИП */
        public ?string $inn = null,
        /** ОГРН связанной компании или ИП */
        public ?string $ogrn = null,
        /** Наименование связанной компании или ФИО ИП */
        public ?string $name = null,
        /** Статус связанной компании или ИП */
        public ?CompanyAffiliationStatusDto $status = null,
        /** Ссылка на карточку связанной компании в Контур.Фокусе */
        public ?string $focusHref = null,
        #[ArrayOf(CompanyAffiliationConnectionDto::class)]
        public ?array $connections = null,
    ) {
    }
}
