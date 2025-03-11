<?php

namespace Juniyasyos\FilamentSettingsHub\Models;

use GeneaLabs\LaravelModelCaching\CachedModel;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Setting extends CachedModel
{
    use Cachable;

    protected $cachePrefix = "juniyasyos_settings_";

    protected $table = 'settings';

    protected $casts = [
        'payload' => "json"
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $fillable = [
        'id',
        'name',
        'group',
        'payload'
    ];
}
