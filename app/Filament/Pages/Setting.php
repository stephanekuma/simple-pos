<?php

namespace App\Filament\Pages;

use App\Models\Setting as SettingModel;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Setting extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.setting';

    public array $settings = [];

    public static function getNavigationLabel(): string
    {
        return 'Settings';
    }

    public function mount(): void
    {
        $this->settings = SettingModel::query()->pluck(column: 'value', key: 'key')->toArray();

        $this->settings['currency_symbol'] = $this->settings['currency_symbol'] ?? 'XOF';
    }

    public function save(): void
    {
        foreach ($this->settings as $key => $value) {
            SettingModel::query()->updateOrCreate(attributes: ['key' => $key], values: ['value' => $value]);
        }

        session()->flash('success', 'Settings updated successfully!');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('settings.site_name')
                ->label('Site Name')
                ->required(),
            TextInput::make('settings.site_email')
                ->label('Email')
                ->email(),
            Textarea::make('settings.site_description')
                ->label('Description'),
            TextInput::make('settings.currency_symbol')
                ->default('XOF')
                ->label('Currency symbol'),
        ]);
    }
}
