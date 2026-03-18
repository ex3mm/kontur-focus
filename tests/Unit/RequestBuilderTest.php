<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Response;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\Contracts\ResponseMapperInterface;
use Ex3mm\KonturFocus\DTOs\Response\Req\ReqResponseDto;
use Ex3mm\KonturFocus\Endpoints\CustomEndpoint;
use Ex3mm\KonturFocus\Endpoints\ReqEndpoint;
use Ex3mm\KonturFocus\Exceptions\RequestValidationException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use Psr\Http\Message\ResponseInterface;

it('проверяет что для стандартных endpoint передан inn или ogrn', function (): void {
    $client = new class () implements ClientInterface {
        public function request(string $method, string $uri, array $options = []): ResponseInterface
        {
            return new Response(200, ['Content-Type' => 'application/json'], '{"ok":true}');
        }
    };

    $mapper = new class () implements ResponseMapperInterface {
        public function map(array $data, string $dtoClass): array|object
        {
            return new $dtoClass($data);
        }
    };

    $builder = new RequestBuilder($client, $mapper, new ReqEndpoint(), 'secret');

    $builder->asArray()->get();
})->throws(RequestValidationException::class);

it('возвращает декодированный массив в режиме asArray', function (): void {
    $client = new class () implements ClientInterface {
        public function request(string $method, string $uri, array $options = []): ResponseInterface
        {
            return new Response(200, ['Content-Type' => 'application/json'], '{"inn":"7707083893"}');
        }
    };

    $mapper = new class () implements ResponseMapperInterface {
        public function map(array $data, string $dtoClass): array|object
        {
            return new $dtoClass($data);
        }
    };

    $result = (new RequestBuilder($client, $mapper, new ReqEndpoint(), 'secret'))
        ->inn('7707083893')
        ->asArray()
        ->get();

    expect($result)->toBe(['inn' => '7707083893']);
});

it('возвращает dto в режиме asDto', function (): void {
    $client = new class () implements ClientInterface {
        public function request(string $method, string $uri, array $options = []): ResponseInterface
        {
            return new Response(200, ['Content-Type' => 'application/json'], '{"inn":"7707083893"}');
        }
    };

    $mapper = new ResponseMapper();

    $result = (new RequestBuilder($client, $mapper, new ReqEndpoint(), 'secret'))
        ->inn('7707083893')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(\Ex3mm\KonturFocus\DTOs\CollectionResponse::class)
        ->and($result->total)->toBe(1)
        ->and($result->items)->toHaveCount(1)
        ->and($result->items[0])->toBeInstanceOf(ReqResponseDto::class)
        ->and($result->items[0]->inn)->toBe('7707083893')
        ->and($result->raw)->toContain('7707083893');
});

it('не требует inn или ogrn для custom endpoint', function (): void {
    $client = new class () implements ClientInterface {
        public function request(string $method, string $uri, array $options = []): ResponseInterface
        {
            return new Response(200, ['Content-Type' => 'application/json'], '{"ok":true}');
        }
    };

    $mapper = new class () implements ResponseMapperInterface {
        public function map(array $data, string $dtoClass): array|object
        {
            return $data;
        }
    };

    $result = (new RequestBuilder($client, $mapper, new CustomEndpoint('/api3/custom'), 'secret'))
        ->asArray()
        ->get();

    expect($result)->toBe(['ok' => true]);
});

it('выбрасывает EmptyResponseException при пустом результате с throwOnEmpty', function (): void {
    $client = new class () implements ClientInterface {
        public function request(string $method, string $uri, array $options = []): ResponseInterface
        {
            return new Response(200, ['Content-Type' => 'application/json'], '[]');
        }
    };

    $mapper = new ResponseMapper();

    (new RequestBuilder($client, $mapper, new ReqEndpoint(), 'secret'))
        ->inn('7707083893')
        ->asDto()
        ->throwOnEmpty()
        ->get();
})->throws(\Ex3mm\KonturFocus\Exceptions\EmptyResponseException::class, 'API endpoint "/api3/req" вернул пустой результат. Данные не найдены.');

it('не выбрасывает исключение при пустом результате без throwOnEmpty', function (): void {
    $client = new class () implements ClientInterface {
        public function request(string $method, string $uri, array $options = []): ResponseInterface
        {
            return new Response(200, ['Content-Type' => 'application/json'], '[]');
        }
    };

    $mapper = new ResponseMapper();

    $result = (new RequestBuilder($client, $mapper, new ReqEndpoint(), 'secret'))
        ->inn('7707083893')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(\Ex3mm\KonturFocus\DTOs\CollectionResponse::class)
        ->and($result->total)->toBe(0)
        ->and($result->isEmpty())->toBeTrue();
});
