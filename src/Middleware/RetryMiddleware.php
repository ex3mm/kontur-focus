<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Middleware;

use DateTimeImmutable;
use GuzzleHttp\Middleware;
use Ex3mm\KonturFocus\Config\RetryConfig;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

final class RetryMiddleware
{
    public static function create(RetryConfig $config): callable
    {
        return Middleware::retry(
            static function (
                int $retries,
                RequestInterface $request,
                ?ResponseInterface $response = null,
                ?Throwable $exception = null,
            ) use ($config): bool {
                if (!$config->enabled) {
                    return false;
                }

                if ($retries >= $config->maxAttempts - 1) {
                    return false;
                }

                if ($exception !== null) {
                    return true;
                }

                if ($response === null) {
                    return false;
                }

                $status = $response->getStatusCode();

                return $status === 429 || $status >= 500;
            },
            static function (int $retries, ?ResponseInterface $response = null) use ($config): int {
                if ($response !== null && $response->getStatusCode() === 429) {
                    $retryAfter = self::retryAfterMilliseconds($response->getHeaderLine('Retry-After'));
                    if ($retryAfter !== null) {
                        return min($retryAfter, $config->maxDelayMs);
                    }
                }

                return $config->delayForAttempt($retries + 1);
            },
        );
    }

    private static function retryAfterMilliseconds(string $header): ?int
    {
        $value = trim($header);
        if ($value === '') {
            return null;
        }

        if (ctype_digit($value)) {
            return (int) $value * 1000;
        }

        $date = DateTimeImmutable::createFromFormat(DATE_RFC7231, $value);
        if ($date === false) {
            try {
                $date = new DateTimeImmutable($value);
            } catch (\Exception) {
                return null;
            }
        }

        $seconds = $date->getTimestamp() - time();

        return $seconds > 0 ? $seconds * 1000 : 0;
    }
}
