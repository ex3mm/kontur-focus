<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseULRegInfoDto
{
    public function __construct(
        /** Дата присвоения ОГРН */
        public ?string $ogrnDate = null,
        /** Наименование органа, зарегистрировавшего юридическое лицо до 1 июля 2002 года */
        public ?string $regName = null,
        /** Регистрационный номер, присвоенный до 1 июля 2002 года */
        public ?string $regNum = null,
    ) {
    }
}
