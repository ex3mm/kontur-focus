<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Contracts;

interface ResponseMapperInterface
{
    /**
     * @param array<mixed> $data
     * @param class-string $dtoClass
     *
     * @return array<object>|object
     */
    public function map(array $data, string $dtoClass): array|object;
}
