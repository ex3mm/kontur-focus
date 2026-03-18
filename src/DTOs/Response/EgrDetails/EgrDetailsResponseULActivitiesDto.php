<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\EgrDetails;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;

/**
 * DTO сгенерирован из docs/endpoints/egrDetails/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class EgrDetailsResponseULActivitiesDto
{
    /**
 * @param array<EgrDetailsActivityDto>|null $complementaryActivities
 */
    public function __construct(
        /** Основной вид деятельности */
        public ?EgrDetailsActivityDto $principalActivity = null,
        #[ArrayOf(EgrDetailsActivityDto::class)]
        /** @var array<EgrDetailsActivityDto>|null Дополнительные виды деятельности */
        public ?array $complementaryActivities = null,
        /** Версия справочника ОКВЭД. Значение "2" соответствует ОК 029-2014 (КДЕС Ред. 2), отсутствие поля версии соответствует ОК 029-2001 (КДЕС Ред.1) */
        public ?string $okvedVersion = null,
    ) {
    }
}
