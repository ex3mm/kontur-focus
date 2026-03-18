<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Config;

use Ex3mm\KonturFocus\Exceptions\ConfigurationException;

readonly class LoggingConfig
{
    public const LEVEL_NONE = 'none';
    public const LEVEL_ERROR = 'error';
    public const LEVEL_BASIC = 'basic';
    public const LEVEL_HEADERS = 'headers';
    public const LEVEL_BODY = 'body';
    public const LEVEL_DEBUG = 'debug';

    private const ALLOWED_LEVELS = [
        self::LEVEL_NONE,
        self::LEVEL_ERROR,
        self::LEVEL_BASIC,
        self::LEVEL_HEADERS,
        self::LEVEL_BODY,
        self::LEVEL_DEBUG,
    ];

    public function __construct(
        public bool $enabled,
        public string $level,
        public string $channel,
        public int $maxBodySize,
    ) {
        if (!in_array($this->level, self::ALLOWED_LEVELS, true)) {
            throw ConfigurationException::invalidLoggingLevel($this->level, self::ALLOWED_LEVELS);
        }
    }

    public function isDisabled(): bool
    {
        return !$this->enabled || $this->level === self::LEVEL_NONE;
    }
}
