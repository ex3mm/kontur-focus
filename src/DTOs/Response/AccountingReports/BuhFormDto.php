<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\AccountingReports;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Бухгалтерские формы за отчётный год
 */
final readonly class BuhFormDto
{
    /**
     * @param array<Form12RowDto> $form1 Форма 1
     * @param array<Form12RowDto> $form2 Форма 2
     * @param array<Form3RowDto> $form3 Форма 3
     * @param array<Form46RowDto> $form4 Форма 4
     * @param array<Form46RowDto> $form6 Форма 6
     */
    public function __construct(
        /** Год */
        public ?int $year,
        /** Тип организации (SONO, Small, Large) */
        public ?string $organizationType,
        #[ArrayOf(Form12RowDto::class)]
        public array $form1 = [],
        #[ArrayOf(Form12RowDto::class)]
        public array $form2 = [],
        #[ArrayOf(Form3RowDto::class)]
        public array $form3 = [],
        #[ArrayOf(Form46RowDto::class)]
        public array $form4 = [],
        #[ArrayOf(Form46RowDto::class)]
        public array $form6 = [],
    ) {
    }
}
