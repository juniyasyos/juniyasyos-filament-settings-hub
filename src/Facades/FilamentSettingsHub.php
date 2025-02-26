<?php

namespace Juniyasyos\FilamentSettingsHub\Facades;

use Illuminate\Support\Facades\Facade;
use Juniyasyos\FilamentSettingsHub\Services\Contracts\SettingHold;

/**
 *  @method static \Illuminate\Support\Collection get()
 * @method static \Illuminate\Support\Collection load()
 * @method static \Juniyasyos\FilamentSettingsHub\Services\SettingHolderHandler register(array|SettingHold $item)
 */
class FilamentSettingsHub extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-settings-hub';
    }
}
