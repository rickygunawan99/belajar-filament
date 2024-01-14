<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use App\Filament\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTreatment extends EditRecord
{
    protected static string $resource = TreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('star')
                ->icon('heroicon-m-star')
                ->action(function () {
                    return Notification::make()
                        ->title('Created')
                        ->body('Successfully clicked')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Successfully Edit')
            ->body('Treatment successfully updated')
            ->success();
    }
}
