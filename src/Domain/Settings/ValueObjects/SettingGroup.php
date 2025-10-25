<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Domain\Settings\ValueObjects;

use InvalidArgumentException;

final readonly class SettingGroup
{
    public const SITE = 'sites';
    public const SOCIAL = 'social';
    public const LOCATION = 'location';
    public const AUTHENTICATION = 'authentication';

    private function __construct(
        private string $value
    ) {
        $this->validate();
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public static function site(): self
    {
        return new self(self::SITE);
    }

    public static function social(): self
    {
        return new self(self::SOCIAL);
    }

    public static function location(): self
    {
        return new self(self::LOCATION);
    }

    public static function authentication(): self
    {
        return new self(self::AUTHENTICATION);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    private function validate(): void
    {
        if (empty(trim($this->value))) {
            throw new InvalidArgumentException('Setting group cannot be empty');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
