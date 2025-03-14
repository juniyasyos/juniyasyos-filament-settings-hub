![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-settings-hub/master/arts/3x1io-tomato-settings-hub.jpg)

# Filament Settings Hub

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-settings-hub/version.svg)](https://packagist.org/packages/tomatophp/filament-settings-hub)
[![License](https://poser.pugx.org/tomatophp/filament-settings-hub/license.svg)](https://packagist.org/packages/tomatophp/filament-settings-hub)
[![Downloads](https://poser.pugx.org/tomatophp/filament-settings-hub/d/total.svg)](https://packagist.org/packages/tomatophp/filament-settings-hub)

Manage your Filament app settings with GUI and helpers

## Screenshots

![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-settings-hub/master/arts/settings-hub.png)
![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-settings-hub/master/arts/setting-page.png)


## Installation

```bash
composer require tomatophp/filament-settings-hub
```

now you need to publish and migrate settings table

```bash
php artisan vendor:publish --provider="Spatie\LaravelSettings\LaravelSettingsServiceProvider" --tag="migrations"
```

after publish and migrate settings table please run this command

```bash
php artisan filament-settings-hub:install
```

finally reigster the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(
    \Juniyasyos\FilamentSettingsHub\FilamentSettingsHubPlugin::make()
        ->allowLocationSettings()
        ->allowSiteSettings()
        ->allowSocialMenuSettings()
)
```

## Usage

you can use this package by use this helper function

```php
settings($key);
```

to register new setting to the hub page you can use Facade class on your provider like this

```php
use Juniyasyos\FilamentSettingsHub\Facades\FilamentSettingsHub;
use Juniyasyos\FilamentSettingsHub\Services\Contracts\SettingHold;

FilamentSettingsHub::register([
    SettingHold::make()
        ->order(2)
        ->label('Site Settings') // to translate label just use direct translation path like `messages.text.name`
        ->icon('heroicon-o-globe-alt')
        ->route('filament.admin.pages.site-settings') // use page / route
        ->page(\Juniyasyos\FilamentSettingsHub\Pages\SiteSettings::class) // use page / route 
        ->description('Name, Logo, Site Profile') // to translate label just use direct translation path like `messages.text.name`
        ->group('General') // to translate label just use direct translation path like `messages.text.name`,
]);

```

and now you can see your settings on the setting hub page.

we have a ready to use helper for currency settings

```php
dollar($amount)
```

it will return the money amount with the currency symbol

## Allow Shield 

to allow [filament-shield](https://github.com/bezhanSalleh/filament-shield) for the settings please install it and config it first then you can use this method

```php
->plugin(
    \Juniyasyos\FilamentSettingsHub\FilamentSettingsHubPlugin::make()
        ->allowShield()
)
```

to make a secure setting page just use this trait 

```php
use Juniyasyos\FilamentSettingsHub\Traits\UseShield;
```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-settings-hub-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-settings-hub-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-settings-hub-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-settings-hub-migrations"
```

# Filament Spatie Laravel Backup

[![PHP Version Require](https://poser.pugx.org/juniyasyos/filament-backup/require/php)](https://packagist.org/packages/juniyasyos/filament-backup)
[![Latest Stable Version](https://poser.pugx.org/juniyasyos/filament-backup/v)](https://packagist.org/packages/juniyasyos/filament-backup)
[![Total Downloads](https://poser.pugx.org/juniyasyos/filament-backup/downloads)](https://packagist.org/packages/juniyasyos/filament-backup)
[![License](https://poser.pugx.org/juniyasyos/filament-backup/license)](https://packagist.org/packages/juniyasyos/filament-backup)

This package provides a Filament page that you can create backup of your application. You'll find installation instructions and full documentation on [spatie/laravel-backup](https://spatie.be/docs/laravel-backup/v7/introduction).

<img width="1481" alt="Screenshot 2023-08-05 at 2 42 10 PM" src="https://github.com/juniyasyos/filament-backup/assets/21066418/68fe1c0b-a130-41ce-8c7f-e5182d743225">

## Installation

You can install the package via composer:

```bash
composer require Juniyasyos/filament-backup
```

Publish the package's assets:

```bash
php artisan filament:assets
```

You can publish the lang file with:
`
```bash
php artisan vendor:publish --tag="filament-spatie-backup-translations"
```

## Usage

You first need to register the plugin with Filament. This can be done inside of your `PanelProvider`, e.g. `AdminPanelProvider`.

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(FilamentLaravelBackupPlugin::make());
    }
}
```

If you want to override the default `Backups` page icon, heading then you can extend the page class and override the `navigationIcon` property and `getHeading` method and so on.

```php
<?php

namespace App\Filament\Pages;

use Juniyasyos\FilamentLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public function getHeading(): string | Htmlable
    {
        return 'Application Backups';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Core';
    }
}
```
Then register the extended page class on `AdminPanelProvider` class.

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Backups;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelBackupPlugin::make()
                    ->usingPage(Backups::class)
            );
    }
}
```

## Customising the polling interval

You can customise the polling interval for the `Backups` by following the steps below:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelBackupPlugin::make()
                    ->usingPolingInterval('10s') // default value is 4s
            );
    }
}
```

## Customising the queue

You can customise the queue name for the `Backups` by following the steps below:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelBackupPlugin::make()
                    ->usingQueue('my-queue') // default value is null
            );
    }
}
```

## Customising the timeout

You can customise the timeout for the backup job by following the steps below:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelBackupPlugin::make()
                    ->timeout(120) // default value is max_execution_time from php.ini, or 30s if it wasn't defined
            );
    }
}
```

For more details refer to the [set_time_limit](https://www.php.net/manual/en/function.set-time-limit.php) function.

You can also disable the timeout altogether to let the job run as long as needed:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelBackupPlugin::make()
                    ->noTimeout()
            );
    }
}
```

## Customising who can access the page

You can customise who can access the `Backups` page by adding an `authorize` method to the plugin.
The method should return a boolean indicating whether the user is authorised to access the page.

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Juniyasyos\FilamentLaravelBackup\FilamentLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelBackupPlugin::make()
                     ->authorize(fn (): bool => auth()->user()->email === 'admin@example.com'),
            );
    }
}
```

## Upgrading

Please see [UPGRADE](UPGRADE.md) for details on how to upgrade 1.X to 2.0.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Shuvro Roy](https://github.com/shuvroroy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
