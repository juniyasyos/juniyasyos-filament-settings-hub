<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Infrastructure\Persistence\Eloquent\Repositories;

use DateTimeImmutable;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Entities\Setting;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingGroup;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey;
use Juniyasyos\FilamentSettingsHub\Infrastructure\Persistence\Eloquent\Models\SettingModel;

final class EloquentSettingRepository implements SettingRepositoryInterface
{
    public function findById(int $id): ?Setting
    {
        $model = SettingModel::find($id);

        return $model ? $this->toDomain($model) : null;
    }

    public function findByKey(SettingKey $key): ?Setting
    {
        $model = SettingModel::where('name', $key->value())->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function findByGroup(SettingGroup $group): array
    {
        $models = SettingModel::where('group', $group->value())->get();

        return $models->map(fn (SettingModel $model) => $this->toDomain($model))->all();
    }

    public function save(Setting $setting): Setting
    {
        $model = $setting->id() > 0
            ? SettingModel::findOrFail($setting->id())
            : new SettingModel();

        $model->name = $setting->key()->value();
        $model->group = $setting->group()->value();
        $model->payload = $setting->value();
        $model->save();

        return $this->toDomain($model);
    }

    public function delete(Setting $setting): void
    {
        SettingModel::where('id', $setting->id())->delete();
    }

    public function all(): array
    {
        $models = SettingModel::all();

        return $models->map(fn (SettingModel $model) => $this->toDomain($model))->all();
    }

    public function exists(SettingKey $key): bool
    {
        return SettingModel::where('name', $key->value())->exists();
    }

    private function toDomain(SettingModel $model): Setting
    {
        return Setting::reconstitute(
            id: $model->id,
            key: SettingKey::from($model->name),
            group: SettingGroup::from($model->group),
            value: $model->payload,
            createdAt: DateTimeImmutable::createFromMutable($model->created_at),
            updatedAt: DateTimeImmutable::createFromMutable($model->updated_at)
        );
    }
}
