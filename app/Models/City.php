<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;


    protected $fillable = [
        'state_id',
        'name',
        'zip_code',
    ];




    // Scopes




    // Casts
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'state_id' => 'integer',
        ];
    }



    // Relations
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }


    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }



    // Functions
    public static function getFormSchema(): array
    {
        return [
            Select::make('state_id')
                ->relationship('state', 'name')
                ->native(false)
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('name')
                ->required()
                ->maxLength(100),
            TextInput::make('zip_code')
                ->maxLength(20),
        ];
    }


    public static function getInfolistSchema(): array
    {
        return [
            Section::make()
                ->columns(2)
                ->description('City Details')
                ->schema([
                    TextEntry::make('name')
                        ->label('City Name'),
                    TextEntry::make('zip_code')
                        ->label('Zip Code'),
                    TextEntry::make('state.name')
                        ->label('State Name')
                        ->badge(),
                    TextEntry::make('country.name')
                        ->label('Country Name')
                        ->getStateUsing(function ($record) {
                            return $record->state?->country?->name ?? 'N/A';
                        })
                        ->badge()
                        ->visible(fn(City $record) => $record->state?->country?->name !== null),
                ]),
        ];
    }
} // end of City model
