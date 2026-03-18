<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\Exceptions\AuthenticationException;
use Ex3mm\KonturFocus\Exceptions\AuthorizationException;
use Ex3mm\KonturFocus\Exceptions\ConflictException;
use Ex3mm\KonturFocus\Exceptions\HttpException;
use Ex3mm\KonturFocus\Exceptions\NetworkException;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\Exceptions\RateLimitException;
use Ex3mm\KonturFocus\Exceptions\ServerException;
use Ex3mm\KonturFocus\Exceptions\ValidationException;
use Psr\Http\Message\ResponseInterface;

final class KonturFocusClient implements ClientInterface
{
    private ?Client $guzzle = null;

    private ?string $configHash = null;

    public function __construct(
        private KonturFocusConfig $config,
        private readonly GuzzleClientFactory $factory,
    ) {
    }

    public function withConfig(KonturFocusConfig $config): self
    {
        $clone = clone $this;
        $clone->config = $config;

        return $clone;
    }

    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options + ['http_errors' => false]);
        } catch (RequestException $exception) {
            if ($exception->getResponse() !== null) {
                throw $this->toHttpException(
                    $exception->getResponse()->getStatusCode(),
                    $method,
                    $uri,
                    $exception->getResponse(),
                    $exception,
                );
            }

            throw new NetworkException($exception->getMessage(), $exception->getRequest(), $exception);
        } catch (TransferException $exception) {
            throw new NetworkException($exception->getMessage(), previous: $exception);
        } catch (GuzzleException $exception) {
            throw new NetworkException($exception->getMessage(), previous: $exception);
        }

        if ($response->getStatusCode() >= 400) {
            throw $this->toHttpException($response->getStatusCode(), $method, $uri, $response);
        }

        return $response;
    }

    private function getClient(): Client
    {
        $hash = $this->config->hash();

        if ($this->guzzle === null || $this->configHash !== $hash) {
            $this->guzzle = $this->factory->create($this->config);
            $this->configHash = $hash;
        }

        return $this->guzzle;
    }

    private function toHttpException(
        int $statusCode,
        string $method,
        string $uri,
        ResponseInterface $response,
        ?\Throwable $previous = null,
    ): HttpException {
        $message = sprintf(
            'HTTP %d returned for %s %s: %s',
            $statusCode,
            strtoupper($method),
            $uri,
            $this->responseSnippet($response),
        );

        return match ($statusCode) {
            400, 422 => new ValidationException($message, $statusCode, response: $response, previous: $previous),
            401 => new AuthenticationException($message, $statusCode, response: $response, previous: $previous),
            403 => new AuthorizationException($message, $statusCode, response: $response, previous: $previous),
            404 => new NotFoundException($message, $statusCode, response: $response, previous: $previous),
            409 => new ConflictException($message, $statusCode, response: $response, previous: $previous),
            429 => new RateLimitException(
                $message,
                $statusCode,
                $this->retryAfterSeconds($response->getHeaderLine('Retry-After')),
                response: $response,
                previous: $previous,
            ),
            default => $statusCode >= 500
                ? new ServerException($message, $statusCode, response: $response, previous: $previous)
                : new HttpException($message, $statusCode, response: $response, previous: $previous),
        };
    }

    private function retryAfterSeconds(string $header): ?int
    {
        $value = trim($header);
        if ($value === '') {
            return null;
        }

        if (ctype_digit($value)) {
            return (int) $value;
        }

        $timestamp = strtotime($value);
        if ($timestamp === false) {
            return null;
        }

        return max(0, $timestamp - time());
    }

    private function responseSnippet(ResponseInterface $response): string
    {
        $body = trim((string) $response->getBody());
        if ($body === '') {
            return '<empty body>';
        }

        if (strlen($body) <= 300) {
            return $body;
        }

        return substr($body, 0, 300).'...';
    }
}
