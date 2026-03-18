<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * @param array<string, mixed> $options
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface;
}
