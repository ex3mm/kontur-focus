<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\AccountingReports;

/**
 * Строка формы 1 или 2 бухгалтерской отчётности
 */
final readonly class Form12RowDto
{
    public function __construct(
        /** Код строки */
        public ?int $code,
        /** Название строки */
        public ?string $name,
        /** Значение на начало периода */
        public ?int $startValue,
        /** Значение на конец периода */
        public ?int $endValue,
    ) {
    }
}
