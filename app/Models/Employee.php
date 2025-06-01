<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
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
            Section::make('Basic Information')
                ->description('Fill in the basic information of the employee.')
                ->columns(2)
                ->collapsible()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->tel()
                        ->maxLength(255),
                    DatePicker::make('date_of_birth'),
                ]),
            Section::make('Location Information')
                ->description('Select the location details of the employee.')
                ->columns(3)
                ->collapsible()
                ->schema([
                    Select::make('country_id')
                        ->relationship('country', 'name')
                        ->native(false)
                        ->searchable()
                        ->preload(),
                    Select::make('state_id')
                        ->relationship('state', 'name')
                        ->native(false)
                        ->searchable()
                        ->preload(),
                    Select::make('city_id')
                        ->relationship('city', 'name')
                        ->native(false)
                        ->searchable()
                        ->preload(),
                    TextInput::make('address')
                        ->maxLength(255)
                    ->columnSpanFull(),
                ]),
            Section::make('Employment Information')
                ->description('Fill in the employment details of the employee.')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Select::make('department_id')
                        ->relationship('department', 'name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->required(),
                    DatePicker::make('date_hired'),
                ]),


        ];
    }
} // end of Employee model
