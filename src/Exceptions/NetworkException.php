<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Exceptions;

use Psr\Http\Message\RequestInterface;

final class NetworkException extends KonturFocusException
{
    public function __construct(
        string $message,
        public readonly ?RequestInterface $request = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
