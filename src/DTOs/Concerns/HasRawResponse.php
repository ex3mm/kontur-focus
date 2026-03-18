<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\DTOs\Concerns;

trait HasRawResponse
{
    /**
     * Скрывает raw из вывода
     *
     * @return array<string, mixed>
     */
    public function __debugInfo(): array
    {
        $properties = get_object_vars($this);

        // Всегда скрываем raw, так как он теперь в CollectionResponse
        unset($properties['raw']);

        return $properties;
    }
}
