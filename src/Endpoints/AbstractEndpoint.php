<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Endpoints;

use Ex3mm\KonturFocus\Contracts\EndpointInterface;

abstract class AbstractEndpoint implements EndpointInterface
{
    /**
     * @param class-string|null $defaultDtoClass
     */
    public function __construct(
        private readonly string $path,
        private readonly ?string $defaultDtoClass,
        private readonly bool $requiresInnOrOgrn = true,
    ) {
    }

    final public function path(): string
    {
        return $this->path;
    }

    final public function defaultDtoClass(): ?string
    {
        return $this->defaultDtoClass;
    }

    final public function requiresInnOrOgrn(): bool
    {
        return $this->requiresInnOrOgrn;
    }
}
