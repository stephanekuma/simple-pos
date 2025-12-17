<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Payment;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class FinancialReportWidget extends Widget
{
    use HasWidgetShield;

    protected static string $view = 'filament.widgets.financial-report-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function getReportData(): array
    {
        $today = now();

        return [
            'daily' => [
                'orders' => Order::whereDate('created_at', $today)->count(),
                'revenue' => Payment::whereDate('created_at', $today)->sum('amount'),
            ],
            'weekly' => [
                'orders' => Order::whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])->count(),
                'revenue' => Payment::whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])->sum('amount'),
            ],
            'monthly' => [
                'orders' => Order::whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->count(),
                'revenue' => Payment::whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->sum('amount'),
            ],
            'annual' => [
                'orders' => Order::whereYear('created_at', $today->year)->count(),
                'revenue' => Payment::whereYear('created_at', $today->year)->sum('amount'),
            ],
        ];
    }
}

