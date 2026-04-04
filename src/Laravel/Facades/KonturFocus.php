<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Ex3mm\KonturFocus\Contracts\RequestBuilderInterface;

/**
 * @method static RequestBuilderInterface req()
 * @method static RequestBuilderInterface egrDetails()
 * @method static RequestBuilderInterface legalAnalytics()
 * @method static RequestBuilderInterface bankruptcyAnalytics()
 * @method static RequestBuilderInterface courtAnalytics()
 * @method static RequestBuilderInterface financeAnalytics()
 * @method static RequestBuilderInterface fsspAnalytics()
 * @method static RequestBuilderInterface linkAnalytics()
 * @method static RequestBuilderInterface purchasesAnalytics()
 * @method static RequestBuilderInterface licenses()
 * @method static RequestBuilderInterface custom(string $endpoint)
 *
 * @see \Ex3mm\KonturFocus\KonturFocusManager
 */
final class KonturFocus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'kontur-focus';
    }
}
