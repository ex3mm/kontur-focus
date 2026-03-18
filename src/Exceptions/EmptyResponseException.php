<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Exceptions;

/**
 * Исключение выбрасывается когда API вернул пустой результат
 */
final class EmptyResponseException extends KonturFocusException
{
    public static function noDataFound(string $endpoint): self
    {
        return new self(
            sprintf('API endpoint "%s" вернул пустой результат. Данные не найдены.', $endpoint)
        );
    }
}
