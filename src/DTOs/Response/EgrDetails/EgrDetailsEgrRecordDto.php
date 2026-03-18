<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsEgrRecordDto
{
    /**
 * @param array<EgrDetailsDefinitionEgrRecordDocumentsItemDto>|null $documents
 * @param array<EgrDetailsDefinitionEgrRecordCertificatesItemDto>|null $certificates
 */
    public function __construct(
        /** ГРН записи */
        public ?string $grn = null,
        /** Дата внесения записи */
        public ?string $date = null,
        /** Причина внесения записи */
        public ?string $name = null,
        /** Признак недействительности записи */
        public ?bool $isInvalid = null,
        /** Дата, когда запись стала недействительной */
        public ?string $invalidSince = null,
        /** Имя регистрирующего органа, который внес запись */
        public ?string $regName = null,
        /** Код регистрирующего органа, который внес запись */
        public ?string $regCode = null,
        #[ArrayOf(EgrDetailsDefinitionEgrRecordDocumentsItemDto::class)]
        /** @var array<EgrDetailsDefinitionEgrRecordDocumentsItemDto>|null Документы, представленные при внесении записи */
        public ?array $documents = null,
        #[ArrayOf(EgrDetailsDefinitionEgrRecordCertificatesItemDto::class)]
        /** @var array<EgrDetailsDefinitionEgrRecordCertificatesItemDto>|null Свидетельства, подтверждающие факт внесения записи */
        public ?array $certificates = null,
    ) {
    }
}
