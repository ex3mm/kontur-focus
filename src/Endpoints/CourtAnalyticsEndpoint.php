<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

use Ex3mm\KonturFocus\DTOs\Response\CourtAnalytics\CourtAnalyticsResponseDto;

final class CourtAnalyticsEndpoint extends AbstractEndpoint
{
    public function __construct()
    {
        parent::__construct('/api3/courtAnalytics', CourtAnalyticsResponseDto::class);
    }
}
