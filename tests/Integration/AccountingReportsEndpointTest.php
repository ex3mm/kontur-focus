<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Client\KonturFocusClient;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Endpoints\AccountingReportsEndpoint;
use Ex3mm\KonturFocus\Exceptions\NotFoundException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Ex3mm\KonturFocus\Requests\RequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

function accountingReportsConfig(array $override = []): KonturFocusConfig
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

it('возвращает бухгалтерские формы для корректного ответа', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/accounting_reports_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = accountingReportsConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new AccountingReportsEndpoint(), $config->key))
        ->inn('4908000718')
        ->asDto()
        ->get();

    expect($result)->toBeInstanceOf(\Ex3mm\KonturFocus\DTOs\CollectionResponse::class)
        ->and($result->items)->toBeArray()->toHaveCount(1)
        ->and($result->items[0]->inn)->toBe('4908000718')
        ->and($result->items[0]->ogrn)->toBe('1024900959467')
        ->and($result->items[0]->focusHref)->toBe('https://focus.kontur.ru/entity?query=1024900959467')
        ->and($result->items[0]->buhForms)->toBeArray()->not->toBeEmpty();
});

it('корректно маппит бухгалтерские формы по годам', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/accounting_reports_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = accountingReportsConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new AccountingReportsEndpoint(), $config->key))
        ->inn('4908000718')
        ->asDto()
        ->get();

    $firstYear = $result->items[0]->buhForms[0];

    expect($firstYear->year)->toBe(2017)
        ->and($firstYear->organizationType)->toBe('Large')
        ->and($firstYear->form1)->toBeArray()->not->toBeEmpty()
        ->and($firstYear->form1[0]->code)->toBe(1100)
        ->and($firstYear->form1[0]->name)->toBe('Итого')
        ->and($firstYear->form1[0]->startValue)->toBe(16324576000)
        ->and($firstYear->form1[0]->endValue)->toBe(16286835000)
        ->and($firstYear->form2[0]->code)->toBe(2100)
        ->and($firstYear->form2[0]->name)->toBe('Валовая прибыль (убыток)');
});

it('корректно маппит форму 3 с составной частью капитала', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/accounting_reports_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = accountingReportsConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new AccountingReportsEndpoint(), $config->key))
        ->inn('4908000718')
        ->asDto()
        ->get();

    $form3 = $result->items[0]->buhForms[0]->form3;

    expect($form3)->toBeArray()->not->toBeEmpty()
        ->and($form3[0]->code)->toBe(3300)
        ->and($form3[0]->capitalPortion)->toBeNull()
        ->and($form3[1]->capitalPortion)->toBe('Нераспределенная прибыль (непокрытый убыток)');
});

it('корректно маппит формы 4 и 6', function (): void {
    $fixture = file_get_contents(__DIR__.'/../Fixtures/accounting_reports_response.json');

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $fixture),
    ]);

    $config = accountingReportsConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new AccountingReportsEndpoint(), $config->key))
        ->inn('4908000718')
        ->asDto()
        ->get();

    $firstYear = $result->items[0]->buhForms[0];

    expect($firstYear->form4[0]->code)->toBe(4100)
        ->and($firstYear->form4[0]->endValue)->toBe(257584000)
        ->and($firstYear->form6[0]->code)->toBe(6100)
        ->and($firstYear->form6[0]->name)->toBe('Остаток средств на начало периода');
});

it('возвращает пустой массив form6 если форма отсутствует в ответе', function (): void {
    $json = '[{"inn":"4908000718","ogrn":"1024900959467","buhForms":[{"year":2020,"organizationType":"Large","form1":[],"form2":[],"form3":[],"form4":[],"form6":[]}]}]';

    $mock = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], $json),
    ]);

    $config = accountingReportsConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    $result = (new RequestBuilder($client, new ResponseMapper(), new AccountingReportsEndpoint(), $config->key))
        ->inn('4908000718')
        ->asDto()
        ->get();

    expect($result->items[0]->buhForms[0]->form6)->toBeArray()->toBeEmpty();
});

it('выбрасывает NotFoundException при ответе 404', function (): void {
    $mock = new MockHandler([
        new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
    ]);

    $config = accountingReportsConfig();
    $client = new KonturFocusClient($config, new GuzzleClientFactory(handler: $mock));

    (new RequestBuilder($client, new ResponseMapper(), new AccountingReportsEndpoint(), $config->key))
        ->inn('4908000718')
        ->asArray()
        ->get();
})->throws(NotFoundException::class);
