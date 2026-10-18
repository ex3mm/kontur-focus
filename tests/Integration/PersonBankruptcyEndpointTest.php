<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\DTOs\CollectionResponse;
use Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy\ArbitrationManagerDto;
use Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy\BankruptcyMessageDto;
use Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy\BankruptcyStageDto;
use Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy\DecisionDto;
use Ex3mm\KonturFocus\Endpoints\PersonBankruptcyEndpoint;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\KonturFocusManager;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

function personBankruptcyConfig(array $override = []): KonturFocusConfig
{
    $base = [
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
    ];

    return KonturFocusConfig::fromArray(array_replace_recursive($base, $override));
}

function personBankruptcyFixture(string $fileName): string
{
    $contents = file_get_contents(__DIR__.'/../Fixtures/personBankruptcy/'.$fileName);

    if ($contents === false) {
        throw new RuntimeException(sprintf('Fixture "%s" could not be read.', $fileName));
    }

    return $contents;
}

final class PersonBankruptcyRecordingClient implements ClientInterface
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

it('маппит реальный ответ personBankruptcy во вложенные DTO', function (string $fileName): void {
    $fixture = personBankruptcyFixture($fileName);
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = personBankruptcyConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new PersonBankruptcyEndpoint(), $config->key))
        ->param('innfl', $payload[0]['inn'])
        ->param('birthDate', $payload[0]['birthDate'])
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(1)
        ->and($result->raw)->toBe($fixture)
        ->and($result->items[0]->inn)->toBe($payload[0]['inn'])
        ->and($result->items[0]->fio)->toBe($payload[0]['fio'])
        ->and($result->items[0]->birthDate)->toBe($payload[0]['birthDate'])
        ->and($result->items[0]->stage)->toBe($payload[0]['stage'])
        ->and($result->items[0]->caseNumber)->toBe($payload[0]['caseNumber'])
        ->and($result->items[0]->arbitrationManager)->toBeInstanceOf(ArbitrationManagerDto::class)
        ->and($result->items[0]->arbitrationManager->fio)->toBe($payload[0]['arbitrManager']['fio'])
        ->and($result->items[0]->stages)->toHaveCount(count($payload[0]['stages']))
        ->and($result->items[0]->stages[0])->toBeInstanceOf(BankruptcyStageDto::class)
        ->and($result->items[0]->stages[0]->messageId)->toBe($payload[0]['stages'][0]['messageID'])
        ->and($result->items[0]->messages)->toHaveCount(count($payload[0]['messages']))
        ->and($result->items[0]->messages[0])->toBeInstanceOf(BankruptcyMessageDto::class)
        ->and($result->items[0]->messages[0]->messageId)->toBe($payload[0]['messages'][0]['messageID'])
        ->and($result->items[0]->messages[0]->decision)->toBeInstanceOf(DecisionDto::class)
        ->and($result->items[0]->messages[0]->decision->typeId)->toBe($payload[0]['messages'][0]['decision']['typeId'])
        ->and($result->items[0]->messages[1]->decision)->toBeNull()
        ->and($result->items[0]->messages[1]->annulment)->toBeNull()
        ->and($result->items[0]->extrajudicialBankruptcy)->toBeNull();
})->with([
    '261204192602.json',
    '780512327538.json',
]);

it('передаёт данные реального человека convenience-методом менеджера', function (): void {
    $fixture = personBankruptcyFixture('261204192602.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new PersonBankruptcyRecordingClient($fixture);
    $manager = new KonturFocusManager(personBankruptcyConfig(), client: $client);

    $result = $manager->getPersonBankruptcy(
        inn: $payload[0]['inn'],
        fio: $payload[0]['fio'],
        birthDate: $payload[0]['birthDate'],
    );

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($client->requests)->toHaveCount(1)
        ->and($client->requests[0]['method'])->toBe('GET')
        ->and($client->requests[0]['uri'])->toBe('/api3/personBankruptcy')
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'innfl' => $payload[0]['inn'],
            'fio' => $payload[0]['fio'],
            'birthDate' => $payload[0]['birthDate'],
        ]);
});

it('выполняет поиск по ФИО без ИННФЛ', function (): void {
    $fixture = personBankruptcyFixture('261204192602.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new PersonBankruptcyRecordingClient($fixture);
    $manager = new KonturFocusManager(personBankruptcyConfig(), client: $client);

    $result = $manager->getPersonBankruptcy(
        fio: $payload[0]['fio'],
        birthDate: $payload[0]['birthDate'],
    );

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(1)
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'fio' => $payload[0]['fio'],
            'birthDate' => $payload[0]['birthDate'],
        ]);
});

it('выполняет fluent-запрос personBankruptcy с параметрами API', function (): void {
    $fixture = personBankruptcyFixture('261204192602.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new PersonBankruptcyRecordingClient($fixture);
    $manager = new KonturFocusManager(personBankruptcyConfig(), client: $client);

    $result = $manager->personBankruptcy()
        ->param('innfl', $payload[0]['inn'])
        ->param('fio', $payload[0]['fio'])
        ->param('birthDate', $payload[0]['birthDate'])
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(1)
        ->and($result->items[0]->inn)->toBe($payload[0]['inn'])
        ->and($result->items[0]->arbitrationManager->fio)->toBe($payload[0]['arbitrManager']['fio'])
        ->and($client->requests)->toHaveCount(1)
        ->and($client->requests[0]['method'])->toBe('GET')
        ->and($client->requests[0]['uri'])->toBe('/api3/personBankruptcy')
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'innfl' => $payload[0]['inn'],
            'fio' => $payload[0]['fio'],
            'birthDate' => $payload[0]['birthDate'],
        ]);
});

it('возвращает пустую коллекцию для реального пустого ответа', function (): void {
    $fixture = personBankruptcyFixture('682803934993.json');
    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = personBankruptcyConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new PersonBankruptcyEndpoint(), $config->key))
        ->param('innfl', '682803934993')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->raw)->toBe($fixture)
        ->and($result->total)->toBe(0)
        ->and($result->items)->toBeEmpty();
});

it('выбрасывает NotFoundException при ответе 404', function (): void {
    $mock = new MockHandler([
        new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
    ]);

    $config = personBankruptcyConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new PersonBankruptcyEndpoint(), $config->key))
        ->param('fio', 'Иванов Иван Иванович')
        ->asArray()
        ->get();
})->throws(NotFoundException::class);
