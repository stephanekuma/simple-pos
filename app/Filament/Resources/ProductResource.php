<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\TextInput::make('barcode')
                //     ->required()
                //     ->unique(Product::class, 'barcode', ignoreRecord: true),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->suffix('XOF'),
                Forms\Components\TextInput::make('tax')
                    ->label('Tax (%)')
                    ->suffixIcon('heroicon-o-information-circle')
                    ->helperText('Example: 5 for 5% VAT/GST.')
                    ->numeric()
                    ->default(0.00),
                // Forms\Components\Textarea::make('description')
                //     ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->visibility(visibility: 'public')
                    ->disk(name: 'uploads')
                    ->directory(directory: 'products')
                    ->panelLayout('grid')
                    ->nullable(),
                // Forms\Components\TextInput::make('regular_price')
                //     ->numeric(),
                // Forms\Components\TextInput::make('quantity')
                //     ->required()
                //     ->numeric()
                //     ->default(1),
                // Forms\Components\Toggle::make('is_custom_product')
                //     ->required(),
                Forms\Components\Toggle::make('status')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->width(250)
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->size(50)
                    ->disk('uploads')
                    ->defaultImageUrl(url('/images/placeholder.jpg'))
                    ->extraImgAttributes(fn(Product $record): array => [
                        'alt' => "{$record->name} image",
                    ])
                    ->square(),
                // Tables\Columns\TextColumn::make('barcode')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('regular_price')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('quantity')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('tax')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('is_custom_product')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('status')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            // 'create' => Pages\CreateProduct::route('/create'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
