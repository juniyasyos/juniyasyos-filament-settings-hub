<?php

namespace Juniyasyos\FilamentSettingsHub\ViewModels;

use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Juniyasyos\FilamentSettingsHub\Facades\FilamentSettingsHub;

class SettingsHubViewModel
{
    /**
     * Processed settings grouped by their group name.
     */
    public Collection $settings;

    public function __construct()
    {
        $this->settings = $this->buildSettings();
    }

    protected function buildSettings(): Collection
    {
        $settings = FilamentSettingsHub::load()
            ->sortBy('order')
            ->groupBy('group');

        $tenant = Filament::getTenant();

        return $settings->map(function (Collection $group) use ($tenant) {
            return $group->map(function ($item) use ($tenant) {
                $routeUrl = $item->route
                    ? ($tenant ? route($item->route, $tenant) : route($item->route))
                    : null;

                $pageUrl = $item->page ? app($item->page)::getUrl() : null;

                $canAccess = true;
                if ($item->route && filament('filament-settings-hub')->isShieldAllowed()) {
                    $page = optional(Route::getRoutes()->getRoutesByName()[$item->route] ?? null)->action['controller'] ?? null;
                    $page = $page ? str($page)->afterLast('\\') : null;
                    $canAccess = $page ? Filament::auth()->user()->can('page_' . $page) : false;
                } elseif ($item->page && filament('filament-settings-hub')->isShieldAllowed()) {
                    $canAccess = Filament::auth()->user()->can('page_' . str($item->page)->afterLast('\\'));
                }

                return (object) [
                    'label' => $item->label,
                    'description' => $item->description,
                    'icon' => $item->icon,
                    'color' => $item->color,
                    'routeUrl' => $routeUrl,
                    'pageUrl' => $pageUrl,
                    'canAccess' => $canAccess,
                ];
            });
        });
    }
}
