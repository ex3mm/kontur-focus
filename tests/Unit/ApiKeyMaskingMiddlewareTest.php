<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Request;
use Ex3mm\KonturFocus\Middleware\ApiKeyMaskingMiddleware;

it('маскирует api ключ в query строке', function (): void {
    $request = new Request('GET', 'https://focus-api.kontur.ru/api3/req?key=very-secret&inn=7707083893');

    $summary = ApiKeyMaskingMiddleware::summarizeRequest($request);

    expect($summary)->toContain('key=%2A%2A%2Ahidden%2A%2A%2A')
        ->and($summary)->not->toContain('very-secret');
});
