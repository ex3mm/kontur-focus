<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Attributes;

use Attribute;
use InvalidArgumentException;

#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class MapFrom
{
    public function __construct(public string $field)
    {
        if ($this->field === '') {
            throw new InvalidArgumentException('Mapped field name must not be empty.');
        }
    }
}
