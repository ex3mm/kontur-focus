<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Contracts;

interface EndpointInterface
{
    public function path(): string;

    /**
     * @return class-string|null
     */
    public function defaultDtoClass(): ?string;

    public function requiresInnOrOgrn(): bool;
}
