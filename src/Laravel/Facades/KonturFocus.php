<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Laravel\Facades;

use Ex3mm\KonturFocus\Contracts\RequestBuilderInterface;
use Illuminate\Support\Facades\Facade;

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
 * @method static RequestBuilderInterface personBankruptcy()
 * @method static RequestBuilderInterface licenses()
 * @method static RequestBuilderInterface beneficiary()
 * @method static RequestBuilderInterface accountingReports()
 * @method static RequestBuilderInterface custom(string $endpoint)
 *
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getReq(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getEgrDetails(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getLegalAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getBankruptcyAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getCourtAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getFinanceAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getFsspAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getLinkAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getPurchasesAnalytics(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getPersonBankruptcy(?string $inn = null, ?string $fio = null, ?string $birthDate = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getLicenses(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getBeneficiary(?string $inn = null, ?string $ogrn = null)
 * @method static \Ex3mm\KonturFocus\DTOs\CollectionResponse<object> getAccountingReports(?string $inn = null, ?string $ogrn = null)
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
