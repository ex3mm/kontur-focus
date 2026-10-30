<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes;

/**
 * Доля акций.
 */
final readonly class CompanyAffiliationShareholderShareDto
{
    public function __construct(
        /** Доля обыкновенных акций в процентах */
        public ?float $votingSharesPercent = null,
        /** Доля участия в уставном капитале в процентах */
        public ?float $capitalSharesPercent = null,
    ) {
    }
}
