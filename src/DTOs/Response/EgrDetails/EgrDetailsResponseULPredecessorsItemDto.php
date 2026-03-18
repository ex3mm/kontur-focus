<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseULPredecessorsItemDto
{
    public function __construct(
        /** Наименование организации */
        public ?string $name = null,
        /** ИНН */
        public ?string $inn = null,
        /** ОГРН */
        public ?string $ogrn = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
