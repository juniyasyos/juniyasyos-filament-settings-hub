<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Services;

use Juniyasyos\FilamentSettingsHub\Application\Settings\Commands\CreateSettingCommand;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Commands\UpdateSettingCommand;
use Juniyasyos\FilamentSettingsHub\Application\Settings\DTOs\SettingData;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers\CreateSettingHandler;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers\GetSettingByKeyHandler;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers\GetSettingsByGroupHandler;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers\UpdateSettingHandler;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Queries\GetSettingByKeyQuery;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Queries\GetSettingsByGroupQuery;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;

final readonly class SettingService
{
    private CreateSettingHandler $createHandler;
    private UpdateSettingHandler $updateHandler;
    private GetSettingByKeyHandler $getByKeyHandler;
    private GetSettingsByGroupHandler $getByGroupHandler;

    public function __construct(
        private SettingRepositoryInterface $repository
    ) {
        $this->createHandler = new CreateSettingHandler($repository);
        $this->updateHandler = new UpdateSettingHandler($repository);
        $this->getByKeyHandler = new GetSettingByKeyHandler($repository);
        $this->getByGroupHandler = new GetSettingsByGroupHandler($repository);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $setting = $this->getByKeyHandler->handle(new GetSettingByKeyQuery($key));

        return $setting?->value ?? $default;
    }

    public function set(string $key, string $group, mixed $value): void
    {
        if ($this->repository->exists(\Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey::from($key))) {
            $this->updateHandler->handle(new UpdateSettingCommand($key, $value));
        } else {
            $this->createHandler->handle(new CreateSettingCommand($key, $group, $value));
        }
    }

    public function getByGroup(string $group): array
    {
        return $this->getByGroupHandler->handle(new GetSettingsByGroupQuery($group));
    }

    public function has(string $key): bool
    {
        return $this->repository->exists(\Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects\SettingKey::from($key));
    }
}
