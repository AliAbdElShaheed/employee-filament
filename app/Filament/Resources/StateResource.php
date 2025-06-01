<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 12;


    public static function form(Form $form): Form
    {
        return $form
            ->schema(State::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('State Name')
                    ->sortable()
//                    ->searchable(),
                    ->searchable(isIndividual: true),

                Tables\Columns\TextColumn::make('code')
                    ->label('State Code')
                    ->sortable()
                    ->searchable(),
//                    ->visible(auth()->check() && auth()->user()->can('viewAny', State::class)),

                Tables\Columns\TextColumn::make('phone_code')
                    ->searchable()
                    ->hidden(auth()->user()?->is_admin ? false : true),

                Tables\Columns\TextColumn::make('country.name')
                    ->searchable(isIndividual: true, isGlobal: false)
//                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('country.name', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'view' => Pages\ViewState::route('/{record}'),
            //'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
