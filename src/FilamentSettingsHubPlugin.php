<?php

namespace Juniyasyos\FilamentSettingsHub;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Juniyasyos\FilamentSettingsHub\Facades\FilamentSettingsHub;
use Juniyasyos\FilamentSettingsHub\Pages\AuthenticationSettings;
use Juniyasyos\FilamentSettingsHub\Pages\LocationSettings;
use Juniyasyos\FilamentSettingsHub\Pages\SettingsHub;
use Juniyasyos\FilamentSettingsHub\Pages\SiteSettings;
use Juniyasyos\FilamentSettingsHub\Pages\SocialMenuSettings;
use Juniyasyos\FilamentSettingsHub\Services\Contracts\SettingHold;
use Nwidart\Modules\Module;

class FilamentSettingsHubPlugin implements Plugin
{
    use EvaluatesClosures;

    /**
     * Configuration for settings pages.
     */
    protected static array $settings = [
        'site' => [
            'page' => SiteSettings::class,
            'order' => 1,
            'icon' => 'heroicon-o-globe-alt',
            'label' => 'filament-settings-hub::messages.settings.site.title',
            'description' => 'filament-settings-hub::messages.settings.site.description',
            'allowed' => true,
        ],
        'social' => [
            'page' => SocialMenuSettings::class,
            'order' => 2,
            'icon' => 'heroicon-s-bars-3',
            'label' => 'filament-settings-hub::messages.settings.social.title',
            'description' => 'filament-settings-hub::messages.settings.social.description',
            'allowed' => true,
        ],
        'location' => [
            'page' => LocationSettings::class,
            'order' => 3,
            'icon' => 'heroicon-o-map',
            'label' => 'filament-settings-hub::messages.settings.location.title',
            'description' => 'filament-settings-hub::messages.settings.location.description',
            'allowed' => true,
        ],
        'authentication' => [
            'page' => AuthenticationSettings::class,
            'order' => 4,
            'icon' => 'heroicon-o-arrow-right-end-on-rectangle',
            'label' => 'filament-settings-hub::messages.settings.authentication.title',
            'description' => 'filament-settings-hub::messages.settings.authentication.description',
            'allowed' => true,
        ],
    ];

    public static bool | \Closure $allowShield = true;

    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-settings-hub';
    }

    public function allowShield(bool | \Closure $allow = true): static
    {
        static::$allowShield = $allow;

        return $this;
    }

    public function allowSiteSettings(bool | \Closure $allow = true): static
    {
        return $this->allow('site', $allow);
    }

    public function allowSocialMenuSettings(bool | \Closure $allow = true): static
    {
        return $this->allow('social', $allow);
    }

    public function allowLocationSettings(bool | \Closure $allow = true): static
    {
        return $this->allow('location', $allow);
    }

    public function allowKaidoSettings(bool | \Closure $allow = true): static
    {
        return $this->allow('authentication', $allow);
    }

    public function isSiteSettingAllowed(): bool
    {
        return $this->isAllowed('site');
    }

    public function isSocialMenuSettingAllowed(): bool
    {
        return $this->isAllowed('social');
    }

    public function isLocationSettingAllowed(): bool
    {
        return $this->isAllowed('location');
    }

    public function isKaidoSettingAllowed(): bool
    {
        return $this->isAllowed('authentication');
    }

    public function isShieldAllowed(): bool
    {
        return $this->evaluate(static::$allowShield);
    }

    protected function allow(string $key, bool | \Closure $value): static
    {
        static::$settings[$key]['allowed'] = $value;

        return $this;
    }

    protected function isAllowed(string $key): bool
    {
        return $this->evaluate(static::$settings[$key]['allowed']);
    }

    public function register(Panel $panel): void
    {
        $this->isActive = ! class_exists(Module::class)
            || \Nwidart\Modules\Facades\Module::find('FilamentSettingsHub')?->isEnabled();

        if (! $this->isActive) {
            return;
        }

        $pages = collect(static::$settings)
            ->filter(fn (array $config, string $key) => $this->isAllowed($key))
            ->pluck('page')
            ->push(SettingsHub::class)
            ->toArray();

        $panel->pages($pages);
    }

    public function boot(Panel $panel): void
    {
        if (! $this->isActive) {
            return;
        }

        $settings = collect(static::$settings)
            ->filter(fn (array $config, string $key) => $this->isAllowed($key))
            ->map(
                fn (array $config) => SettingHold::make()
                    ->page($config['page'])
                    ->order($config['order'])
                    ->label($config['label'])
                    ->icon($config['icon'])
                    ->description($config['description'])
            )
            ->values()
            ->all();

        FilamentSettingsHub::register($settings);
    }

    public static function make(): static
    {
        return new static;
    }
}
