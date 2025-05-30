<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
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



    //functions

    public static function getFormSchema()
    {
        return [

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_code')
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ];
    }
} // end of country model
