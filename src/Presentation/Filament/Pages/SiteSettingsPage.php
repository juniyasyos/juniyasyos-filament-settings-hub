<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Presentation\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Juniyasyos\FilamentSettingsHub\Settings\SitesSettings;
use Juniyasyos\FilamentSettingsHub\Traits\HasSettingsBreadcrumbs;
use Juniyasyos\FilamentSettingsHub\Traits\UseShield;
use Spatie\Sitemap\SitemapGenerator;

class SiteSettingsPage extends SettingsPage
{
    use HasSettingsBreadcrumbs;
    use UseShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = SitesSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        parent::mount();

        abort_unless(
            config('filament-settings-hub.page_show.site_setting', false),
            403,
            'Halaman ini tidak tersedia.'
        );
    }

    public function getTitle(): string
    {
        return trans('filament-settings-hub::messages.settings.site.title');
    }

    public function generateSitemap(): void
    {
        SitemapGenerator::create(config('app.url'))
            ->writeToFile(public_path('sitemap.xml'));

        Notification::make()
            ->title(trans('filament-settings-hub::messages.settings.site.site-map-notification'))
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(['default' => 2])
                    ->schema([
                        TextInput::make('site_name')
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_name'))
                            ->columnSpan(2)
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_name")' : null),

                        Textarea::make('site_description')
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_description'))
                            ->columnSpan(2)
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_description")' : null),

                        Textarea::make('site_keywords')
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_keywords'))
                            ->columnSpan(2)
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_keywords")' : null),

                        TextInput::make('site_phone')
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_phone'))
                            ->columnSpan(2)
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_phone")' : null),

                        FileUpload::make('site_profile')
                            ->disk(config('filament-settings-hub.upload.disk'))
                            ->directory(config('filament-settings-hub.upload.directory'))
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_profile'))
                            ->columnSpan(2)
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_profile")' : null),

                        FileUpload::make('site_logo')
                            ->disk(config('filament-settings-hub.upload.disk'))
                            ->directory(config('filament-settings-hub.upload.directory'))
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_logo'))
                            ->columnSpan(2)
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_logo")' : null),

                        TextInput::make('site_author')
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_author'))
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_author")' : null),

                        TextInput::make('site_email')
                            ->label(trans('filament-settings-hub::messages.settings.site.form.site_email'))
                            ->helperText(config('filament-settings-hub.show_hint') ? 'setting("site_email")' : null),
                    ]),
            ]);
    }
}
