<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Config;

readonly class CacheConfig
{
    public function __construct(
        public bool $enabled,
        public int $ttl,
        public string $store,
        public string $namespace,
    ) {
    }
}
