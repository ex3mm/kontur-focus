<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\AccountingReports;

/**
 * Строка формы 3 бухгалтерской отчётности
 */
final readonly class Form3RowDto
{
    public function __construct(
        /** Составная часть капитала */
        public ?string $capitalPortion,
        /** Код строки */
        public ?int $code,
        /** Название строки */
        public ?string $name,
        /** Значение на конец периода */
        public ?int $endValue,
    ) {
    }
}
