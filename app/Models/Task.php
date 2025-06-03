<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'employee_id',
    ];

    //scopes



    //casts
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'due_date' => 'date',
            'employee_id' => 'integer',
        ];
    }



    //relations
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }



    //functions
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->maxLength(255),
            DatePicker::make('due_date'),
            TextInput::make('status')
                ->maxLength(255),
            Select::make('employee_id')
                ->relationship('employee', 'name')
                ->native(false)
                ->multiple()
                ->searchable()
                ->preload(),
        ];
    }


    public static function getInfolistSchema(): array
    {
        return [
            Section::make('Task Details')
//                ->description('Details of the task')
                ->icon('heroicon-o-information-circle')
                ->columns(3)
                ->collapsible()
                ->schema(
                    [
                        TextEntry::make('title')
                            ->label('Task Title')
                            ->weight('bold')
                            ->size('lg'),


                        Group::make()
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                TextEntry::make('description')
                                    ->label('Description'),
                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->date(),
                                TextEntry::make('status')
                                    ->label('Status'),
                                TextEntry::make('employee.name')
                                    ->label('Assigned Employee')
                                    ->badge(),
                            ]),


                    ]
                ),

        ];
    }
} // end of Task model
