<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
        'phone_code',
    ];
    // Scopes



    //casts
    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }




    //Relations
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }


    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }



    //functions

    public static function getFormSchema()
    {
        return [

                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                TextInput::make('code')
                    ->required()
                    ->maxLength(4),
                TextInput::make('phone_code')
                    ->tel()
                    ->required()
                    ->maxLength(5),
            ];
    }


    public static function getInfolistSchema(): array
    {
        return [
            Section::make()
                ->columns(3)
                ->description('Country Details')
                ->schema([
                    TextEntry::make('name')
                        ->label('Country Name'),
                    TextEntry::make('code')
                        ->label('Country Code'),
                    TextEntry::make('phone_code')
                        ->Icon('heroicon-o-phone')
                        ->label('Phone Code'),
                ]),
        ];
    }
} // end of country model
