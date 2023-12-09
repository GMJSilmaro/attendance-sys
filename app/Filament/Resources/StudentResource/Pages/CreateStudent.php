<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        $student = $this->getRecord();

        // Assuming you want to notify the authenticated user
        $recipient = auth()->user();

        Notification::make()
            ->title("{$student->lname}, {$student->fname} {$student->mname}.  Student Added!")
            ->icon('heroicon-o-users')
            ->iconColor('success')
            ->body("New student record created by: {$recipient->name}")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(StudentResource::getUrl('index', ['record' => $student]), shouldOpenInNewTab: true),
                Action::make('undo')
                    ->color('secondary')
                    ->emit('undoEditingEvent', [$student->id]),
            ])
            ->sendToDatabase($recipient);

        return $this->getResource()::getUrl('index');
    }
}
