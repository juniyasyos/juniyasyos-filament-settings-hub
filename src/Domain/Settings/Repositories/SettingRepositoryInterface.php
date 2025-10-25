<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories;

use Juniyasyos\FilamentSettingsHub\Domain\Settings\Entities\Setting;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingGroup;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey;

interface SettingRepositoryInterface
{
    public function findById(int $id): ?Setting;

    public function findByKey(SettingKey $key): ?Setting;

    public function findByGroup(SettingGroup $group): array;

    public function save(Setting $setting): Setting;

    public function delete(Setting $setting): void;

    public function all(): array;

    public function exists(SettingKey $key): bool;
}
