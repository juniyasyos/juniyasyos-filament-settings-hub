<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\DTOs;

final readonly class SettingData
{
    public function __construct(
        public string $key,
        public string $group,
        public mixed $value
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            key: $data['key'] ?? $data['name'] ?? '',
            group: $data['group'] ?? '',
            value: $data['value'] ?? $data['payload'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'group' => $this->group,
            'value' => $this->value,
        ];
    }
}
