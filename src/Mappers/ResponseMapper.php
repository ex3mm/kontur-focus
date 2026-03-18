<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Mappers;

use Ex3mm\KonturFocus\Contracts\ResponseMapperInterface;
use Ex3mm\KonturFocus\DTOs\Attributes\ArrayOf;
use Ex3mm\KonturFocus\Exceptions\DtoMappingException;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

final class ResponseMapper implements ResponseMapperInterface
{
    public function map(array $data, string $dtoClass): array|object
    {
        if (!class_exists($dtoClass)) {
            throw new DtoMappingException(sprintf('DTO class "%s" does not exist.', $dtoClass));
        }

        if (array_is_list($data)) {
            $items = [];

            foreach ($data as $index => $item) {
                if (!is_array($item)) {
                    throw DtoMappingException::invalidType(
                        sprintf('root[%d]', $index),
                        'array',
                        gettype($item),
                    );
                }

                $items[] = $this->mapObject($item, $dtoClass, sprintf('root[%d]', $index));
            }

            return $items;
        }

        return $this->mapObject($data, $dtoClass, 'root');
    }

    /**
     * @param array<mixed> $payload
     * @param class-string $dtoClass
     */
    private function mapObject(array $payload, string $dtoClass, string $path): object
    {
        $reflection = new ReflectionClass($dtoClass);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $arguments = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $parameterPath = $path.'.'.$name;

            if (array_key_exists($name, $payload)) {
                $value = $payload[$name];
                $arguments[] = $this->mapParameterValue($reflection, $parameter, $value, $parameterPath);
                continue;
            }

            if ($this->canInjectWholePayload($parameters, $parameter)) {
                $arguments[] = $payload;
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
                continue;
            }

            if ($parameter->allowsNull()) {
                $arguments[] = null;
                continue;
            }

            throw DtoMappingException::missingField($parameterPath);
        }

