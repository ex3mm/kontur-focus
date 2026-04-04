<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Middleware;

use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Ex3mm\KonturFocus\Config\LoggingConfig;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class LoggingMiddleware
{
    public static function create(LoggingConfig $config, LoggerInterface $logger): callable
    {
        return static function (callable $handler) use ($config, $logger): callable {
            return static function (RequestInterface $request, array $options) use ($handler, $config, $logger): PromiseInterface {
                $promise = Create::promiseFor($handler($request, $options));

                if ($config->isDisabled()) {
                    return $promise;
                }

                $requestId = ApiKeyMaskingMiddleware::generateRequestId();
                $start = microtime(true);

                return $promise->then(
                    static function (ResponseInterface $response) use ($request, $start, $config, $logger, $requestId): ResponseInterface {
                        self::logSuccess($logger, $config, $request, $response, $start, $requestId);

                        return $response;
                    },
                    static function (Throwable $exception) use ($request, $start, $config, $logger, $requestId): PromiseInterface {
                        self::logFailure($logger, $config, $request, $exception, $start, $requestId);

                        return Create::rejectionFor($exception);
                    },
                );
            };
        };
    }

    private static function logSuccess(
        LoggerInterface $logger,
        LoggingConfig $config,
        RequestInterface $request,
        ResponseInterface $response,
        float $start,
        string $requestId,
    ): void {
        $duration = (int) ((microtime(true) - $start) * 1000);
        $statusCode = $response->getStatusCode();

        $context = [
            'request_id' => $requestId,
            'method' => $request->getMethod(),
            'url' => ApiKeyMaskingMiddleware::maskUri($request->getUri()),
            'status_code' => $statusCode,
            'duration_ms' => $duration,
        ];

        if (in_array($config->level, [LoggingConfig::LEVEL_HEADERS, LoggingConfig::LEVEL_BODY, LoggingConfig::LEVEL_DEBUG], true)) {
            $context['request_headers'] = self::normalizeHeaders($request->getHeaders());
            $context['response_headers'] = self::normalizeHeaders($response->getHeaders());
        }

        if (in_array($config->level, [LoggingConfig::LEVEL_BODY, LoggingConfig::LEVEL_DEBUG], true)) {
            $responseBody = (string) $response->getBody();
            $response->getBody()->rewind();
            $context['response_body'] = self::truncate($responseBody, $config->maxBodySize);
            $context['response_size'] = strlen($responseBody);
        }

        if ($config->level === LoggingConfig::LEVEL_DEBUG) {
            $requestBody = (string) $request->getBody();
            $request->getBody()->rewind();
            $context['request_body'] = self::truncate($requestBody, $config->maxBodySize);
            $context['request_size'] = strlen($requestBody);
        }

        $message = sprintf(
            '[%s] Kontur.Focus API: %s %s → %d (%dms)',
            $requestId,
            $request->getMethod(),
            $request->getUri()->getPath(),
            $statusCode,
            $duration
        );

        $logger->info($message, $context);
    }

    private static function logFailure(
        LoggerInterface $logger,
        LoggingConfig $config,
        RequestInterface $request,
        Throwable $exception,
        float $start,
        string $requestId,
    ): void {
        $duration = (int) ((microtime(true) - $start) * 1000);

        $context = [
            'request_id' => $requestId,
            'method' => $request->getMethod(),
            'url' => ApiKeyMaskingMiddleware::maskUri($request->getUri()),
            'duration_ms' => $duration,
            'error' => $exception->getMessage(),
            'exception' => $exception,
        ];

        if (in_array($config->level, [LoggingConfig::LEVEL_HEADERS, LoggingConfig::LEVEL_BODY, LoggingConfig::LEVEL_DEBUG], true)) {
            $context['request_headers'] = self::normalizeHeaders($request->getHeaders());
        }

        if ($config->level === LoggingConfig::LEVEL_DEBUG) {
            $requestBody = (string) $request->getBody();
            $request->getBody()->rewind();
            $context['request_body'] = self::truncate($requestBody, $config->maxBodySize);
            $context['request_size'] = strlen($requestBody);
        }

        $message = sprintf(
            '[%s] Kontur.Focus API: %s %s → ERROR (%dms)',
            $requestId,
            $request->getMethod(),
            $request->getUri()->getPath(),
            $duration
        );

        $logger->error($message, $context);
    }

    private static function truncate(string $body, int $maxBodySize): string
    {
        if (strlen($body) <= $maxBodySize) {
            return $body;
        }

        return substr($body, 0, $maxBodySize).'... [truncated]';
    }

    /**
     * @param array<array<string>> $headers
     *
     * @return array<string, array<string>>
     */
    private static function normalizeHeaders(array $headers): array
    {
        $normalized = [];

        foreach ($headers as $name => $values) {
            $normalized[(string) $name] = array_values(array_map(static fn (string $value): string => $value, $values));
        }

        return $normalized;
    }
}
