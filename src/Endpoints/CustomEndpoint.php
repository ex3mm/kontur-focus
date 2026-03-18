<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

final class CustomEndpoint extends AbstractEndpoint
{
    public function __construct(string $path)
    {
        parent::__construct($path, null, false);
    }
}
