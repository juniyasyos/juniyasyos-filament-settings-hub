<x-filament-panels::page>
    @php
        $settings = \Juniyasyos\FilamentSettingsHub\Facades\FilamentSettingsHub::load()
            ->sortBy('order')
            ->groupBy('group');
        $tenant = \Filament\Facades\Filament::getTenant();
    @endphp

    @foreach ($settings as $settingGroup => $setting)
        <h1 class="text-lg font-bold tracking-tight md:text-3xl filament-header-heading">
            {{ str_replace('resources', 'reguler', str($settingGroup)->contains(['.', '::']) ? trans($settingGroup) : $settingGroup) }}
        </h1>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($setting as $item)
                @php
                    $canAccess = true;
                    $routeUrl = $item->route ? ($tenant ? route($item->route, $tenant) : route($item->route)) : null;
                    $pageUrl = $item->page ? app($item->page)::getUrl() : null;

                    if ($item->route && filament('filament-settings-hub')->isShieldAllowed()) {
                        $page =
                            optional(\Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName()[$item->route])
                                ->action['controller'] ?? null;
                        $page = $page ? str($page)->afterLast('\\') : null;
                        $canAccess = $page
                            ? \Filament\Facades\Filament::auth()
                                ->user()
                                ->can('page_' . $page)
                            : false;
                    } elseif ($item->page && filament('filament-settings-hub')->isShieldAllowed()) {
                        $canAccess = \Filament\Facades\Filament::auth()
                            ->user()
                            ->can('page_' . str($item->page)->afterLast('\\'));
                    }
                @endphp

                @if ($canAccess && ($routeUrl || $pageUrl))
                    <a href="{{ $routeUrl ?? $pageUrl }}"
                        class="fi-ta-ctn flex flex-col justify-center items-center gap-2 p-4 overflow-hidden
                              rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                        <div class="p-2">
                            @if (isset($item->icon))
                                <x-icon name="{{ $item->icon }}" class="w-16 h-16"
                                    style="color: {{ $item->color ?? 'inherit' }}" />
                            @else
                                <x-heroicon-s-cog class="w-16 h-16" />
                            @endif
                        </div>
                        <h1 class="font-bold text-lg">
                            {{ str($item->label)->contains(['.', '::']) ? trans($item->label) : $item->label }}
                        </h1>
                        <p class="text-sm text-gray-400">
                            {{ str($item->description)->contains(['.', '::']) ? trans($item->description) : $item->description }}
                        </p>
                    </a>
                @endif
            @endforeach
        </div>
    @endforeach
</x-filament-panels::page>
