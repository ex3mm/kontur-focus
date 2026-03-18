<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Requests;

use Ex3mm\KonturFocus\Contracts\EndpointInterface;
use Ex3mm\KonturFocus\Exceptions\RequestValidationException;

abstract class AbstractRequest
{
    /**
     * @var array<string, string|int|float|bool>
     */
    protected array $params = [];

    protected function __construct(
        protected readonly EndpointInterface $endpoint,
        string $apiKey,
    ) {
        $this->params['key'] = $apiKey;
    }

    public function inn(string $inn): static
    {
        $this->params['inn'] = $inn;

        return $this;
    }

    public function ogrn(string $ogrn): static
    {
        $this->params['ogrn'] = $ogrn;

        return $this;
    }

    public function param(string $name, string|int|float|bool $value): static
    {
        $this->params[$name] = $value;

        return $this;
    }

    /**
     * @return array<string, string|int|float|bool>
     */
    protected function query(): array
    {
        return $this->params;
    }

    protected function validate(): void
    {
        if (!$this->endpoint->requiresInnOrOgrn()) {
            return;
        }

        $inn = trim((string) ($this->params['inn'] ?? ''));
        $ogrn = trim((string) ($this->params['ogrn'] ?? ''));

        if ($inn === '' && $ogrn === '') {
            throw new RequestValidationException('Необходимо указать параметр "inn" или "ogrn".');
        }
    }
}
