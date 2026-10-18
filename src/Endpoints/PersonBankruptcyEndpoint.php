<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

use Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy\PersonBankruptcyResponseDto;

final class PersonBankruptcyEndpoint extends AbstractEndpoint
{
    public function __construct()
    {
        parent::__construct('/api3/personBankruptcy', PersonBankruptcyResponseDto::class, false);
    }
}
