<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\AccountingReports;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO для ответа endpoint /api3/accountingReports
 */
final readonly class AccountingReportsResponseDto
{
    /**
     * @param array<BuhFormDto> $buhForms Бухгалтерские формы
     */
    public function __construct(
        /** ИНН */
        public ?string $inn,
        /** ОГРН */
        public ?string $ogrn,
        /** Ссылка на карточку юридического лица в Контур.Фокусе */
        public ?string $focusHref,
        #[ArrayOf(BuhFormDto::class)]
        public array $buhForms = [],
    ) {
    }
}
