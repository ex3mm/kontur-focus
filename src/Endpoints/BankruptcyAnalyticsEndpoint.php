<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

use Ex3mm\KonturFocus\DTOs\Response\BankruptcyAnalytics\BankruptcyAnalyticsResponseDto;

final class BankruptcyAnalyticsEndpoint extends AbstractEndpoint
{
    public function __construct()
    {
        parent::__construct('/api3/bankruptcyAnalytics', BankruptcyAnalyticsResponseDto::class);
    }
}
