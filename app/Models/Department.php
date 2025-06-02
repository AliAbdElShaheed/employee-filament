<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
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


    public static function getInfolistSchema(): array
    {
        return [
            Section::make('Department Details')
                ->columns(3)
                ->schema([
                    TextEntry::make('name')
                        ->label('Department Name'),
                    TextEntry::make('code')
                        ->label('Department Code'),
                    TextEntry::make('employees_count')
                        ->label('Number of Employees')
                        ->getStateUsing(function ($record) {
                            return $record->employees()->count();
                        })->formatStateUsing(function ($state) {
                            return number_format($state);
                        })
                        ->badge(),
                ]),

        ];
    }
} // end of Department model
