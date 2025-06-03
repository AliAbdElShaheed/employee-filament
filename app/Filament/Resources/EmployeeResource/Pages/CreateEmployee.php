<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;


    /*protected function getCreatedNotificationTitle(): ?string
    {
        return 'Employee created successfully';
    }*/


    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title($this->getCreatedNotificationTitle())
            ->success()
            ->seconds(5)
            ->body('The employee has been created successfully.')
            ->actions([
                Action::make('View')
                    ->url($this->getResource()::getUrl('view', ['record' => $this->getRecord()]))
                    ->color('success')
                    ->icon('heroicon-o-eye'),
                Action::make('undo')
                    ->color('gray')
                    ->icon('heroicon-o-arrow-uturn-down'),
            ]);
    }
}
