<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers;

use Juniyasyos\FilamentSettingsHub\Application\Settings\Commands\CreateSettingCommand;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Entities\Setting;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingGroup;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey;

final readonly class CreateSettingHandler
{
    public function __construct(
        private SettingRepositoryInterface $repository
    ) {
    }

    public function handle(CreateSettingCommand $command): Setting
    {
        $setting = Setting::create(
            key: SettingKey::from($command->key),
            group: SettingGroup::from($command->group),
            value: $command->value
        );

        return $this->repository->save($setting);
    }
}
