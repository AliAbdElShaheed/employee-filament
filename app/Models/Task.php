<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                ->relationship('employee', 'name'),
        ];
    }
} // end of Task model