        /** @var object */
        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * @param array<ReflectionParameter> $parameters
     */
    private function canInjectWholePayload(array $parameters, ReflectionParameter $parameter): bool
    {
        $type = $parameter->getType();
        if (!$type instanceof ReflectionNamedType || $type->getName() !== 'array') {
            return false;
        }

        return count($parameters) === 1 && $parameter->getName() === 'payload';
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function mapParameterValue(ReflectionClass $reflection, ReflectionParameter $parameter, mixed $value, string $path): mixed
    {
        $type = $parameter->getType();
        if ($type === null) {
            return $value;
        }

        if ($type instanceof ReflectionUnionType) {
            return $this->mapUnionType($reflection, $parameter, $value, $type, $path);
        }

        if (!$type instanceof ReflectionNamedType) {
            return $value;
        }

        return $this->mapNamedType($reflection, $parameter, $value, $type, $path);
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function mapUnionType(
        ReflectionClass $reflection,
        ReflectionParameter $parameter,
        mixed $value,
        ReflectionUnionType $type,
        string $path,
    ): mixed {
        if ($value === null && $type->allowsNull()) {
            return null;
        }

        foreach ($type->getTypes() as $unionType) {
            if (!$unionType instanceof ReflectionNamedType) {
                continue;
            }

            if ($unionType->getName() === 'null') {
                continue;
            }

            try {
                return $this->mapNamedType($reflection, $parameter, $value, $unionType, $path);
            } catch (DtoMappingException) {
                // Пробуем следующий тип в union.
            }
        }

        $expectedParts = [];
        foreach ($type->getTypes() as $unionType) {
            if ($unionType instanceof ReflectionNamedType) {
                $expectedParts[] = $unionType->getName();
                continue;
            }

            if ($unionType instanceof ReflectionIntersectionType) {
                $intersectionNames = [];
                foreach ($unionType->getTypes() as $intersectionType) {
                    if ($intersectionType instanceof ReflectionNamedType) {
                        $intersectionNames[] = $intersectionType->getName();
                    }
                }

                if ($intersectionNames !== []) {
                    $expectedParts[] = implode('&', $intersectionNames);
                }
            }
        }

        $expected = implode('|', $expectedParts);

        throw DtoMappingException::invalidType($path, $expected, gettype($value));
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function mapNamedType(
        ReflectionClass $reflection,
        ReflectionParameter $parameter,
        mixed $value,
        ReflectionNamedType $type,
        string $path,
    ): mixed {
        $typeName = $type->getName();

        if ($value === null) {
            if ($type->allowsNull()) {
                return null;
            }

            throw DtoMappingException::invalidType($path, $typeName, 'null');
        }

        if ($type->isBuiltin()) {
            return $this->mapBuiltinType($reflection, $parameter, $value, $typeName, $path);
        }

        if (!is_array($value)) {
            throw DtoMappingException::invalidType($path, 'array', gettype($value));
        }

        if (!class_exists($typeName)) {
            throw DtoMappingException::invalidType($path, 'class-string', $typeName);
        }

        /** @var class-string $typeName */
        return $this->mapObject($value, $typeName, $path);
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function mapBuiltinType(
        ReflectionClass $reflection,
        ReflectionParameter $parameter,
        mixed $value,
        string $typeName,
        string $path,
    ): mixed {
        return match ($typeName) {
            'string' => $this->assertAndReturn($value, 'string', is_string($value), $path),
            'int' => $this->assertAndReturn($value, 'int', is_int($value), $path),
            'float' => $this->assertAndReturn($value, 'float', is_float($value) || is_int($value), $path),
            'bool' => $this->assertAndReturn($value, 'bool', is_bool($value), $path),
            'array' => $this->mapArrayType($reflection, $parameter, $value, $path),
            'mixed' => $value,
            default => $value,
        };
    }

    /**
     * @param ReflectionClass<object> $reflection
     * @return array<int|string, mixed>
     */
    private function mapArrayType(
        ReflectionClass $reflection,
        ReflectionParameter $parameter,
        mixed $value,
        string $path,
    ): array {
        if (!is_array($value)) {
            throw DtoMappingException::invalidType($path, 'array', gettype($value));
        }

        $arrayOf = $this->resolveArrayOf($reflection, $parameter);
        if ($arrayOf === null) {
            throw DtoMappingException::invalidArrayElementType($path);
        }

        $result = [];
        foreach ($value as $index => $item) {
            $itemPath = sprintf('%s[%s]', $path, (string) $index);

            if ($arrayOf->isScalar()) {
                $result[$index] = $this->mapScalarArrayElement($arrayOf->type, $item, $itemPath);
                continue;
            }

            if (!is_array($item)) {
                throw DtoMappingException::invalidType($itemPath, 'array', gettype($item));
            }

            if (!class_exists($arrayOf->type)) {
                throw DtoMappingException::invalidType($itemPath, 'class-string', $arrayOf->type);
            }

            /** @var class-string $dtoClass */
            $dtoClass = $arrayOf->type;

            $result[$index] = $this->mapObject($item, $dtoClass, $itemPath);
        }

        return $result;
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function resolveArrayOf(ReflectionClass $reflection, ReflectionParameter $parameter): ?ArrayOf
    {
        $parameterAttributes = $parameter->getAttributes(ArrayOf::class);
        if ($parameterAttributes !== []) {
            return $parameterAttributes[0]->newInstance();
        }

        if ($reflection->hasProperty($parameter->getName())) {
            $property = $reflection->getProperty($parameter->getName());
            $propertyAttributes = $property->getAttributes(ArrayOf::class);
            if ($propertyAttributes !== []) {
                return $propertyAttributes[0]->newInstance();
            }
        }

        return null;
    }

    private function mapScalarArrayElement(string $type, mixed $value, string $path): string|int|float|bool
    {
        if ($type === 'string') {
            if (!is_string($value)) {
                throw DtoMappingException::invalidType($path, 'string', gettype($value));
            }

            return $value;
        }

        if ($type === 'int') {
            if (!is_int($value)) {
                throw DtoMappingException::invalidType($path, 'int', gettype($value));
            }

            return $value;
        }

        if ($type === 'float') {
            if (!is_float($value) && !is_int($value)) {
                throw DtoMappingException::invalidType($path, 'float', gettype($value));
            }

            return (float) $value;
        }

        if ($type === 'bool') {
            if (!is_bool($value)) {
                throw DtoMappingException::invalidType($path, 'bool', gettype($value));
            }

            return $value;
        }

        throw DtoMappingException::invalidType($path, 'scalar('.$type.')', gettype($value));
    }

    private function assertAndReturn(mixed $value, string $expected, bool $ok, string $path): mixed
    {
        if (!$ok) {
            throw DtoMappingException::invalidType($path, $expected, gettype($value));
        }

        return $value;
    }
}
