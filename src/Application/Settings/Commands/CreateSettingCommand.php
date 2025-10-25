<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Commands;

final readonly class CreateSettingCommand
{
    public function __construct(
        public string $key,
        public string $group,
        public mixed $value
    ) {
    }
}
