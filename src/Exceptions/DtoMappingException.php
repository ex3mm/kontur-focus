<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Exceptions;

final class DtoMappingException extends KonturFocusException
{
    public static function missingField(string $path): self
    {
        return new self(sprintf('%s: отсутствует обязательное поле', $path));
    }

    public static function invalidType(string $path, string $expected, string $actual): self
    {
        return new self(sprintf('%s: ожидается %s, получено %s', $path, $expected, $actual));
    }

    public static function invalidArrayElementType(string $path): self
    {
        return new self(sprintf('%s: отсутствуют метаданные типа элемента массива (требуется атрибут ArrayOf)', $path));
    }
}
