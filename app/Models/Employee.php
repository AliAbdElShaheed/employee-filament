<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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
                    DatePicker::make('date_of_birth')
                        ->native(false)
                        ->prefixIcon('heroicon-o-cake')
                        ->prefixIconColor('primary')
                        ->displayFormat('d/m/Y')
                        ->firstDayOfWeek(6)
                        ->closeOnDateSelection()
                        ->minDate(now()->subYears(35))
                        ->maxDate(now()->addYears(18)),
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
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('state_id', null);
                            $set('city_id', null);
                        }),
                    Select::make('state_id')
                        ->options(fn(Get $get): Collection => State::query()
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id'))
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(fn(Set $set) => $set('city_id', null)),
                    Select::make('city_id')
                        ->options(fn(Get $get): Collection => City::query()
                            ->where('state_id', $get('state_id'))
                            ->pluck('name', 'id'))
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->live(),
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
                    DatePicker::make('date_hired')
                        ->native(false)
                        ->displayFormat('d/m/Y')
//                        ->firstDayOfWeek(7)
                        ->weekStartsOnSunday()
                        ->disabledDates(['2025-06-06', '2025-06-13', '2025-06-20'])
                        ->closeOnDateSelection()
                        ->prefix('Starts')
                        ->suffixIcon('heroicon-o-calendar'),
                ]),


        ];
    }
} // end of Employee model
