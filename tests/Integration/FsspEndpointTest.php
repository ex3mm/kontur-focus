<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\DTOs\CollectionResponse;
use Ex3mm\KonturFocus\DTOs\Response\Fssp\FsspDataDto;
use Ex3mm\KonturFocus\DTOs\Response\Fssp\FsspResponseDto;
use Ex3mm\KonturFocus\Endpoints\FsspEndpoint;
use Ex3mm\KonturFocus\KonturFocusManager;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

function fsspConfig(): KonturFocusConfig
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

function fsspFixture(string $fileName): string
{
    $contents = file_get_contents(__DIR__.'/../Fixtures/fssp/'.$fileName);

    if ($contents === false) {
        throw new RuntimeException(sprintf('Fixture "%s" could not be read.', $fileName));
    }

    return $contents;
}

final class FsspRecordingClient implements ClientInterface
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
function expectFsspResponse(FsspResponseDto $actual, array $expected): void
{
    expect($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->ogrn)->toBe($expected['ogrn'] ?? null)
        ->and($actual->updateDate)->toBe($expected['updateDate'] ?? null)
        ->and($actual->focusHref)->toBe($expected['focusHref'] ?? null);

    if (!array_key_exists('fssp', $expected) || $expected['fssp'] === null) {
        expect($actual->fssp)->toBeNull();

        return;
    }

    expect($actual->fssp)->toHaveCount(count($expected['fssp']));

    foreach ($expected['fssp'] as $index => $fssp) {
        expectFsspData($actual->fssp[$index], $fssp);
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectFsspData(FsspDataDto $actual, array $expected): void
{
    expect($actual->officialNum)->toBe($expected['officialNum'] ?? null)
        ->and($actual->officialAggregatedNum)->toBe($expected['officialAggregatedNum'] ?? null)
        ->and($actual->startDate)->toBe($expected['startDate'] ?? null)
        ->and($actual->sum)->toBe(($expected['sum'] ?? null) === null ? null : (float) $expected['sum'])
        ->and($actual->topic)->toBe($expected['topic'] ?? null)
        ->and($actual->executoryDocument)->toBe($expected['executoryDocument'] ?? null)
        ->and($actual->executoryDocumentNumber)->toBe($expected['executoryDocumentNumber'] ?? null)
        ->and($actual->executoryDocumentDate)->toBe($expected['executoryDocumentDate'] ?? null)
        ->and($actual->debtorName)->toBe($expected['debtorName'] ?? null)
        ->and($actual->debtorAddress)->toBe($expected['debtorAddress'] ?? null)
        ->and($actual->returnedToClaimer)->toBe($expected['returnedToClaimer'] ?? null)
        ->and($actual->cancelledBecauseOfBancruptcy)->toBe($expected['cancelledBecauseOfBancruptcy'] ?? null)
        ->and($actual->cancelledBecauseOfDissolvement)->toBe($expected['cancelledBecauseOfDissolvement'] ?? null)
        ->and($actual->cancelDate)->toBe($expected['cancelDate'] ?? null)
        ->and($actual->bailiffDepartment)->toBe($expected['bailiffDepartment'] ?? null)
        ->and($actual->bailiffDepartmentAddress)->toBe($expected['bailiffDepartmentAddress'] ?? null);
}

it('маппит каждое поле исполнительных производств из реальных fixture', function (string $fileName): void {
    $fixture = fsspFixture($fileName);
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = fsspConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new FsspEndpoint(), $config->key))
        ->inn($payload[0]['inn'])
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->raw)->toBe($fixture)
        ->and($result->items)->toHaveCount(count($payload));

    foreach ($payload as $index => $expected) {
        expect($result->items[$index])->toBeInstanceOf(FsspResponseDto::class);
        expectFsspResponse($result->items[$index], $expected);
    }
})->with([
    '5036108487.json',
    '6663003127.json',
    '7707083893.json',
]);

it('маппит nullable-поля ответа и всех полей исполнительного производства', function (): void {
    $payload = [
        [
            'inn' => null,
            'ogrn' => null,
            'updateDate' => null,
            'focusHref' => null,
            'fssp' => null,
        ],
        [
            'inn' => null,
            'ogrn' => null,
            'updateDate' => null,
            'focusHref' => null,
            'fssp' => [[
                'officialNum' => null,
                'officialAggregatedNum' => null,
                'startDate' => null,
                'sum' => null,
                'topic' => null,
                'executoryDocument' => null,
                'executoryDocumentNumber' => null,
                'executoryDocumentDate' => null,
                'debtorName' => null,
                'debtorAddress' => null,
                'returnedToClaimer' => null,
                'cancelledBecauseOfBancruptcy' => null,
                'cancelledBecauseOfDissolvement' => null,
                'cancelDate' => null,
                'bailiffDepartment' => null,
                'bailiffDepartmentAddress' => null,
            ]],
        ],
    ];
    $fixture = json_encode($payload, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = fsspConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new FsspEndpoint(), $config->key))
        ->inn('7700000000')
        ->asDto()
        ->get();

    expect($result->items)->toHaveCount(2);
    expectFsspResponse($result->items[0], $payload[0]);
    expectFsspResponse($result->items[1], $payload[1]);
});

it('передаёт параметр skip fluent-запросом', function (): void {
    $fixture = fsspFixture('6663003127.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new FsspRecordingClient($fixture);
    $manager = new KonturFocusManager(fsspConfig(), client: $client);

    $result = $manager->fssp()
        ->inn($payload[0]['inn'])
        ->param('skip', 1000)
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($client->requests)->toHaveCount(1)
        ->and($client->requests[0]['method'])->toBe('GET')
        ->and($client->requests[0]['uri'])->toBe('/api3/fssp')
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => $payload[0]['inn'],
            'skip' => 1000,
        ]);
});

it('передаёт ОГРН и skip convenience-методом менеджера', function (): void {
    $fixture = fsspFixture('7707083893.json');
    $client = new FsspRecordingClient($fixture);
    $manager = new KonturFocusManager(fsspConfig(), client: $client);

    $result = $manager->getFssp('7707083893', '1027700132195', 1000);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(2)
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => '7707083893',
            'ogrn' => '1027700132195',
            'skip' => 1000,
        ]);
});
