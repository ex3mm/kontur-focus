<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Exceptions;

final class InvalidResponseException extends KonturFocusException
{
    public static function invalidJson(string $message): self
    {
        return new self('Недопустимый JSON ответ: '.$message);
    }

    public static function unexpectedContentType(string $contentType): self
    {
        return new self('Неожиданный тип содержимого ответа: '.$contentType);
    }

    public static function emptySuccessBody(int $statusCode): self
    {
        return new self(sprintf('Получено пустое тело ответа для успешного запроса (%d).', $statusCode));
    }
}
