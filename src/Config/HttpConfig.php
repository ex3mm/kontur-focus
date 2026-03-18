<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Config;

readonly class HttpConfig
{
    public function __construct(
        public float $timeout,
        public float $connectTimeout,
        public bool $verifySsl,
    ) {
    }
}
