<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Exceptions;

final class ConfigurationException extends KonturFocusException
{
    /**
     * @param list<string> $allowed
     */
    public static function invalidLoggingLevel(string $provided, array $allowed): self
    {
        return new self(sprintf(
            'Недопустимый уровень логирования "%s". Разрешенные уровни: %s',
            $provided,
            implode(', ', $allowed),
        ));
    }

    public static function missingApiKey(): self
    {
        return new self('API ключ Контур.Фокус отсутствует. Настройте параметр "key" в конфигурации пакета.');
    }

    public static function invalidBaseUrl(string $baseUrl): self
    {
        return new self(sprintf('Недопустимый базовый URL "%s".', $baseUrl));
    }

    public static function dtoClassRequired(string $endpointPath): self
    {
        return new self(sprintf('Для endpoint "%s" требуется указать DTO класс при использовании режима asDto().', $endpointPath));
    }
}
