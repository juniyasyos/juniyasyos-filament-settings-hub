<?php

namespace Juniyasyos\FilamentSettingsHub;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Juniyasyos\FilamentSettingsHub\Facades\FilamentSettingsHub;
use Juniyasyos\FilamentSettingsHub\Pages\{LocationSettings, ManageSettingKaido, SettingsHub, SiteSettings, SocialMenuSettings};
use Juniyasyos\FilamentSettingsHub\Services\Contracts\SettingHold;
use Nwidart\Modules\Module;

class FilamentSettingsHubPlugin implements Plugin
{
    use EvaluatesClosures;

    private const ID = 'filament-settings-hub';

    private bool $isActive = false;

    private array $settingsPermissions = [
        'site' => true,
        'socialMenu' => true,
        'location' => true,
        'kaido' => true,
        'shield' => true,
    ];

    public function getId(): string
    {
        return self::ID;
    }

    private function evaluatePermission(string $key): bool
    {
        return $this->evaluate($this->settingsPermissions[$key]);
    }

    public function allowSetting(string $key, bool|\Closure $allow = true): static
    {
        if (array_key_exists($key, $this->settingsPermissions)) {
            $this->settingsPermissions[$key] = $allow;
        }
        return $this;
    }

    public function register(Panel $panel): void
    {
        $this->isActive = class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentSettingsHub')?->isEnabled();

        if (!$this->isActive) {
            return;
        }

        $pages = array_filter([
            $this->evaluatePermission('site') ? SiteSettings::class : null,
            $this->evaluatePermission('socialMenu') ? SocialMenuSettings::class : null,
            $this->evaluatePermission('location') ? LocationSettings::class : null,
            $this->evaluatePermission('kaido') ? ManageSettingKaido::class : null,
            SettingsHub::class,
        ]);

        $panel->pages($pages);
    }

    public function boot(Panel $panel): void
    {
        if (!$this->isActive) {
            return;
        }

        $settings = array_filter([
            $this->evaluatePermission('site') ? SettingHold::make()
                ->page(SiteSettings::class)
                ->order(1)
                ->label('filament-settings-hub::messages.settings.site.title')
                ->icon('heroicon-o-globe-alt')
                ->description('filament-settings-hub::messages.settings.site.description') : null,

            $this->evaluatePermission('socialMenu') ? SettingHold::make()
                ->page(SocialMenuSettings::class)
                ->order(2)
                ->label('filament-settings-hub::messages.settings.social.title')
                ->icon('heroicon-s-bars-3')
                ->description('filament-settings-hub::messages.settings.social.description') : null,

            $this->evaluatePermission('location') ? SettingHold::make()
                ->page(LocationSettings::class)
                ->order(3)
                ->label('filament-settings-hub::messages.settings.location.title')
                ->icon('heroicon-o-map')
                ->description('filament-settings-hub::messages.settings.location.description') : null,

            $this->evaluatePermission('kaido') ? SettingHold::make()
                ->page(ManageSettingKaido::class)
                ->order(4)
                ->label('filament-settings-hub::messages.settings.login.title')
                ->icon('heroicon-o-arrow-right-end-on-rectangle')
                ->description('filament-settings-hub::messages.settings.login.description') : null,
        ]);

        FilamentSettingsHub::register($settings);
    }

    public static function make(): static
    {
        return new static();
    }
}
