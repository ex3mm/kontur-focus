<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

use Ex3mm\KonturFocus\DTOs\Concerns\HasRawResponse;
use LogicException;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseDto
{
    use HasRawResponse;

    public function __construct(
        /** ИНН(ИП) */
        public ?string $inn = null,
        /** ОГРН(ИП) */
        public ?string $ogrn = null,
        /** Ссылка на карточку юридического лица (ИП) в Контур.Фокусе (для работы требуется подписка на Контур.Фокус и дополнительная авторизация) */
        public ?string $focusHref = null,
        /** Информация о юридическом лице */
        public ?ReqResponseULDto $UL = null,
        /** Информация об индивидуальном предпринимателе */
        public ?ReqResponseIPDto $IP = null,
        /** Экспресс-отчет по контрагенту */
        public ?ReqResponseBriefReportDto $briefReport = null,
        /** Контактные телефоны из Контур.Справочника (для получения контактов требуется отдельная подписка и вызов отдельного метода) */
        public ?ReqResponseContactPhonesDto $contactPhones = null,
        /** Контактные адреса электронной почты (для получения контактов требуется отдельная подписка и вызов отдельного метода) */
        public ?ReqResponseContactEmailsDto $contactEmails = null,
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
            UL: $this->UL,
            IP: $this->IP,
            briefReport: $this->briefReport,
            contactPhones: $this->contactPhones,
            contactEmails: $this->contactEmails,
            raw: $raw,
        );
    }

}
