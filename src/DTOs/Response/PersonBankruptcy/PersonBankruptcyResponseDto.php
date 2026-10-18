<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy;

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;
use Ex3mm\KonturFocus\DTOs\Attributes\MapFrom;
use Ex3mm\KonturFocus\DTOs\Concerns\HasRawResponse;
use LogicException;

/**
 * DTO сгенерирован из docs/endpoints/personBankruptcy/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class PersonBankruptcyResponseDto
{
    use HasRawResponse;

    /**
     * @param string|null                                                                       $inn
     * @param string|null                                                                       $fio
     * @param string|null                                                                       $birthDate
     * @param string|null                                                                       $snils
     * @param string|null                                                                       $address
     * @param string|null                                                                       $stage
     * @param string|null                                                                       $stageDate
     * @param string|null                                                                       $caseNumber
     * @param string|null                                                                       $lastMessageDate
     * @param \Ex3mm\KonturFocus\DTOs\Response\PersonBankruptcy\ExtrajudicialBankruptcyDto|null $extrajudicialBankruptcy
     * @param ArbitrationManagerDto|null                                                        $arbitrationManager
     * @param array<BankruptcyStageDto>                                                         $stages
     * @param array<BankruptcyMessageDto>                                                       $messages
     * @param string|null                                                                       $raw
     */
    public function __construct(
        /** ИННФЛ */
        public ?string $inn = null,
        /** ФИО */
        public ?string $fio = null,
        /** Дата рождения */
        public ?string $birthDate = null,
        /** СНИЛС */
        public ?string $snils = null,
        /** Место жительства */
        public ?string $address = null,
        /** Текущая стадия банкротства */
        public ?string $stage = null,
        /** Дата решения суда о введении текущей стадии банкротства */
        public ?string $stageDate = null,
        /** Номер арбитражного дела о банкротстве */
        public ?string $caseNumber = null,
        /** Дата последнего сообщения в Едином федеральном реестре сведений о банкротстве */
        public ?string $lastMessageDate = null,
        /** Детали внесудебного банкротства */
        public ?ExtrajudicialBankruptcyDto $extrajudicialBankruptcy = null,
        /** Арбитражный управляющий */
        #[MapFrom('arbitrManager')]
        public ?ArbitrationManagerDto $arbitrationManager = null,
        /** Стадии банкротства или статусы внесудебного банкротства */
        #[ArrayOf(BankruptcyStageDto::class)]
        public array $stages = [],
        /** Сообщения о банкротстве */
        #[ArrayOf(BankruptcyMessageDto::class)]
        public array $messages = [],
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
            fio: $this->fio,
            birthDate: $this->birthDate,
            snils: $this->snils,
            address: $this->address,
            stage: $this->stage,
            stageDate: $this->stageDate,
            caseNumber: $this->caseNumber,
            lastMessageDate: $this->lastMessageDate,
            extrajudicialBankruptcy: $this->extrajudicialBankruptcy,
            arbitrationManager: $this->arbitrationManager,
            stages: $this->stages,
            messages: $this->messages,
            raw: $raw,
        );
    }
}
