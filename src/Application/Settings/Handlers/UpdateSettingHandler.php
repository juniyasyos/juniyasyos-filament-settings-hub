<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers;

use Juniyasyos\FilamentSettingsHub\Application\Settings\Commands\UpdateSettingCommand;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Entities\Setting;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey;

final readonly class UpdateSettingHandler
{
    public function __construct(
        private SettingRepositoryInterface $repository
    ) {
    }

    public function handle(UpdateSettingCommand $command): Setting
    {
        $setting = $this->repository->findByKey(SettingKey::from($command->key));

        if (!$setting) {
            throw new \RuntimeException("Setting with key '{$command->key}' not found");
        }

        $setting->updateValue($command->value);

        return $this->repository->save($setting);
    }
}
