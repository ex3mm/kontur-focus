<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration;

/**
 * Основной вид деятельности истца.
 */
final readonly class PrincipalActivityDto
{
    public function __construct(
        /** Код вида деятельности */
        public ?string $code = null,
        /** Название вида деятельности */
        public ?string $text = null,
        /** Вид деятельности отчётного типа */
        public ?bool $isReported = null,
        /** Вид деятельности заявительного типа */
        public ?bool $isDeclared = null,
    ) {
    }
}
