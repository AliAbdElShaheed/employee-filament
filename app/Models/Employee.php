<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
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
            \Filament\Forms\Components\Section::make('Basic Information')
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
            \Filament\Forms\Components\Section::make('Location Information')
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
            \Filament\Forms\Components\Section::make('Employment Information')
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


    public static function getInfolistSchema(): array
    {
        return [
            Section::make('Employee Details')
                ->icon('heroicon-o-information-circle')
                ->columns(3)
                ->collapsible()
                ->schema([
                    TextEntry::make('name')
                        ->label('Full Name')
                        ->weight('bold'),
                    Group::make()
                        ->columnSpan(2)
                        ->columns(2)
                        ->schema([
                            TextEntry::make('email')
                                ->label('Email Address')
                                ->url(fn($record) => 'mailto:' . $record->email)
                                ->weight('medium'),
                            TextEntry::make('phone')
                                ->label('Phone Number'),
                            TextEntry::make('address')
                                ->label('Address')
                                ->limit(35),
                            TextEntry::make('date_of_birth')
                                ->label('Date of Birth')
                                ->date(),
                        ]),
                ]),

            Section::make('Employment Information')
                ->icon('heroicon-o-briefcase')
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextEntry::make('department.name')
                        ->label('Department'),
                    TextEntry::make('date_hired')
                        ->label('Date Hired')
                        ->date(),
                ]),
            Section::make('Location Information')
                ->icon('heroicon-o-map-pin')
                ->columns(3)
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextEntry::make('country.name')
                        ->label('Country'),
                    TextEntry::make('state.name')
                        ->label('State'),
                    TextEntry::make('city.name')
                        ->label('City'),
                ]),

        ];
    }
} // end of Employee model
