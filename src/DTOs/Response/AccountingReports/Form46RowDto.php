<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\AccountingReports;

/**
 * Строка формы 4 или 6 бухгалтерской отчётности
 */
final readonly class Form46RowDto
{
    public function __construct(
        /** Код строки */
        public ?int $code,
        /** Название строки */
        public ?string $name,
        /** Значение на конец периода */
        public ?int $endValue,
    ) {
    }
}
