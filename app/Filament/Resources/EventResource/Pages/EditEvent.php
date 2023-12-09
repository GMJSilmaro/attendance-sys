<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\User;
use Filament\Actions;
use Filament\Pages\Actions\DeleteAction as FilamentDeleteAction;
use Filament\Pages\Actions\EditAction as FilamentEditAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            FilamentDeleteAction::make()
                ->before(function (FilamentDeleteAction $action) {
                    $event = $this->getRecord();
                    $creator = auth()->user();

                    // Get all users, including the creator
                    $recipients = User::all();

                    foreach ($recipients as $recipient) {
                        $notification = Notification::make()
                            ->title("{$event->event_name} Event Deleted!")
                            ->icon('heroicon-o-trash')
                            ->iconColor('danger')
                            ->body("The event '{$event->event_name}' on {$event->date} has been deleted by {$creator->name}.")
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

    protected function getRedirectUrl(): string
    {
        $event = $this->getRecord();
        $creator = auth()->user();

        // Get all users, including the creator
        $recipients = User::all();

        // Store the old event name in the session
        session(['old_event_name' => $event->event_name]);

        // Notify about the update to all users
        foreach ($recipients as $recipient) {
            $notification = Notification::make()
                ->title("{$event->event_name} Event Updated!")
                ->icon('heroicon-o-arrow-path')
                ->iconColor('info')
                ->body("The event '" . session('old_event_name') . "' has been updated on {$event->date} by {$creator->name}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(EventResource::getUrl('view', ['record' => $event]), shouldOpenInNewTab: true),
                    Action::make('undo')
                        ->color('secondary')
                        ->emit('undoEditingEvent', [$event->id]),
                ])
                ->toDatabase();

            // Notify each user
            $recipient->notify($notification);
        }

        // Clear the session variable
        session()->forget('old_event_name');

        return $this->getResource()::getUrl('index');
    }


}
