<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Application\Settings\Queries;

final readonly class GetSettingByKeyQuery
{
    public function __construct(
        public string $key
    ) {
    }
}
