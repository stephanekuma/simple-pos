<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    use HasWidgetShield;

    protected function getStats(): array
    {
        $currencySymbol = config('settings.currency_symbol');

        $totalOrdersLast30Days = Order::query()->where('created_at', '>=', now()->subDays(30))->count();
        $totalIncomeLast30Days = Order::query()->where('created_at', '>=', now()->subDays(30))->sum('total_price');
        $totalcustomersLast30Days = Customer::query()->where('created_at', '>=', now()->subDays(30))->count();

        return [
            Stat::make('Orders Count', $totalOrdersLast30Days)
                ->description("Total orders in the last 30 days")
                ->descriptionIcon('heroicon-o-inbox-stack', IconPosition::Before)
                ->chart([1, 5, 10, 50])
                ->color('success'),

            Stat::make('Income',$totalIncomeLast30Days . ' ' . $currencySymbol)
                ->description("Total income in the last 30 days")
                ->descriptionIcon('heroicon-o-banknotes', IconPosition::Before)
                ->chart([1, 5, 30, 50])
                ->color('success'),

            Stat::make('Customers Count', $totalcustomersLast30Days)
                ->description("Last 30 days customers count")
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->chart([1, 5, 15, 25])
                ->color('success'),
        ];
    }
}
