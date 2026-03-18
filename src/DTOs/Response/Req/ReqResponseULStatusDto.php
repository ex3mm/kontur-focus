<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Response\Req;

/**
 * DTO сгенерирован из docs/endpoints/req/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class ReqResponseULStatusDto
{
    public function __construct(
        /** Неформализованное описание статуса */
        public ?string $statusString = null,
        /** В процессе реорганизации (может прекратить деятельность в результате реорганизации) */
        public ?bool $reorganizing = null,
        /** В процессе банкротства по данным ЕГРЮЛ (обращаем внимание, что не все организации, находящиеся в процессе банкротства, имеют банкротный статус) */
        public ?bool $bankrupting = null,
        /** В стадии ликвидации (либо планируется исключение из ЕГРЮЛ) */
        public ?bool $dissolving = null,
        /** Недействующее */
        public ?bool $dissolved = null,
        /** Дата */
        public ?string $date = null,
    ) {
    }
}
