<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsRegistrarOfShareholdersDto
{
    public function __construct(
        /** Наименование держателя реестра акционеров */
        public ?string $name = null,
        /** ИНН держателя реестра акционеров (если указан) */
        public ?string $inn = null,
        /** ОГРН держателя реестра акционеров (если указан) */
        public ?string $ogrn = null,
        /** Дата последнего внесения изменений */
        public ?string $date = null,
        /** Дата первого внесения сведений */
        public ?string $firstDate = null,
    ) {
    }
}
