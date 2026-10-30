<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ClientInterface;
use Ex3mm\KonturFocus\DTOs\CollectionResponse;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliatedCompanyInfoDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliatedPersonInfoDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliationConnectionDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliationRoleDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliationShareDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliationShareholderShareDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliationStatusDto;
use Ex3mm\KonturFocus\DTOs\Response\CompanyAffiliationsTypes\CompanyAffiliationsTypesResponseDto;
use Ex3mm\KonturFocus\Endpoints\CompanyAffiliationsTypesEndpoint;
use Ex3mm\KonturFocus\KonturFocusManager;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

function companyAffiliationsTypesConfig(): KonturFocusConfig
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

function companyAffiliationsTypesFixture(string $fileName): string
{
    $contents = file_get_contents(__DIR__.'/../Fixtures/companyAffiliationsTypes/'.$fileName);

    if ($contents === false) {
        throw new RuntimeException(sprintf('Fixture "%s" could not be read.', $fileName));
    }

    return $contents;
}

final class CompanyAffiliationsTypesRecordingClient implements ClientInterface
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
function expectCompanyAffiliationsTypesResponse(
    CompanyAffiliationsTypesResponseDto $actual,
    array $expected,
): void {
    expect($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->ogrn)->toBe($expected['ogrn'] ?? null)
        ->and($actual->name)->toBe($expected['name'] ?? null)
        ->and($actual->focusHref)->toBe($expected['focusHref'] ?? null);

    expectCompanyAffiliationStatus($actual->status, $expected['status'] ?? null);
    expectCompanyAffiliationConnections($actual->connections, $expected['connections'] ?? null);
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectCompanyAffiliationStatus(?CompanyAffiliationStatusDto $actual, ?array $expected): void
{
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toBeInstanceOf(CompanyAffiliationStatusDto::class)
        ->and($actual->statusString)->toBe($expected['statusString'] ?? null)
        ->and($actual->code)->toBe($expected['code'] ?? null)
        ->and($actual->reorganizing)->toBe($expected['reorganizing'] ?? null)
        ->and($actual->bankrupting)->toBe($expected['bankrupting'] ?? null)
        ->and($actual->dissolving)->toBe($expected['dissolving'] ?? null)
        ->and($actual->dissolved)->toBe($expected['dissolved'] ?? null)
        ->and($actual->date)->toBe($expected['date'] ?? null);
}

/**
 * @param array<CompanyAffiliationConnectionDto>|null $actual
 * @param array<int, array<string, mixed>>|null $expected
 */
function expectCompanyAffiliationConnections(?array $actual, ?array $expected): void
{
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toHaveCount(count($expected));

    foreach ($expected as $index => $connection) {
        expectCompanyAffiliationConnection($actual[$index], $connection);
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectCompanyAffiliationConnection(
    CompanyAffiliationConnectionDto $actual,
    array $expected,
): void {
    expect($actual->connectionType)->toBe($expected['connectionType'] ?? null)
        ->and($actual->actualityType)->toBe($expected['actualityType'] ?? null);

    expectCompanyAffiliatedCompanyInfo($actual->companyInfo, $expected['companyInfo'] ?? null);
    expectCompanyAffiliatedPersonInfo($actual->personInfo, $expected['personInfo'] ?? null);
    expectCompanyAffiliationShare($actual->founderShare, $expected['founderShare'] ?? null);
    expectCompanyAffiliationShareholderShare($actual->shareholderShare, $expected['shareholderShare'] ?? null);
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectCompanyAffiliatedCompanyInfo(
    ?CompanyAffiliatedCompanyInfoDto $actual,
    ?array $expected,
): void {
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toBeInstanceOf(CompanyAffiliatedCompanyInfoDto::class)
        ->and($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->ogrn)->toBe($expected['ogrn'] ?? null)
        ->and($actual->name)->toBe($expected['name'] ?? null);

    expectCompanyAffiliationRoles($actual->roleInTheConnectedCompany, $expected['roleInTheConnectedCompany'] ?? null);
    expectCompanyAffiliationRoles($actual->roleInTheAuditedCompany, $expected['roleInTheAuditedCompany'] ?? null);
    expectCompanyAffiliationStatus($actual->status, $expected['status'] ?? null);
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectCompanyAffiliatedPersonInfo(
    ?CompanyAffiliatedPersonInfoDto $actual,
    ?array $expected,
): void {
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toBeInstanceOf(CompanyAffiliatedPersonInfoDto::class)
        ->and($actual->inn)->toBe($expected['inn'] ?? null)
        ->and($actual->fio)->toBe($expected['fio'] ?? null);

    expectCompanyAffiliationRoles($actual->roleInTheConnectedCompany, $expected['roleInTheConnectedCompany'] ?? null);
    expectCompanyAffiliationRoles($actual->roleInTheAuditedCompany, $expected['roleInTheAuditedCompany'] ?? null);
}

/**
 * @param array<CompanyAffiliationRoleDto>|null $actual
 * @param array<int, array<string, mixed>>|null $expected
 */
function expectCompanyAffiliationRoles(?array $actual, ?array $expected): void
{
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    expect($actual)->toHaveCount(count($expected));

    foreach ($expected as $index => $role) {
        expectCompanyAffiliationRole($actual[$index], $role);
    }
}

/**
 * @param array<string, mixed> $expected
 */
function expectCompanyAffiliationRole(CompanyAffiliationRoleDto $actual, array $expected): void
{
    expect($actual->roleType)->toBe($expected['roleType'] ?? null)
        ->and($actual->actualityType)->toBe($expected['actualityType'] ?? null);

    expectCompanyAffiliationShare($actual->founderShare, $expected['founderShare'] ?? null);
    expectCompanyAffiliationShareholderShare($actual->shareholderShare, $expected['shareholderShare'] ?? null);
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectCompanyAffiliationShare(?CompanyAffiliationShareDto $actual, ?array $expected): void
{
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    $sum = $expected['sum'] ?? null;
    $percentagePlain = $expected['percentagePlain'] ?? null;

    expect($actual)->toBeInstanceOf(CompanyAffiliationShareDto::class)
        ->and($actual->sum)->toBe($sum === null ? null : (float) $sum)
        ->and($actual->percentagePlain)->toBe($percentagePlain === null ? null : (float) $percentagePlain)
        ->and($actual->percentageNominator)->toBe($expected['percentageNominator'] ?? null)
        ->and($actual->percentageDenominator)->toBe($expected['percentageDenominator'] ?? null);
}

/**
 * @param array<string, mixed>|null $expected
 */
function expectCompanyAffiliationShareholderShare(
    ?CompanyAffiliationShareholderShareDto $actual,
    ?array $expected,
): void {
    if ($expected === null) {
        expect($actual)->toBeNull();

        return;
    }

    $votingSharesPercent = $expected['votingSharesPercent'] ?? null;
    $capitalSharesPercent = $expected['capitalSharesPercent'] ?? null;

    expect($actual)->toBeInstanceOf(CompanyAffiliationShareholderShareDto::class)
        ->and($actual->votingSharesPercent)->toBe($votingSharesPercent === null ? null : (float) $votingSharesPercent)
        ->and($actual->capitalSharesPercent)->toBe($capitalSharesPercent === null ? null : (float) $capitalSharesPercent);
}

it('маппит каждое поле ближайших связей компаний из реальных fixture', function (string $fileName): void {
    $fixture = companyAffiliationsTypesFixture($fileName);
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = companyAffiliationsTypesConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new CompanyAffiliationsTypesEndpoint(), $config->key))
        ->inn('6663003127')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->raw)->toBe($fixture)
        ->and($result->items)->toHaveCount(count($payload));

    foreach ($payload as $index => $expected) {
        expect($result->items[$index])->toBeInstanceOf(CompanyAffiliationsTypesResponseDto::class);
        expectCompanyAffiliationsTypesResponse($result->items[$index], $expected);
    }
})->with([
    '5036108487.json',
    '6663003127.json',
    '7707083893.json',
]);

it('маппит nullable-поля и все вложенные структуры ближайших связей', function (): void {
    $payload = [
        [
            'inn' => null,
            'ogrn' => null,
            'name' => null,
            'status' => null,
            'focusHref' => null,
            'connections' => null,
        ],
        [
            'inn' => '7700000000',
            'ogrn' => '1027700000000',
            'name' => 'Связанная компания',
            'status' => [
                'statusString' => 'Действующее',
                'code' => '001',
                'reorganizing' => false,
                'bankrupting' => false,
                'dissolving' => false,
                'dissolved' => false,
                'date' => '2026-01-01',
            ],
            'focusHref' => 'https://focus.kontur.ru/entity?query=1027700000000',
            'connections' => [[
                'connectionType' => 'Founder',
                'actualityType' => 'Actual',
                'companyInfo' => [
                    'inn' => '7700000001',
                    'roleInTheConnectedCompany' => [[
                        'roleType' => 'Founder',
                        'founderShare' => [
                            'sum' => 50000,
                            'percentagePlain' => 50,
                            'percentageNominator' => 1,
                            'percentageDenominator' => 2,
                        ],
                        'shareholderShare' => [
                            'votingSharesPercent' => 25.5,
                            'capitalSharesPercent' => 20,
                        ],
                        'actualityType' => 'Historical',
                    ]],
                    'roleInTheAuditedCompany' => [],
                    'ogrn' => '1027700000001',
                    'name' => 'Компания-посредник',
                    'status' => [
                        'statusString' => 'В стадии ликвидации',
                        'code' => '002',
                        'reorganizing' => true,
                        'bankrupting' => true,
                        'dissolving' => true,
                        'dissolved' => true,
                        'date' => '2025-12-31',
                    ],
                ],
                'personInfo' => [
                    'inn' => '770000000002',
                    'roleInTheConnectedCompany' => [],
                    'roleInTheAuditedCompany' => [[
                        'roleType' => 'Manager',
                        'founderShare' => null,
                        'shareholderShare' => null,
                        'actualityType' => 'Actual',
                    ]],
                    'fio' => 'Иванов Иван Иванович',
                ],
                'founderShare' => [
                    'sum' => 100000,
                    'percentagePlain' => 75.5,
                    'percentageNominator' => 3,
                    'percentageDenominator' => 4,
                ],
                'shareholderShare' => [
                    'votingSharesPercent' => 99.9,
                    'capitalSharesPercent' => 88.8,
                ],
            ]],
        ],
    ];
    $fixture = json_encode($payload, JSON_THROW_ON_ERROR);

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = companyAffiliationsTypesConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new CompanyAffiliationsTypesEndpoint(), $config->key))
        ->inn('7700000000')
        ->asDto()
        ->get();

    expect($result->items)->toHaveCount(2);
    expectCompanyAffiliationsTypesResponse($result->items[0], $payload[0]);
    expectCompanyAffiliationsTypesResponse($result->items[1], $payload[1]);
});

it('передаёт параметры пагинации и типа связи fluent-запросом', function (): void {
    $fixture = companyAffiliationsTypesFixture('6663003127.json');
    $payload = json_decode($fixture, true, 512, JSON_THROW_ON_ERROR);
    $client = new CompanyAffiliationsTypesRecordingClient($fixture);
    $manager = new KonturFocusManager(companyAffiliationsTypesConfig(), client: $client);

    $result = $manager->companyAffiliationsTypes()
        ->inn('6663003127')
        ->param('skip', 100)
        ->param('take', 50)
        ->param('affiliationType', 2)
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($client->requests)->toHaveCount(1)
        ->and($client->requests[0]['method'])->toBe('GET')
        ->and($client->requests[0]['uri'])->toBe('/api3/companyAffiliationsTypes')
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => '6663003127',
            'skip' => 100,
            'take' => 50,
            'affiliationType' => 2,
        ])
        ->and($result->items)->toHaveCount(count($payload));
});

it('передаёт ИНН, ОГРН, пагинацию и тип связи convenience-методом менеджера', function (): void {
    $fixture = companyAffiliationsTypesFixture('6663003127.json');
    $client = new CompanyAffiliationsTypesRecordingClient($fixture);
    $manager = new KonturFocusManager(companyAffiliationsTypesConfig(), client: $client);

    $result = $manager->getCompanyAffiliationsTypes('6663003127', '1026605606620', 100, 25, 2);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->items)->toHaveCount(28)
        ->and($client->requests[0]['options']['query'])->toBe([
            'key' => 'test-key',
            'inn' => '6663003127',
            'ogrn' => '1026605606620',
            'skip' => 100,
            'take' => 25,
            'affiliationType' => 2,
        ]);
});
