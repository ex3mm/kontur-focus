<?php

declare(strict_types=1);

use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;
use Ex3mm\KonturFocus\Exceptions\DtoMappingException;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;

readonly class MapperChildDto
{
    public function __construct(public string $name)
    {
    }
}

readonly class MapperParentDto
{
    /**
     * @param array<MapperChildDto> $children
     */
    public function __construct(
        #[ArrayOf(MapperChildDto::class)]
        public array $children,
    ) {
    }
}

readonly class MapperBrokenDto
{
    /**
     * @param array<mixed> $items
     */
    public function __construct(public array $items)
    {
    }
}

it('маппит вложенные массивы dto через атрибут ArrayOf', function (): void {
    $mapper = new ResponseMapper();

    $mapped = $mapper->map([
        'children' => [
            ['name' => 'first'],
            ['name' => 'second'],
        ],
    ], MapperParentDto::class);

    expect($mapped)->toBeInstanceOf(MapperParentDto::class)
        ->and($mapped->children[0])->toBeInstanceOf(MapperChildDto::class)
        ->and($mapped->children[1]->name)->toBe('second');
});

it('выбрасывает исключение если массив не помечен ArrayOf', function (): void {
    $mapper = new ResponseMapper();

    $mapper->map([
        'items' => [1, 2, 3],
    ], MapperBrokenDto::class);
})->throws(DtoMappingException::class);

it('маппит корневую коллекцию в список dto', function (): void {
    $mapper = new ResponseMapper();

    $result = $mapper->map([
        ['name' => 'a'],
        ['name' => 'b'],
    ], MapperChildDto::class);

    expect($result)->toBeArray()
        ->and($result[0])->toBeInstanceOf(MapperChildDto::class)
        ->and($result[1]->name)->toBe('b');
});
