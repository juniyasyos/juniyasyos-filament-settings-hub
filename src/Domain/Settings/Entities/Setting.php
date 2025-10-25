<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Domain\Settings\Entities;

use DateTimeImmutable;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingGroup;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey;

final class Setting
{
    private function __construct(
        private readonly int $id,
        private SettingKey $key,
        private SettingGroup $group,
        private mixed $value,
        private readonly DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt
    ) {
    }

    public static function create(
        SettingKey $key,
        SettingGroup $group,
        mixed $value
    ): self {
        $now = new DateTimeImmutable();

        return new self(
            id: 0,
            key: $key,
            group: $group,
            value: $value,
            createdAt: $now,
            updatedAt: $now
        );
    }

    public static function reconstitute(
        int $id,
        SettingKey $key,
        SettingGroup $group,
        mixed $value,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ): self {
        return new self($id, $key, $group, $value, $createdAt, $updatedAt);
    }

    public function updateValue(mixed $value): void
    {
        $this->value = $value;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function changeGroup(SettingGroup $group): void
    {
        $this->group = $group;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function key(): SettingKey
    {
        return $this->key;
    }

    public function group(): SettingGroup
    {
        return $this->group;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
