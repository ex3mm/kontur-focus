<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\DTOs\CollectionResponse;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchaseContractInfoDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchaseCustomerDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchaseDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchaseObjectDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchaseParticipantDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchasePriceDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchaseProductCodeDto;
use Ex3mm\KonturFocus\DTOs\Response\PurchasesOfParticipant\PurchasesOfParticipantResponseDto;
use Ex3mm\KonturFocus\Endpoints\PurchasesOfParticipantEndpoint;
use Ex3mm\KonturFocus\KonturFocusManager;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

function purchasesOfParticipantConfig(): KonturFocusConfig
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

function purchasesOfParticipantFixture(string $fileName): string
{
    $contents = file_get_contents(__DIR__.'/../Fixtures/purchasesOfParticipant/'.$fileName);

    if ($contents === false) {
        throw new RuntimeException(sprintf('Fixture "%s" could not be read.', $fileName));
    }

    return $contents;
}

final class PurchasesOfParticipantRecordingClient implements ClientInterface
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
function expectPurchasesOfParticipantResponse(
    PurchasesOfParticipantResponseDto $actual,
    array $expected,
): void {
    expect($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->ogrn)->toBe($expected['ogrn'] ?? null)
        ->and($actual->focusHref)->toBe($expected['focusHref'] ?? null)
        ->and($actual->purchasesOfParticipant)->toHaveCount(count($expected['purchasesOfParticipant'] ?? []));

    foreach ($expected['purchasesOfParticipant'] ?? [] as $index => $purchase) {
        expectPurchasesOfParticipantPurchase($actual->purchasesOfParticipant[$index], $purchase);
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectPurchasesOfParticipantPurchase(PurchaseDto $actual, array $expected): void
{
    expect($actual->type)->toBe($expected['type'] ?? null)
        ->and($actual->number)->toBe($expected['number'] ?? null)
        ->and($actual->selectionTypeDescription)->toBe($expected['selectionTypeDescription'] ?? null)
        ->and($actual->stateDescription)->toBe($expected['stateDescription'] ?? null)
        ->and($actual->topicDescription)->toBe($expected['topicDescription'] ?? null)
        ->and($actual->publicationDate)->toBe($expected['publicationDate'] ?? null);

    expectPurchasesOfParticipantPrice($actual->startPrice, $expected['startPrice'] ?? null);

    if (array_key_exists('winnerPrice', $expected)) {
        expectPurchasesOfParticipantPrice($actual->winnerPrice, $expected['winnerPrice']);
    } else {
        expect($actual->winnerPrice)->toBeNull();
    }

    expect($actual->customers)->toHaveCount(count($expected['customers'] ?? []))
        ->and($actual->participants)->toHaveCount(count($expected['participants'] ?? []))
        ->and($actual->purchaseObjects)->toHaveCount(count($expected['purchaseObjects'] ?? []));

    foreach ($expected['customers'] ?? [] as $index => $customer) {
        expectPurchasesOfParticipantCustomer($actual->customers[$index], $customer);
    }

    foreach ($expected['participants'] ?? [] as $index => $participant) {
        expectPurchasesOfParticipantParticipant($actual->participants[$index], $participant);
    }

    expectPurchasesOfParticipantContract($actual->contractInfo, $expected['contractInfo'] ?? null);

    foreach ($expected['purchaseObjects'] ?? [] as $index => $object) {
        expectPurchasesOfParticipantObject($actual->purchaseObjects[$index], $object);
    }
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectPurchasesOfParticipantPrice(?PurchasePriceDto $actual, ?array $expected): void
{
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toBeInstanceOf(PurchasePriceDto::class)
        ->and($actual->sum)->toBe((float) ($expected['sum'] ?? 0))
        ->and($actual->currencyCode)->toBe($expected['currencyCode'] ?? null);
}

/**
 * @param array<string, mixed> $expected
 */
function expectPurchasesOfParticipantCustomer(PurchaseCustomerDto $actual, array $expected): void
{
    expect($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->kpp)->toBe($expected['kpp'] ?? null)
        ->and($actual->name)->toBe($expected['name'] ?? null);
}

/**
 * @param array<string, mixed> $expected
 */
function expectPurchasesOfParticipantParticipant(PurchaseParticipantDto $actual, array $expected): void
{
    expect($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->kpp)->toBe($expected['kpp'] ?? null)
        ->and($actual->name)->toBe($expected['name'] ?? null)
        ->and($actual->isWinner)->toBe($expected['isWinner'] ?? null)
        ->and($actual->hasContract)->toBe($expected['hasContract'] ?? null)
        ->and($actual->isNotAdmitted)->toBe($expected['isNotAdmitted'] ?? null);
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectPurchasesOfParticipantContract(?PurchaseContractInfoDto $actual, ?array $expected): void
{
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toBeInstanceOf(PurchaseContractInfoDto::class)
        ->and($actual->number)->toBe($expected['number'] ?? null)
        ->and($actual->date)->toBe($expected['date'] ?? null)
        ->and($actual->executionDate)->toBe($expected['executionDate'] ?? null)
        ->and($actual->enforcement)->toBe($expected['enforcement'] ?? null)
        ->and($actual->stage)->toBe($expected['stage'] ?? null)
        ->and($actual->canceledReason)->toBe($expected['canceledReason'] ?? null)
        ->and($actual->partiallyExecuted)->toBe($expected['partiallyExecuted'] ?? null);

    expectPurchasesOfParticipantPrice($actual->price, $expected['price'] ?? null);
}

/**
 * @param array<string, mixed> $expected
 */
function expectPurchasesOfParticipantObject(PurchaseObjectDto $actual, array $expected): void
{
    expect($actual->name)->toBe($expected['name'] ?? null);

    foreach (['okdps', 'okpds', 'okpd2s', 'ktrus'] as $codesKey) {
        $expectedCodes = $expected[$codesKey] ?? [];

        expect($actual->{$codesKey})->toHaveCount(count($expectedCodes));

        foreach ($expectedCodes as $index => $code) {
            expectPurchasesOfParticipantCode($actual->{$codesKey}[$index], $code);
        }
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectPurchasesOfParticipantCode(PurchaseProductCodeDto $actual, array $expected): void
{
    expect($actual->code)->toBe($expected['code'] ?? null)
        ->and($actual->name)->toBe($expected['name'] ?? null);
}

it('маппит каждое поле закупок участника из fixture', function (string $fileName): void {
    $fixture = purchasesOfParticipantFixture($fileName);
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = purchasesOfParticipantConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new PurchasesOfParticipantEndpoint(), $config->key))
        ->inn($payload[0]['inn'])
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->raw)->toBe($fixture)
        ->and($result->items)->toHaveCount(count($payload));

    foreach ($payload as $index => $expected) {
        expect($result->items[$index])->toBeInstanceOf(PurchasesOfParticipantResponseDto::class);
        expectPurchasesOfParticipantResponse($result->items[$index], $expected);
    }
})->with([
    '5036108487.json',
    '7704305026.json',
    '7813654242.json',
]);

it('маппит все optional-поля схемы purchasesOfParticipant', function (): void {
    $fixture = purchasesOfParticipantFixture('7813654242.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $payload[0]['purchasesOfParticipant'][] = [
        'type' => '44-ФЗ',
        'number' => 'optional-fields',
        'selectionTypeDescription' => 'Электронный аукцион',
        'stateDescription' => 'Контракт заключен',
        'topicDescription' => 'Тестовая закупка',
        'publicationDate' => '2026-01-01',
        'startPrice' => ['sum' => 100, 'currencyCode' => 'RUB'],
        'winnerPrice' => ['sum' => 90, 'currencyCode' => 'RUB'],
        'customers' => [['inn' => '7700000000', 'kpp' => '770001001', 'name' => 'Заказчик']],
        'participants' => [[
            'inn' => '7700000001',
            'kpp' => '770001002',
            'name' => 'Участник',
            'isWinner' => false,
            'hasContract' => false,
            'isNotAdmitted' => true,
        ]],
        'contractInfo' => [
            'price' => ['sum' => 90, 'currencyCode' => 'RUB'],
            'number' => 'contract-number',
            'date' => '2026-01-02',
            'executionDate' => '2026-12-31',
            'enforcement' => 'cashAccount',
            'stage' => 'Исполнение',
            'canceledReason' => 'Тестовая причина',
            'partiallyExecuted' => false,
        ],
        'purchaseObjects' => [[
            'name' => 'Объект закупки',
            'okdps' => [['code' => '01.01', 'name' => 'ОКДП']],
            'okpds' => [['code' => '01.01.01', 'name' => 'ОКПД']],
            'okpd2s' => [['code' => '01.01.01.001', 'name' => 'ОКПД2']],
            'ktrus' => [['code' => '12345678', 'name' => 'КТРУ']],
        ]],
    ];

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], json_encode($payload, JSON_THROW_ON_ERROR)),
    ]);

    $config = purchasesOfParticipantConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new PurchasesOfParticipantEndpoint(), $config->key))
        ->inn($payload[0]['inn'])
        ->asDto()
        ->get();

    expectPurchasesOfParticipantResponse($result->items[0], $payload[0]);
});

