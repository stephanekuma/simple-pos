<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Payment;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class FinancialReports extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.financial-reports';

    protected static ?string $navigationLabel = 'Rapports Financiers';

    protected static ?string $title = 'Rapports Financiers';

    protected static ?int $navigationSort = 10;

    public string $period = 'daily';

    public ?string $customStartDate = null;

    public ?string $customEndDate = null;

    public function mount(): void
    {
        $this->customStartDate = now()->startOfMonth()->format('Y-m-d');
        $this->customEndDate = now()->format('Y-m-d');
    }

    public function getReportData(): array
    {
        $periods = $this->getPeriodDates();

        return [
            'total_orders' => Order::whereBetween('created_at', [$periods['start'], $periods['end']])->count(),
            'total_revenue' => Payment::whereBetween('created_at', [$periods['start'], $periods['end']])->sum('amount'),
            'average_order' => Order::whereBetween('created_at', [$periods['start'], $periods['end']])->avg('total_price') ?? 0,
            'orders_by_day' => $this->getOrdersByDay($periods['start'], $periods['end']),
            'top_products' => $this->getTopProducts($periods['start'], $periods['end']),
            'period_label' => $periods['label'],
            'start_date' => $periods['start']->format('d/m/Y'),
            'end_date' => $periods['end']->format('d/m/Y'),
        ];
    }

    protected function getPeriodDates(): array
    {
        return match ($this->period) {
            'daily' => [
                'start' => now()->startOfDay(),
                'end' => now()->endOfDay(),
                'label' => "Aujourd'hui",
            ],
            'weekly' => [
                'start' => now()->startOfWeek(),
                'end' => now()->endOfWeek(),
                'label' => 'Cette semaine',
            ],
            'monthly' => [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
                'label' => 'Ce mois',
            ],
            'quarterly' => [
                'start' => now()->startOfQuarter(),
                'end' => now()->endOfQuarter(),
                'label' => 'Ce trimestre',
            ],
            'semi_annual' => [
                'start' => now()->month <= 6
                    ? now()->startOfYear()
                    : now()->startOfYear()->addMonths(6),
                'end' => now()->month <= 6
                    ? now()->startOfYear()->addMonths(6)->subDay()
                    : now()->endOfYear(),
                'label' => 'Ce semestre',
            ],
            'annual' => [
                'start' => now()->startOfYear(),
                'end' => now()->endOfYear(),
                'label' => 'Cette année',
            ],
            'custom' => [
                'start' => Carbon::parse($this->customStartDate)->startOfDay(),
                'end' => Carbon::parse($this->customEndDate)->endOfDay(),
                'label' => 'Période personnalisée',
            ],
            default => [
                'start' => now()->startOfDay(),
                'end' => now()->endOfDay(),
                'label' => "Aujourd'hui",
            ],
        };
    }

    protected function getOrdersByDay(Carbon $start, Carbon $end): Collection
    {
        return Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_price) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    protected function getTopProducts(Carbon $start, Carbon $end): Collection
    {
        return \App\Models\OrderItem::selectRaw('name as product_name, SUM(quantity) as total_qty, SUM(price) as total_revenue')
            ->whereHas('order', fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->groupBy('name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();
    }

    public function updatedPeriod(): void
    {
        // Livewire will automatically re-render
    }
}

