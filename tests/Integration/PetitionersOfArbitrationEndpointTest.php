<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\DTOs\CollectionResponse;
use Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration\PetitionerDto;
use Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration\PetitionersOfArbitrationResponseDto;
use Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration\PrincipalActivityDto;
use Ex3mm\KonturFocus\Endpoints\PetitionersOfArbitrationEndpoint;
use Ex3mm\KonturFocus\KonturFocusManager;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

function petitionersOfArbitrationConfig(): KonturFocusConfig
{
    return KonturFocusConfig::fromArray([
        'key' => 'test-key',
        'base_url' => 'https://focus-api.kontur.ru',
        'retry' => [
            'enabled' => false,
            'max_attempts' => 1,
            'delay_ms' => 0,
            'multiplier' => 1,
            'max_delay_ms' => 0,
        ],
        'cache' => [
            'enabled' => false,
            'ttl' => 60,
            'store' => 'default',
            'namespace' => 'test',
        ],
    ]);
}

function petitionersOfArbitrationFixture(string $fileName): string
{
    $contents = file_get_contents(__DIR__.'/../Fixtures/petitionersOfArbitration/'.$fileName);

    if ($contents === false) {
        throw new RuntimeException(sprintf('Fixture "%s" could not be read.', $fileName));
    }

    return $contents;
}

final class PetitionersOfArbitrationRecordingClient implements ClientInterface
{
    public function __construct(private readonly string $response)
    {
    }

    /**
     * @var list<array{method: string, uri: string, options: array<string, mixed>}>
     */
    public array $requests = [];

    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        $this->requests[] = [
            'method' => $method,
            'uri' => $uri,
            'options' => $options,
        ];

        return new Response(200, ['Content-Type' => 'application/json'], $this->response);
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectPetitionersOfArbitrationResponse(
    PetitionersOfArbitrationResponseDto $actual,
    array $expected,
): void {
    expect($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->ogrn)->toBe($expected['ogrn'] ?? null)
        ->and($actual->focusHref)->toBe($expected['focusHref'] ?? null);

    if (!array_key_exists('petitioners', $expected) || $expected['petitioners'] === null) {
        expect($actual->petitioners)->toBeNull();

        return;
    }

    expect($actual->petitioners)->toHaveCount(count($expected['petitioners']));

    foreach ($expected['petitioners'] as $index => $petitioner) {
        expectPetitioner($actual->petitioners[$index], $petitioner);
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectPetitioner(PetitionerDto $actual, array $expected): void
{
    expect($actual->ogrn)->toBe($expected['ogrn'] ?? null)
        ->and($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->name)->toBe($expected['name'] ?? null)
        ->and($actual->y3Count)->toBe($expected['y3Count'] ?? null)
        ->and($actual->y3Sum)->toBe($expected['y3Sum'] === null ? null : (float) $expected['y3Sum'])
        ->and($actual->lastCaseDate)->toBe($expected['lastCaseDate'] ?? null);

    $expectedActivity = $expected['principalActivity'] ?? null;
    if ($expectedActivity === null) {
        expect($actual->principalActivity)->toBeNull();

        return;
    }

    expectPrincipalActivity($actual->principalActivity, $expectedActivity);
}

/**
 * @param array<string, mixed> $expected
 */
function expectPrincipalActivity(?PrincipalActivityDto $actual, array $expected): void
{
    expect($actual)->toBeInstanceOf(PrincipalActivityDto::class)
        ->and($actual->code)->toBe($expected['code'] ?? null)
        ->and($actual->text)->toBe($expected['text'] ?? null)
        ->and($actual->isReported)->toBe($expected['isReported'] ?? null)
        ->and($actual->isDeclared)->toBe($expected['isDeclared'] ?? null);
}

it('маппит каждое поле истцов в арбитраже из реальных fixture', function (string $fileName): void {
    $fixture = petitionersOfArbitrationFixture($fileName);
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = petitionersOfArbitrationConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new PetitionersOfArbitrationEndpoint(), $config->key))
        ->inn($payload[0]['inn'])
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->raw)->toBe($fixture)
        ->and($result->items)->toHaveCount(count($payload));

    foreach ($payload as $index => $expected) {
        expect($result->items[$index])->toBeInstanceOf(PetitionersOfArbitrationResponseDto::class);
        expectPetitionersOfArbitrationResponse($result->items[$index], $expected);
    }
})->with([
    '5036108487.json',
    '7704305026.json',
    '7813654242.json',
]);

it('маппит nullable-поля всех вложенных DTO истцов в арбитраже', function (): void {
    $payload = [[
        'inn' => null,
        'ogrn' => null,
        'focusHref' => null,
        'petitioners' => [[
            'ogrn' => null,
            'inn' => null,
            'name' => null,
            'principalActivity' => [
                'code' => null,
                'text' => null,
                'isReported' => null,
                'isDeclared' => null,
            ],
            'y3Count' => null,
            'y3Sum' => null,
            'lastCaseDate' => null,
        ]],
    ]];
    $fixture = json_encode($payload, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = petitionersOfArbitrationConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new PetitionersOfArbitrationEndpoint(), $config->key))
        ->inn('7700000000')
        ->asDto()
        ->get();

    expectPetitionersOfArbitrationResponse($result->items[0], $payload[0]);
});

it('передаёт параметры пагинации fluent-запросом', function (): void {
    $fixture = petitionersOfArbitrationFixture('5036108487.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new PetitionersOfArbitrationRecordingClient($fixture);
    $manager = new KonturFocusManager(petitionersOfArbitrationConfig(), client: $client);

    $result = $manager->petitionersOfArbitration()
        ->inn($payload[0]['inn'])
        ->param('skip', 100)
        ->param('take', 50)
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($client->requests)->toHaveCount(1)
        ->and($client->requests[0]['method'])->toBe('GET')
        ->and($client->requests[0]['uri'])->toBe('/api3/petitionersOfArbitration')
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => $payload[0]['inn'],
            'skip' => 100,
            'take' => 50,
        ]);
});

it('передаёт ОГРН и пагинацию convenience-методом менеджера', function (): void {
    $fixture = petitionersOfArbitrationFixture('7813654242.json');
    $client = new PetitionersOfArbitrationRecordingClient($fixture);
    $manager = new KonturFocusManager(petitionersOfArbitrationConfig(), client: $client);

    $result = $manager->getPetitionersOfArbitration('7813654242', '1217800091190', 100, 25);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(1)
        ->and($result->items[0]->petitioners)->toBeNull()
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => '7813654242',
            'ogrn' => '1217800091190',
            'skip' => 100,
            'take' => 25,
        ]);
});
