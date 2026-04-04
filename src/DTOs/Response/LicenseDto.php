<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO для лицензии
 */
final readonly class LicenseDto
{
    /**
     * @param array<string> $services Описание видов работ/услуг
     * @param array<string> $addresses Места действия лицензии
     */
    public function __construct(
        public ?string $source,
        public ?string $officialNum,
        public ?string $issuerName,
        public ?string $date,
        public ?string $dateStart,
        public ?string $dateEnd,
        public ?string $statusDescription,
        public ?string $activity,
        #[ArrayOf('string')]
        public array $services = [],
        #[ArrayOf('string')]
        public array $addresses = [],
    ) {
    }
}
