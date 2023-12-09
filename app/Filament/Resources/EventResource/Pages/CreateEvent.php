<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\User;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Filament\Notifications\Livewire\DatabaseNotifications;


class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        $event = $this->getRecord();

        $creator = auth()->user();

        // Get all users, including the creator
        $recipients = User::all();

        foreach ($recipients as $recipient) {
            $recipient->notify(
                Notification::make()
                    ->title("{$event->event_name} Event Added!")
                    ->icon('heroicon-o-bell-alert')
                    ->iconColor('success')
                    ->body("{$event->date} View the CALENDAR page for more info about the event Created by: {$creator->name} ")
                    ->actions([
                        Action::make('view')
                            ->button()
                            ->url(EventResource::getUrl('view', ['record' => $event]), shouldOpenInNewTab: true),
                        Action::make('undo')
                            ->color('secondary')
                            ->emit('undoEditingEvent', [$event->id]),
                    ])
                    ->toDatabase(),
            );
        }

        DatabaseNotifications::trigger('filament-notifications.database-notifications-trigger');
        return $this->getResource()::getUrl('index');
    }

    public function toDatabase(User $notifiable): array
    {

        return Notification::make()
            ->title('Saved successfully')
            ->getDatabaseMessage();
    }

}
