<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant;

/**
 * Цена закупки или контракта.
 */
final readonly class PurchasePriceDto
{
    public function __construct(
        /** Цена */
        public ?float $sum = null,
        /** Код валюты */
        public ?string $currencyCode = null,
    ) {
    }
}
