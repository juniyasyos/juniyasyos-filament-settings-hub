<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers;

use Juniyasyos\FilamentSettingsHub\Application\Settings\DTOs\SettingData;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Queries\GetSettingByKeyQuery;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey;

final readonly class GetSettingByKeyHandler
{
    public function __construct(
        private SettingRepositoryInterface $repository
    ) {
    }

    public function handle(GetSettingByKeyQuery $query): ?SettingData
    {
        $setting = $this->repository->findByKey(SettingKey::from($query->key));

        if (!$setting) {
            return null;
        }

        return new SettingData(
            key: $setting->key()->value(),
            group: $setting->group()->value(),
            value: $setting->value()
        );
    }
}
