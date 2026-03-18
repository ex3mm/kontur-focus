<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Requests;

use JsonException;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\Contracts\RequestBuilderInterface;
use Ex3mm\KonturFocus\Contracts\ResponseMapperInterface;
use Ex3mm\KonturFocus\DTOs\CollectionResponse;
use Ex3mm\KonturFocus\Exceptions\ConfigurationException;
use Ex3mm\KonturFocus\Exceptions\EmptyResponseException;
use Ex3mm\KonturFocus\Exceptions\InvalidResponseException;

final class RequestBuilder extends AbstractRequest implements RequestBuilderInterface
{
    private const MODE_ARRAY = 'array';
    private const MODE_DTO = 'dto';

    private string $mode = self::MODE_DTO;

    /**
     * @var class-string|null
     */
    private ?string $dtoClass = null;

    private bool $throwOnEmpty = false;

    public function __construct(
        private readonly ClientInterface $client,
        private readonly ResponseMapperInterface $mapper,
        \Ex3mm\KonturFocus\Contracts\EndpointInterface $endpoint,
        string $apiKey,
    ) {
        parent::__construct($endpoint, $apiKey);
    }

    public function asDto(?string $dtoClass = null): static
    {
        $this->mode = self::MODE_DTO;
        $this->dtoClass = $dtoClass;

        return $this;
    }

    public function asArray(): static
    {
        $this->mode = self::MODE_ARRAY;

        return $this;
    }

    public function throwOnEmpty(): static
    {
        $this->throwOnEmpty = true;

        return $this;
    }

    public function get(): array|CollectionResponse
    {
        $this->validate();

        $response = $this->client->request('GET', $this->endpoint->path(), [
            'query' => $this->query(),
        ]);

        $statusCode = $response->getStatusCode();
        $rawBody = (string) $response->getBody();

        if ($statusCode >= 200 && $statusCode < 300 && trim($rawBody) === '') {
            throw InvalidResponseException::emptySuccessBody($statusCode);
        }

        $contentType = strtolower($response->getHeaderLine('Content-Type'));
        if ($statusCode >= 200 && $statusCode < 300 && $contentType !== '' && !str_contains($contentType, 'json')) {
            throw InvalidResponseException::unexpectedContentType($contentType);
        }

        try {
            $decoded = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw InvalidResponseException::invalidJson($exception->getMessage());
        }

        if (!is_array($decoded)) {
            throw InvalidResponseException::invalidJson('Decoded response root must be object or list.');
        }

        if ($this->mode === self::MODE_ARRAY) {
            return $decoded;
        }

        $dtoClass = $this->dtoClass ?? $this->endpoint->defaultDtoClass();
        if ($dtoClass === null) {
            throw ConfigurationException::dtoClassRequired($this->endpoint->path());
        }

        $mapped = $this->mapper->map($decoded, $dtoClass);

        $result = $this->attachRawResponse($mapped, $rawBody);

        // Проверяем флаг throwOnEmpty
        if ($this->throwOnEmpty && $result->total === 0) {
            throw EmptyResponseException::noDataFound($this->endpoint->path());
        }

        return $result;
    }

    /**
     * @param array<mixed>|object $mapped
     */
    private function attachRawResponse(array|object $mapped, string $raw): CollectionResponse
    {
        // Если одиночный объект - оборачиваем в массив
        if (is_object($mapped)) {
            return new CollectionResponse([$mapped], $raw, 1);
        }

        // Если массив DTO - оборачиваем в CollectionResponse
        return new CollectionResponse($mapped, $raw, count($mapped));
    }
}
