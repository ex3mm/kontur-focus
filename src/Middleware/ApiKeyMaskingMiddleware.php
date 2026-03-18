<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

final class ApiKeyMaskingMiddleware
{
    private const MASK = '***hidden***';

    public static function maskUri(UriInterface $uri): string
    {
        $query = $uri->getQuery();
        if ($query === '') {
            return (string) $uri;
        }

        parse_str($query, $params);
        if (array_key_exists('key', $params)) {
            $params['key'] = self::MASK;
        }

        return (string) $uri->withQuery(http_build_query($params));
    }

    public static function summarizeRequest(RequestInterface $request): string
    {
        return sprintf('%s %s', $request->getMethod(), self::maskUri($request->getUri()));
    }

    public static function generateRequestId(): string
    {
        return bin2hex(random_bytes(8));
    }
}
