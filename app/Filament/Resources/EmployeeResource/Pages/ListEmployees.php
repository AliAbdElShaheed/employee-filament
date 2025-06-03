<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),

            // 0 to 12 months experience
            '1 year experience' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $oneYearAgo = now()->subYear();
                    return $query->where('date_hired', '>=', $oneYearAgo);
                })
                ->badge(Employee::query()->where('date_hired', '>=', now()->subYear())->count())
                ->badgeColor('danger'),

            // between 1 and 3 years experience
            '1 : 3 years experience' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $threeYearsAgo = now()->subYears(3);
                    $oneYearAgo = now()->subYear();
                    return $query->where('date_hired', '>=', $threeYearsAgo)
                        ->where('date_hired', '<', $oneYearAgo);
                })
                ->badge(Employee::query()->whereBetween('date_hired', [now()->subYears(3), now()->subYear()])->count())
                ->badgeColor('warning'),

            // between 3 and 5 years
            '3 : 5 years experience' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $fiveYearsAgo = now()->subYears(5);
                    $threeYearsAgo = now()->subYears(3);
                    return $query->where('date_hired', '>=', $fiveYearsAgo)
                        ->where('date_hired', '<', $threeYearsAgo);
                })
                ->badge(Employee::query()->whereBetween('date_hired', [now()->subYears(5), now()->subYears(3)])->count())
                ->badgeColor('info'),

            // between 5 and 7 years experience
            '5 : 7 years experience' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $sevenYearsAgo = now()->subYears(7);
                    $fiveYearsAgo = now()->subYears(5);
                    return $query->where('date_hired', '>=', $sevenYearsAgo)
                        ->where('date_hired', '<', $fiveYearsAgo);
                })
                ->badge(Employee::query()->whereBetween('date_hired', [now()->subYears(7), now()->subYears(5)])->count())
                ->badgeColor('primary'),

            // more than 7 years experience
            '7+ years experience' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $sevenYearsAgo = now()->subYears(7);
                    return $query->where('date_hired', '<', $sevenYearsAgo);
                })
                ->badge(Employee::query()->where('date_hired', '<', now()->subYears(7))->count())
                ->badgeColor('success'),
        ];
    }

}
