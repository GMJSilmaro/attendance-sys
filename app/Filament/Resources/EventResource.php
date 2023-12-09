<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\Officer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\ColorColumn;

use Filament\Tables\Actions\DeleteAction as FilamentDeleteAction;
use Filament\Tables\Actions\EditAction as FilamentEditAction;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;


use Filament\Tables\Columns\TextColumn;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Menu';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('Event Information')
                    ->description('This section provides comprehensive details about the event, including date, time, location, and more.')
                    ->schema([
                        // ...
                        DatePicker::make('date')
                            ->label('Date Created')
                            ->readOnly()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(date('d/m/Y')),
                        TextInput::make('event_name')
                            ->autocomplete(false)
                            ->required()
                            ->placeholder('Enter Event Name')
                            ->label('Event Name'),
                        TextInput::make('place')
                            ->autocomplete(false)
                            ->required()
                            ->placeholder('Enter Event Place Name')
                            ->label('Place Name'),
                        // ->helperText(new HtmlString('Your <strong>full name</strong> here, including any middle names.')),
                        Select::make('status')
                            ->required()
                            ->label('Status')
                            ->options([
                                'Wholeday' => 'Wholeday',
                                'Half-day Morning' => 'Half-day Morning',
                                'Half-day Afternoon' => 'Half-day Afternoon',
                            ]),
                        Select::make('officers_id')
                            ->label('Officers Assigned')
                            ->options(Officer::all()->pluck('lname', 'id'))
                            ->searchable(),

                        Fieldset::make('Event Schedule')
                            ->schema([
                                // ...
                                DateTimePicker::make('starts_at')
                                    ->label('Starts At'),
                                DateTimePicker::make('ends_at')
                                    ->label('Ends At'),
                                DateTimePicker::make('timeIn')
                                    ->label('Attendance Time In'),
                                DateTimePicker::make('timeOut')
                                    ->label('Attendance Time Out'),
                            ])
                            ->columns(2),
                    ]),

                // Fieldset::make('Afternoon Schedule')
                // ->schema([
                //     // ...
                //     TimePicker::make('starts_at')
                //     ->required()
                //     ->label('Starts At'),
                //     TimePicker::make('ends_at')
                //     ->required()
                //     ->label('Ends At'),
                //     TimePicker::make('timeIn')
                //     ->required()
                //     ->label('Attendance Time In'),
                //     TimePicker::make('timeOut')
                //     ->required()
                //     ->label('Attendance Time Out'),
                // ])
                // ->columns(2),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('event_name')
                    ->searchable()
                    ->label('Event Name'),
                TextColumn::make('place')
                    ->searchable()
                    ->label('Place Name'),
                TagsColumn::make('status')
                    ->searchable(),
                // TextColumn::make('status')
                //     ->label('Status'),
                TextColumn::make('officers.lname')
                    ->searchable()
                    ->label('Officer Assigned'),
                TextColumn::make('starts_at')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ends_at')
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('timeIn'),
                // TextColumn::make('timeOut'),
                TextColumn::make('date')
                    ->sortable()
                    ->searchable()
                    ->label('Date Created'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                // FilamentEditAction::make()
                //     ->after(function ($record, FilamentEditAction $action) {
                //         $event = $record;
                //         $creator = auth()->user();

                //         // Get all users, including the creator
                //         $recipients = User::all();

                //         foreach ($recipients as $recipient) {
                //             $notification = Notification::make()
                //                 ->title("{$event->event_name} Event Updated!")
                //                 ->icon('heroicon-o-calendar')
                //                 ->iconColor('info')
                //                 ->body("The event '{$event->event_name}' on {$event->date} has been updated by {$creator->name}.")
                //                 ->actions([
                //                     Action::make('view')
                //                         ->button()
                //                         ->url(EventResource::getUrl('index', ['record' => $event]), true), // true for shouldOpenInNewTab
                //                 ])
                //                 ->toDatabase();

                //             // Notify each user
                //             $recipient->notify($notification);
                //         }
                //     }),
                FilamentDeleteAction::make()
                    ->after(function ($record, FilamentDeleteAction $action) {
                        $event = $record;
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
