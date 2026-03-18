<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\FinanceAnalytics;

use Ex3mm\KonturFocus\DTOs\Concerns\HasRawResponse;
use LogicException;

/**
 * DTO сгенерирован из docs/endpoints/financeAnalytics/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class FinanceAnalyticsResponseDto
{
    use HasRawResponse;

    public function __construct(
        /** ИНН(ИП) */
        public ?string $inn = null,
        /** ОГРН(ИП) */
        public ?string $ogrn = null,
        /** Ссылка на карточку юридического лица (ИП) в Контур.Фокусе (для работы требуется подписка на Контур.Фокус и дополнительная авторизация) */
        public ?string $focusHref = null,
        /** Маркеры автоматической проверки и числовые индикаторы */
        public ?FinanceAnalyticsResponseFinanceAnalyticsDataDto $financeAnalyticsData = null,
        /** Исходный JSON ответа Контур.Фокус. */
        public ?string $raw = null,
    ) {
    }

    public function withRawResponse(string $raw): static
    {
        if ($this->raw !== null) {
            throw new LogicException('Raw response already assigned.');
        }

        return new static(
            inn: $this->inn,
            ogrn: $this->ogrn,
            focusHref: $this->focusHref,
            financeAnalyticsData: $this->financeAnalyticsData,
            raw: $raw,
        );
    }

}
