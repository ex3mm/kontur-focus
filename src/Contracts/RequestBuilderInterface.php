<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Contracts;

use Ex3mm\KonturFocus\DTOs\CollectionResponse;

interface RequestBuilderInterface
{
    public function inn(string $inn): static;

    public function ogrn(string $ogrn): static;

    public function param(string $name, string|int|float|bool $value): static;

    /**
     * @param class-string|null $dtoClass
     */
    public function asDto(?string $dtoClass = null): static;

    public function asArray(): static;

    public function throwOnEmpty(): static;

    /**
     * @return array<mixed>|CollectionResponse
     */
    public function get(): array|CollectionResponse;
}
