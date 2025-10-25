<?php

declare(strict_types=1);

namespace Juniyasyos\FilamentSettingsHub\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $group
 * @property mixed $payload
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class SettingModel extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'name',
        'group',
        'payload',
    ];

    protected $casts = [
        'payload' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
