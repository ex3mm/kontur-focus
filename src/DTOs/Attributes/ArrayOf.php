<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Attributes;

use Attribute;
use Ex3mm\KonturFocus\Exceptions\DtoMappingException;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
final readonly class ArrayOf
{
    public function __construct(public string $type)
    {
        if ($this->type === '') {
            throw DtoMappingException::invalidArrayElementType('attribute(ArrayOf)');
        }
    }

    public function isScalar(): bool
    {
        return in_array($this->type, ['string', 'int', 'float', 'bool'], true);
    }
}
