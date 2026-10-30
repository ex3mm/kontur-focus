<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PetitionersOfArbitration;

/**
 * Статистика по истцу в арбитражных делах.
 */
final readonly class PetitionerDto
{
    public function __construct(
        /** ОГРН(ИП) истца */
        public ?string $ogrn = null,
        /** ИНН(ИП) истца */
        public ?string $inn = null,
        /** Краткое наименование юридического лица или ФИО */
        public ?string $name = null,
        /** Основной вид деятельности */
        public ?PrincipalActivityDto $principalActivity = null,
        /** Оценка количества дел за 3 года */
        public ?int $y3Count = null,
        /** Оценка исковой суммы за 3 последних года в рублях */
        public ?float $y3Sum = null,
        /** Дата последнего дела */
        public ?string $lastCaseDate = null,
    ) {
    }
}
