<?php

namespace Juniyasyos\FilamentSettingsHub;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use Nwidart\Modules\Module;
use Juniyasyos\FilamentSettingsHub\Facades\FilamentSettingsHub;
use Juniyasyos\FilamentSettingsHub\Pages\LocationSettings;
use Juniyasyos\FilamentSettingsHub\Pages\AuthenticationSettings;
use Juniyasyos\FilamentSettingsHub\Pages\SettingsHub;
use Juniyasyos\FilamentSettingsHub\Pages\SiteSettings;
use Juniyasyos\FilamentSettingsHub\Pages\SocialMenuSettings;
use Juniyasyos\FilamentSettingsHub\Services\Contracts\SettingHold;


class FilamentSettingsHubPlugin implements Plugin
{
    use EvaluatesClosures;

    public static bool|\Closure $allowSiteSettings = true;
    public static bool|\Closure $allowSocialMenuSettings = true;
    public static bool|\Closure $allowLocationSettings = true;
    public static bool|\Closure $allowKaidoSettings = true;
    public static bool|\Closure $allowShield = true;

    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-settings-hub';
    }

    public function allowShield(bool|\Closure $allow = true): static
    {
        static::$allowShield = $allow;
        return $this;
    }

    public function allowSiteSettings(bool|\Closure $allow = true): static
    {
        static::$allowSiteSettings = $allow;
        return $this;
    }

    public function allowSocialMenuSettings(bool|\Closure $allow = true): static
    {
        static::$allowSocialMenuSettings = $allow;
        return $this;
    }

    public function allowKaidoSettings(bool|\Closure $allow = true): static
    {
        static::$allowKaidoSettings = $allow;
        return $this;
    }

    public function isSiteSettingAllowed(): bool
    {
        return $this->evaluate(static::$allowSiteSettings);
    }

    public function isSocialMenuSettingAllowed(): bool
    {
        return $this->evaluate(static::$allowSocialMenuSettings);
    }

    public function isLocationSettingAllowed(): bool
    {
        return $this->evaluate(static::$allowLocationSettings);
    }

    public function isKaidoSettingAllowed(): bool
    {
        return $this->evaluate(static::$allowKaidoSettings);
    }

    public function isShieldAllowed(): bool
    {
        return $this->evaluate(static::$allowShield);
    }


    public function allowLocationSettings(bool|\Closure $allow = true): static
    {
        static::$allowLocationSettings = $allow;
        return $this;
    }

    public function register(Panel $panel): void
    {
        if (class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentSettingsHub')?->isEnabled()) {
            $this->isActive = true;
        } else {
            $this->isActive = true;
        }

        if ($this->isActive) {
            $pages = [];

            if ($this->isSiteSettingAllowed()) {
                $pages[] = SiteSettings::class;
            }

            if ($this->isSocialMenuSettingAllowed()) {
                $pages[] = SocialMenuSettings::class;
            }

            if ($this->isLocationSettingAllowed()) {
                $pages[] = LocationSettings::class;
            }

            if ($this->isKaidoSettingAllowed()) {
                $pages[] = AuthenticationSettings::class;
            }

            $pages[] = SettingsHub::class;

            $panel->pages($pages);
        }

    }

    public function boot(Panel $panel): void
    {
        if ($this->isActive) {
            $settings = [];

            if ($this->isSiteSettingAllowed()) {
                $settings[] = SettingHold::make()
                    ->page(SiteSettings::class)
                    ->order(1)
                    ->label('filament-settings-hub::messages.settings.site.title')
                    ->icon('heroicon-o-globe-alt')
                    ->description('filament-settings-hub::messages.settings.site.description');
            }

            if ($this->isSocialMenuSettingAllowed()) {
                $settings[] = SettingHold::make()
                    ->page(SocialMenuSettings::class)
                    ->order(2)
                    ->label('filament-settings-hub::messages.settings.social.title')
                    ->icon('heroicon-s-bars-3')
                    ->description('filament-settings-hub::messages.settings.social.description');
            }

            if ($this->isLocationSettingAllowed()) {
                $settings[] = SettingHold::make()
                    ->page(LocationSettings::class)
                    ->order(3)
                    ->label('filament-settings-hub::messages.settings.location.title')
                    ->icon('heroicon-o-map')
                    ->description('filament-settings-hub::messages.settings.location.description');
            }


            if ($this->isKaidoSettingAllowed()) {
                $settings[] = SettingHold::make()
                    ->page(AuthenticationSettings::class)
                    ->order(4)
                    ->label('filament-settings-hub::messages.settings.authentication.title')
                    ->icon('heroicon-o-arrow-right-end-on-rectangle')
                    ->description('filament-settings-hub::messages.settings.authentication.description');
            }

            FilamentSettingsHub::register($settings);
        }

    }

    public static function make(): static
    {
        return new static();
    }
}
