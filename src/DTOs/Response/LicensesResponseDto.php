<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO для ответа endpoint /api3/licences
 */
final readonly class LicensesResponseDto
{
    /**
     * @param array<LicenseDto> $licenses Лицензии
     */
    public function __construct(
        public ?string $inn,
        public ?string $ogrn,
        public ?string $focusHref,
        #[ArrayOf(LicenseDto::class)]
        public array $licenses,
    ) {
    }
}
