<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Pages\Actions\EditAction as FilamentEditAction;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;


class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            FilamentEditAction::make()
            ->before(function (FilamentEditAction $action) {
                $event = $this->getRecord();
                $creator = auth()->user();

                // Get all users, including the creator
                $recipients = User::all();

                foreach ($recipients as $recipient) {
                    $notification = Notification::make()
                        ->title("{$event->event_name} Event Updated!")
                        ->icon('heroicon-o-arrow-path')
                        ->iconColor('info')
                        ->body("The event '{$event->event_name}' on {$event->date} has been updated by {$creator->name}.")
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->url(EventResource::getUrl('index', ['record' => $event]), true), // true for shouldOpenInNewTab
                        ])
                        ->toDatabase();

                    // Notify each user
                    $recipient->notify($notification);
                }
            }),
        ];
    }
}
