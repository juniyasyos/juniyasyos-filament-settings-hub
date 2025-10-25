<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Commands;

final readonly class UpdateSettingCommand
{
    public function __construct(
        public string $key,
        public mixed $value
    ) {
    }
}
