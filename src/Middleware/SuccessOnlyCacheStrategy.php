<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Middleware;

use Kevinrob\GuzzleCache\KeyValueHttpHeader;
use Kevinrob\GuzzleCache\Storage\CacheStorageInterface;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Psr\Http\Message\RequestInterface;

final class SuccessOnlyCacheStrategy extends GreedyCacheStrategy
{
    public function __construct(?CacheStorageInterface $cache = null, int $defaultTtl = 60, ?KeyValueHttpHeader $varyHeaders = null)
    {
        parent::__construct($cache, $defaultTtl, $varyHeaders);

        $this->statusAccepted = array_combine(range(200, 299), range(200, 299));
    }

    protected function getCacheKey(RequestInterface $request, ?KeyValueHttpHeader $varyHeaders = null)
    {
        $uri = $request->getUri();
        parse_str($uri->getQuery(), $params);

        if (array_key_exists('key', $params)) {
            $rawKey = $params['key'];
            if (is_array($rawKey)) {
                $rawKey = implode(',', array_map(self::stringify(...), $rawKey));
            }

            $params['key'] = hash('sha256', self::stringify($rawKey));
        }

        ksort($params);

        $normalizedUri = (string) $uri->withQuery(http_build_query($params));

        if ($varyHeaders === null || $varyHeaders->isEmpty()) {
            return hash('sha256', 'success-only'.$request->getMethod().$normalizedUri);
        }

        $cacheHeaders = [];
        foreach ($varyHeaders as $key => $_value) {
            if (!is_string($key) || $key === '') {
                continue;
            }

            if ($request->hasHeader($key)) {
                $cacheHeaders[$key] = $request->getHeader($key);
            }
        }

        return hash('sha256', 'success-only'.$request->getMethod().$normalizedUri.json_encode($cacheHeaders, JSON_THROW_ON_ERROR));
    }

    private static function stringify(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_bool($value)) {
            return (string) $value;
        }

        return '';
    }
}
