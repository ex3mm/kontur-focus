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
 * @method static RequestBuilderInterface beneficiary()
 * @method static RequestBuilderInterface custom(string $endpoint)
 *
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getReq(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getEgrDetails(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getLegalAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getBankruptcyAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getCourtAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getFinanceAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getFsspAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getLinkAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getPurchasesAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getLicenses(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse getBeneficiary(?string $inn = null, ?string $ogrn = null)
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
