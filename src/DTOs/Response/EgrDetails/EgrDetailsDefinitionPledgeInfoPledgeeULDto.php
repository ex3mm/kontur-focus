<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsDefinitionPledgeInfoPledgeeULDto
{
    public function __construct(
        /** Краткое наименование юридического лица */
        public ?string $name = null,
        /** ОГРН */
        public ?string $ogrn = null,
        /** ИНН */
        public ?string $inn = null,
        /** Сведения о нотариальном удостоверении договора залога */
        public ?EgrDetailsNotarizationDto $notarization = null,
    ) {
    }
}
