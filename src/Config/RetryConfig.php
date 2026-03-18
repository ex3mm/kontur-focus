<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Config;

readonly class RetryConfig
{
    public function __construct(
        public bool $enabled,
        public int $maxAttempts,
        public int $delayMs,
        public float $multiplier,
        public int $maxDelayMs,
    ) {
    }

    public function delayForAttempt(int $attempt): int
    {
        if ($attempt <= 1) {
            return $this->delayMs;
        }

        $delay = (int) round($this->delayMs * ($this->multiplier ** ($attempt - 1)));

        return min($delay, $this->maxDelayMs);
    }
}
