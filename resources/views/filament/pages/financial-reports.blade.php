<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Period Selector --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Période</label>
                    <select wire:model.live="period" class="rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="daily">Journalier</option>
                        <option value="weekly">Hebdomadaire</option>
                        <option value="monthly">Mensuel</option>
                        <option value="quarterly">Trimestriel</option>
                        <option value="semi_annual">Semestriel</option>
                        <option value="annual">Annuel</option>
                        <option value="custom">Personnalisé</option>
                    </select>
                </div>

                @if($period === 'custom')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date début</label>
                        <input type="date" wire:model.live="customStartDate" class="rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date fin</label>
                        <input type="date" wire:model.live="customEndDate" class="rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </div>
                @endif
            </div>
        </div>

        @php $data = $this->getReportData(); @endphp

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Orders --}}
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-blue-500/10 dark:bg-blue-400/10"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Commandes</p>
                        <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($data['total_orders']) }}</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $data['period_label'] }}</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/20">
                        <x-heroicon-o-shopping-cart class="h-7 w-7 text-blue-600 dark:text-blue-400"/>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">{{ $data['start_date'] }} - {{ $data['end_date'] }}</p>
            </div>

            {{-- Revenue --}}
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-green-500/10 dark:bg-green-400/10"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Chiffre d'Affaires</p>
                        <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($data['total_revenue'], 0, ',', ' ') }} F</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $data['period_label'] }}</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 dark:bg-green-500/20">
                        <x-heroicon-o-banknotes class="h-7 w-7 text-green-600 dark:text-green-400"/>
                    </div>
                </div>
            </div>

            {{-- Average Order --}}
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-purple-500/10 dark:bg-purple-400/10"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Panier Moyen</p>
                        <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($data['average_order'], 0, ',', ' ') }} F</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $data['period_label'] }}</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-500/20">
                        <x-heroicon-o-calculator class="h-7 w-7 text-purple-600 dark:text-purple-400"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Orders by Day --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-lg font-semibold text-gray-950 dark:text-white mb-4">Ventes par jour</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400">Date</th>
                                <th class="text-right py-3 px-2 font-medium text-gray-600 dark:text-gray-400">Commandes</th>
                                <th class="text-right py-3 px-2 font-medium text-gray-600 dark:text-gray-400">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($data['orders_by_day'] as $day)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="py-3 px-2 text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-2 text-right text-gray-900 dark:text-gray-100">{{ $day->count }}</td>
                                    <td class="py-3 px-2 text-right font-medium text-green-600 dark:text-green-400">{{ number_format($day->total, 0, ',', ' ') }} F</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        <x-heroicon-o-inbox class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500 mb-2"/>
                                        Aucune donnée pour cette période
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-lg font-semibold text-gray-950 dark:text-white mb-4">Top 10 Produits</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400">Produit</th>
                                <th class="text-right py-3 px-2 font-medium text-gray-600 dark:text-gray-400">Qté</th>
                                <th class="text-right py-3 px-2 font-medium text-gray-600 dark:text-gray-400">CA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($data['top_products'] as $index => $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="py-3 px-2 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center gap-2">
                                            @if($index < 3)
                                                <span class="flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold
                                                    {{ $index === 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' : '' }}
                                                    {{ $index === 1 ? 'bg-gray-200 text-gray-700 dark:bg-gray-600/50 dark:text-gray-300' : '' }}
                                                    {{ $index === 2 ? 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400' : '' }}
                                                ">{{ $index + 1 }}</span>
                                            @endif
                                            {{ $product->product_name }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 text-right text-gray-900 dark:text-gray-100">{{ $product->total_qty }}</td>
                                    <td class="py-3 px-2 text-right font-medium text-green-600 dark:text-green-400">{{ number_format($product->total_revenue, 0, ',', ' ') }} F</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        <x-heroicon-o-inbox class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500 mb-2"/>
                                        Aucune donnée pour cette période
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
