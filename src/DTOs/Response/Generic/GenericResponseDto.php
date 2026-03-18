<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Generic;

use Ex3mm\KonturFocus\DTOs\Concerns\HasRawResponse;
use LogicException;

/**
 * @phpstan-consistent-constructor
 */
readonly class GenericResponseDto
{
    use HasRawResponse;

    /**
     * @param array<mixed> $payload
     */
    public function __construct(
        public array $payload,
        public ?string $raw = null,
    ) {
    }

    public function withRawResponse(string $raw): static
    {
        if ($this->raw !== null) {
            throw new LogicException('Raw response already assigned.');
        }

        return new static($this->payload, $raw);
    }
}
