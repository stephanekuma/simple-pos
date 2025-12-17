<x-filament-widgets::widget>
    @php $data = $this->getReportData(); @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Daily --}}
        <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center gap-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-500/10">
                    <x-heroicon-o-calendar-days class="h-6 w-6 text-blue-600 dark:text-blue-400"/>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aujourd'hui</p>
                    <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ number_format($data['daily']['revenue'], 0, ',', ' ') }} F</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $data['daily']['orders'] }} commandes</p>
                </div>
            </div>
        </div>

        {{-- Weekly --}}
        <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center gap-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 dark:bg-green-500/10">
                    <x-heroicon-o-calendar class="h-6 w-6 text-green-600 dark:text-green-400"/>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cette semaine</p>
                    <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ number_format($data['weekly']['revenue'], 0, ',', ' ') }} F</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $data['weekly']['orders'] }} commandes</p>
                </div>
            </div>
        </div>

        {{-- Monthly --}}
        <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center gap-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-500/10">
                    <x-heroicon-o-chart-bar class="h-6 w-6 text-purple-600 dark:text-purple-400"/>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ce mois</p>
                    <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ number_format($data['monthly']['revenue'], 0, ',', ' ') }} F</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $data['monthly']['orders'] }} commandes</p>
                </div>
            </div>
        </div>

        {{-- Annual --}}
        <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-center gap-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-500/10">
                    <x-heroicon-o-presentation-chart-line class="h-6 w-6 text-amber-600 dark:text-amber-400"/>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cette année</p>
                    <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ number_format($data['annual']['revenue'], 0, ',', ' ') }} F</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $data['annual']['orders'] }} commandes</p>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>

