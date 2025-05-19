<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Filament\Resources\OrderResource\Pages\ListOrders;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    protected function getStats(): array
    {
        $currencySymbol = config('settings.currency_symbol', 'XOF');

        // return [
        //     Stat::make('Total Orders', $this->getPageTableQuery()->count())
        //         ->description('Total orders')
        //         ->descriptionIcon('heroicon-o-inbox-stack', IconPosition::Before)
        //         ->chart([1, 5, 10, 50])
        //         ->color('success'),
        //     Stat::make('Income', $this->getPageTableQuery()->sum('total_price') . ' ' . $currencySymbol)
        //         ->description("Total income")
        //         ->descriptionIcon('heroicon-o-banknotes', IconPosition::Before)
        //         ->chart([1, 5, 30, 50])
        //         ->color('success'),
        // ];

        return [
            Stat::make('Total orders', $this->getPageTableQuery()->count())
                ->description("Total orders")
                ->descriptionIcon('heroicon-o-inbox-stack', IconPosition::Before)
                ->chart([1, 5, 10, 50])
                ->color('success'),
            Stat::make('Income', $this->getPageTableQuery()->sum('total_price') . ' ' . $currencySymbol)
                ->description("Total income")
                ->descriptionIcon('heroicon-o-banknotes', IconPosition::Before)
                ->chart([1, 5, 30, 50])
                ->color('success'),
        ];
    }
}
