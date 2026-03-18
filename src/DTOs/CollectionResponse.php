<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs;

/**
 * Обертка для коллекций DTO с сырым ответом
 *
 * @template T
 */
final readonly class CollectionResponse
{
    /**
     * @param array<T> $items Массив DTO
     * @param string $raw Сырой JSON ответ
     * @param int $total Общее количество элементов
     */
    public function __construct(
        public array $items,
        public string $raw,
        public int $total,
    ) {
    }

    /**
     * @return array<T>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return $this->total;
    }

    public function isEmpty(): bool
    {
        return $this->total === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->total > 0;
    }

    /**
     * Получить первый элемент или null
     *
     * @return T|null
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }
}
