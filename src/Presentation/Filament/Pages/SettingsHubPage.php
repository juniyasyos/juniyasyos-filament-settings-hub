<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Presentation\Filament\Pages;

use Filament\Pages\Page;
use Juniyasyos\FilamentSettingsHub\Traits\UseShield;

class SettingsHubPage extends Page
{
    use UseShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament-settings-hub::index';

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-settings-hub::messages.group');
    }

    public function getTitle(): string
    {
        return trans('filament-settings-hub::messages.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-settings-hub::messages.title');
    }

    public static function getSlug(): string
    {
        return 'settings';
    }
}
