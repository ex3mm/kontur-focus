<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

/**
 * Код объекта закупки из классификатора.
 */
final readonly class PurchaseProductCodeDto
{
    public function __construct(
        /** Код в соответствии со справочником */
        public ?string $code = null,
        /** Наименование вида деятельности */
        public ?string $name = null,
    ) {
    }
}
