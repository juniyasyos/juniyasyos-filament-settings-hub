<?php

namespace Juniyasyos\FilamentSettingsHub\Console;

use Illuminate\Console\Command;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;

class FilamentSettingsHubInstall extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-settings-hub:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Publish Vendor Assets');

        $this->call('vendor:publish', ['--tag' => 'filament-settings-hub-config']);
        $this->call('vendor:publish', ['--tag' => 'filament-settings-hub-views']);
        $this->call('vendor:publish', ['--tag' => 'filament-settings-hub-lang']);
        $this->call('vendor:publish', ['--tag' => 'filament-settings-hub-migrations']);

        $this->callSilent('optimize:clear');
        $this->artisanCommand(["migrate"]);
        $this->artisanCommand(["optimize:clear"]);
        $this->info('Filament Settings Hub installed successfully.');
    }
}
