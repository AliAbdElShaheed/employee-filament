<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
} // end of City model
