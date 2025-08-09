@inject('viewModel', 'Juniyasyos\\FilamentSettingsHub\\ViewModels\\SettingsHubViewModel')
<x-filament-panels::page>
    @foreach ($viewModel->settings as $settingGroup => $setting)
        <div class="fi-page">
            <!-- Section: Anak langsung dari .fi-page agar mendapatkan gap-y-6 -->
            <section class="pt-6">
                @foreach ($setting as $item)
                    @if ($item->canAccess && ($item->routeUrl || $item->pageUrl))
                        <!-- Masing-masing item menggunakan .fi-section dan ditata dengan flex serta padding -->
                        <a href="{{ $item->routeUrl ?? $item->pageUrl }}"
                            class="fi-section flex p-4 mb-2 rounded-lg bg-white dark:fi-section-content hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600">
                            <div class="p-2">
                                @if (isset($item->icon))
                                    <x-icon name="{{ $item->icon }}" class="fi-icon-btn w-10 h-10 text-gray-800 dark:text-gray-200" style="color: {{ $item->color ?? 'inherit' }}" />
                                @else
                                    <x-heroicon-s-cog class="fi-icon-btn w-10 h-10 text-gray-800 dark:text-gray-200" />
                                @endif
                            </div>
                            <div>
                                <h1 class="font-bold text-lg text-gray-900 dark:text-white">
                                    {{ str($item->label)->contains(['.', '::']) ? trans($item->label) : $item->label }}
                                </h1>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ str($item->description)->contains(['.', '::']) ? trans($item->description) : $item->description }}
                                </p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </section>
        </div>
    @endforeach
</x-filament-panels::page>
