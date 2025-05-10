<?php

namespace Juniyasyos\FilamentSettingsHub\Traits;

trait HasSettingsBreadcrumbs
{
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.settings') => __('filament-settings-hub::messages.title'),
            $this->getTitle(),
        ];
    }
}
