<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;


    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'department_id',
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'date_hired',
    ];



    // Scopes


    //Casts
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'country_id' => 'integer',
            'state_id' => 'integer',
            'city_id' => 'integer',
            'department_id' => 'integer',
            'date_of_birth' => 'date',
            'date_hired' => 'date',
        ];
    }





    // Relations
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }



    // Functions
    public static function getFormSchema(): array
    {
        return [
            Select::make('country_id')
                ->relationship('country', 'name'),
            Select::make('state_id')
                ->relationship('state', 'name'),
            Select::make('city_id')
                ->relationship('city', 'name'),
            Select::make('department_id')
                ->relationship('department', 'name')
                ->required(),
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->maxLength(255),
            TextInput::make('phone')
                ->tel()
                ->maxLength(255),
            TextInput::make('address')
                ->maxLength(255),
            DatePicker::make('date_of_birth'),
            DatePicker::make('date_hired'),
        ];
    }
} // end of Employee model
