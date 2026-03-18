<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsNalogRegBodyDto
{
    public function __construct(
        /** Код налогового органа */
        public ?string $nalogCode = null,
        /** Наименование налогового органа */
        public ?string $nalogName = null,
        /** Дата постановки на учет */
        public ?string $nalogRegDate = null,
        /** Адрес регистрирующего органа */
        public ?string $nalogRegAddress = null,
        /** КПП */
        public ?string $kpp = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
