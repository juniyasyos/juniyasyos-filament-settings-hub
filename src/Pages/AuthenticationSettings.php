<?php

namespace Juniyasyos\FilamentSettingsHub\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Juniyasyos\FilamentSettingsHub\Traits\UseShield;
use Juniyasyos\FilamentSettingsHub\Settings\KaidoSetting;
use Juniyasyos\FilamentSettingsHub\Traits\HasSettingsBreadcrumbs;

class AuthenticationSettings extends SettingsPage
{
    use UseShield, HasSettingsBreadcrumbs;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $settings = KaidoSetting::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make(__('filament-settings-hub::messages.settings.authentication.form.section_title'))
                ->columns(1)
                ->schema([
                    TextInput::make('site_name')
                        ->label(__('filament-settings-hub::messages.settings.authentication.form.site_name'))
                        ->required(),
                    Toggle::make('site_active')
                        ->label(__('filament-settings-hub::messages.settings.authentication.form.site_active')),
                    Toggle::make('registration_enabled')
                        ->label(__('filament-settings-hub::messages.settings.authentication.form.registration_enabled')),
                    Toggle::make('password_reset_enabled')
                        ->label(__('filament-settings-hub::messages.settings.authentication.form.password_reset_enabled')),
                    Toggle::make('sso_enabled')
                        ->label(__('filament-settings-hub::messages.settings.authentication.form.sso_enabled')),
                ]),
        ]);
    }
}
