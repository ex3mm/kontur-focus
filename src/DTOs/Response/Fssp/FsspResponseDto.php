<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Fssp;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Ответ endpoint /api3/fssp.
 */
final readonly class FsspResponseDto
{
    /**
     * @param array<FsspDataDto>|null $fssp Исполнительные производства
     */
    public function __construct(
        /** ИНН организации */
        public ?string $inn = null,
        /** ОГРН организации */
        public ?string $ogrn = null,
        /** Дата актуальности данных */
        public ?string $updateDate = null,
        /** Ссылка на карточку организации в Контур.Фокусе */
        public ?string $focusHref = null,
        #[ArrayOf(FsspDataDto::class)]
        public ?array $fssp = null,
    ) {
    }
}
