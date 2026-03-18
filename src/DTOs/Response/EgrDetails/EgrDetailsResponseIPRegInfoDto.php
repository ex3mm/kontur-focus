<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseIPRegInfoDto
{
    public function __construct(
        /** Дата присвоения ОГРНИП */
        public ?string $ogrnDate = null,
        /** Наименование органа, зарегистрировавшего индивидуального предпринимателя до 1 января 2004 года */
        public ?string $regName = null,
        /** Регистрационный номер, присвоенный до 1 января 2004 года */
        public ?string $regNum = null,
    ) {
    }
}
