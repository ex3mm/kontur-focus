<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class RateLimitException extends HttpException
{
    public function __construct(
        string $message,
        int $statusCode,
        public readonly ?int $retryAfterSeconds = null,
        ?RequestInterface $request = null,
        ?ResponseInterface $response = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $request, $response, $previous);
    }
}
