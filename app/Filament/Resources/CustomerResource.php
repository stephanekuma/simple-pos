<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                Forms\Components\TextInput::make(name: 'firstname')
                    ->required()
                    ->maxLength(length: 20),
                Forms\Components\TextInput::make(name: 'lastname')
                    ->maxLength(length: 20),
                Forms\Components\TextInput::make(name: 'email')
                    ->email()
                    ->maxLength(length: 255)
                    ->nullable(),
                Forms\Components\TextInput::make(name: 'phone')
                    ->tel()
                    ->maxLength(length: 255)
                    ->nullable(),
                Forms\Components\TextInput::make('address')
                    ->nullable(),
                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->visibility(visibility: 'public')
                    ->disk(name: 'uploads')
                    ->directory(directory: 'customers')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'firstname')
                    ->label(label: 'Prénom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'lastname')
                    ->label(label: 'Nom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'email')
                    ->label(label: 'Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'phone')
                    ->label(label: 'Téléphone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'address')
                    ->label(label: 'Adresse')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make(name: 'avatar')
                    ->label(label: 'Photo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make(name: 'created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make(name: 'updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
