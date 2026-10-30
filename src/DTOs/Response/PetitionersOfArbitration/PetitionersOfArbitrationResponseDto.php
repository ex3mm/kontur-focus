<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * Ответ endpoint /api3/petitionersOfArbitration.
 */
final readonly class PetitionersOfArbitrationResponseDto
{
    /**
     * @param array<PetitionerDto>|null $petitioners Истцы по арбитражным делам
     */
    public function __construct(
        /** ИНН организации */
        public ?string $inn = null,
        /** ОГРН организации */
        public ?string $ogrn = null,
        /** Ссылка на карточку организации в Контур.Фокусе */
        public ?string $focusHref = null,
        #[ArrayOf(PetitionerDto::class)]
        public ?array $petitioners = null,
    ) {
    }
}
