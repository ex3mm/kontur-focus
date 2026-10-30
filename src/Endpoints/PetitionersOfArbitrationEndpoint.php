<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

use Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration\PetitionersOfArbitrationResponseDto;

final class PetitionersOfArbitrationEndpoint extends AbstractEndpoint
{
    public function __construct()
    {
        parent::__construct('/api3/petitionersOfArbitration', PetitionersOfArbitrationResponseDto::class);
    }
}
