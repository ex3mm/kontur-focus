<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

use Ex3mm\KonturFocus\DTOs\Response\LinkAnalytics\LinkAnalyticsResponseDto;

final class LinkAnalyticsEndpoint extends AbstractEndpoint
{
    public function __construct()
    {
        parent::__construct('/api3/linkAnalytics', LinkAnalyticsResponseDto::class);
    }
}
