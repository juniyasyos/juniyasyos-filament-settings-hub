<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers;

use Juniyasyos\FilamentSettingsHub\Application\Settings\DTOs\SettingData;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Queries\GetSettingsByGroupQuery;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingGroup;

final readonly class GetSettingsByGroupHandler
{
    public function __construct(
        private SettingRepositoryInterface $repository
    ) {
    }

    /**
     * @return SettingData[]
     */
    public function handle(GetSettingsByGroupQuery $query): array
    {
        $settings = $this->repository->findByGroup(SettingGroup::from($query->group));

        return array_map(
            fn ($setting) => new SettingData(
                key: $setting->key()->value(),
                group: $setting->group()->value(),
                value: $setting->value()
            ),
            $settings
        );
    }
}
