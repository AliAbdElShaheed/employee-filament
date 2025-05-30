<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
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
                ->maxLength(255),
            TextInput::make('code')
                ->maxLength(255),
        ];
    }
} // end of Department model
