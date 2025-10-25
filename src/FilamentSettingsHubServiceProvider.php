<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub;

use Illuminate\Support\ServiceProvider;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Services\SettingService;
use Juniyasyos\FilamentSettingsHub\Domain\Settings\Repositories\SettingRepositoryInterface;
use Juniyasyos\FilamentSettingsHub\Infrastructure\Persistence\Eloquent\Repositories\EloquentSettingRepository;
use Juniyasyos\FilamentSettingsHub\Services\SettingHolderHandler;

require_once __DIR__.'/helpers.php';

class FilamentSettingsHubServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register commands
        $this->commands([
            \Juniyasyos\FilamentSettingsHub\Console\FilamentSettingsHubInstall::class,
        ]);

        // Register config file
        $this->mergeConfigFrom(
            __DIR__.'/../config/filament-settings-hub.php',
            'filament-settings-hub'
        );

        // Publish config
        $this->publishes([
            __DIR__.'/../config/filament-settings-hub.php' => config_path('filament-settings-hub.php'),
        ], 'filament-settings-hub-config');

        // Register migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publish migrations
        if (! class_exists('SitesSettings')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/sites_settings.php.stub' => database_path('migrations/'.$timestamp.'_sites_settings.php'),
            ], 'filament-settings-hub-migrations');
        }

        // Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-settings-hub');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/filament-settings-hub'),
        ], 'filament-settings-hub-views');

        // Register translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-settings-hub');

        // Publish translations
        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-settings-hub'),
        ], 'filament-settings-hub-lang');

        // Bind DDD interfaces to implementations
        $this->bindDomainInterfaces();
        $this->bindApplicationServices();
        $this->bindLegacyServices();
    }

    public function boot(): void
    {
        //
    }

    /**
     * Bind domain layer interfaces to infrastructure implementations
     */
    private function bindDomainInterfaces(): void
    {
        $this->app->bind(
            SettingRepositoryInterface::class,
            EloquentSettingRepository::class
        );
    }

    /**
     * Bind application layer services
     */
    private function bindApplicationServices(): void
    {
        $this->app->singleton(SettingService::class, function ($app) {
            return new SettingService(
                $app->make(SettingRepositoryInterface::class)
            );
        });
    }

    /**
     * Bind legacy services for backward compatibility
     */
    private function bindLegacyServices(): void
    {
        $this->app->bind('filament-settings-hub', function () {
            return new SettingHolderHandler();
        });
    }
}
