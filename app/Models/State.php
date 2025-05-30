<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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




    // Functions
    public static function getFormSchema(): array
    {
        return [
            Select::make('country_id')
                ->relationship('country', 'name')
                ->required(),
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('code')
                ->maxLength(255),
            TextInput::make('phone_code')
                ->tel()
                ->maxLength(255),
        ];

    }
} // end of State model