it('передаёт параметры пагинации fluent-запросом', function (): void {
    $fixture = purchasesOfParticipantFixture('5036108487.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new PurchasesOfParticipantRecordingClient($fixture);
    $manager = new KonturFocusManager(purchasesOfParticipantConfig(), client: $client);

    $result = $manager->purchasesOfParticipant()
        ->inn($payload[0]['inn'])
        ->param('skip', 100)
        ->param('take', 50)
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($client->requests)->toHaveCount(1)
        ->and($client->requests[0]['method'])->toBe('GET')
        ->and($client->requests[0]['uri'])->toBe('/api3/purchasesOfParticipant')
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => $payload[0]['inn'],
            'skip' => 100,
            'take' => 50,
        ]);
});

it('передаёт ИНН и пагинацию convenience-методом менеджера', function (): void {
    $fixture = purchasesOfParticipantFixture('7813654242.json');
    $client = new PurchasesOfParticipantRecordingClient($fixture);
    $manager = new KonturFocusManager(purchasesOfParticipantConfig(), client: $client);

    $result = $manager->getPurchasesOfParticipant('7813654242', take: 25);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(1)
        ->and($result->items[0]->purchasesOfParticipant)->toBeEmpty()
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => '7813654242',
            'take' => 25,
        ]);
});
