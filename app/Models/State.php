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

class State extends Model
{
    use HasFactory;


    protected $fillable = [
        'country_id',
        'name',
        'code',
        'phone_code',
    ];


    // Scopes



    // Casts
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'country_id' => 'integer',
        ];
    }





    // Relations
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }


    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }




    // Functions
    public static function getFormSchema($countryId = null): array
    {
        return [
            Select::make('country_id')
                ->relationship('country', 'name')
                ->native(false)
                ->searchable()
                ->preload()
                ->hidden(function () use ($countryId) {
                    return $countryId !== null;
                })
                ->required(),
            TextInput::make('name')
                ->required()
                ->maxLength(100),
            TextInput::make('code')
                ->maxLength(5),
            TextInput::make('phone_code')
                ->tel()
                ->maxLength(5),
        ];

    }


    public static function getInfolistSchema(): array
    {
        return [
            Section::make()
                ->columns(2)
                ->description('State Details')
                ->schema([
                    TextEntry::make('name')
                        ->label('State Name'),
                    TextEntry::make('code')
                        ->label('State Code'),
                    TextEntry::make('phone_code')
                        ->label('Phone Code'),
                    TextEntry::make('country.name')
                        ->label('Country Name')
                        ->badge(),
                ]),
        ];
    }


} // end of State model
