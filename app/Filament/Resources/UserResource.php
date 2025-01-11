<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): string
    {
        return 'User Management'; // Nama grup di sidebar
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Name Field
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Email Field
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                // Password Field
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->visibleOn('create'), // Only show on create form

                // Role Field

                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->required()
                    ->preload()
                    ->searchable(),// Default role
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Name Column
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                // Email Column
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                // Role Column
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->color('primary'),

                // Created At Column
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Updated At Column
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Role Filter
                Tables\Filters\SelectFilter::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->searchable(),
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
            // No relations for now
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
