<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficerResource\Pages;
use App\Filament\Resources\OfficerResource\RelationManagers;
use App\Models\Officer;
use App\Models\Position;

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
use Filament\Tables\Columns\BadgeColumn;

use Filament\Tables\Columns\TextColumn;

class OfficerResource extends Resource
{
    protected static ?string $model = Officer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Fieldset::make('Officer Information')
                    ->schema([
                        // ...
                        TextInput::make('fname')
                            ->autocomplete(false)
                            ->required()
                            ->placeholder('Enter First Name')
                            ->label('First Name'),
                        TextInput::make('mname')
                            ->autocomplete(false)
                            ->placeholder('Enter Middle Name')
                            ->label('Middle Name'),
                        // ->helperText(new HtmlString('Your <strong>full name</strong> here, including any middle names.')),
                        TextInput::make('lname')
                            ->placeholder('Enter Last Name')
                            ->autocomplete(false)
                            ->required()
                            ->label('Last Name'),
                    ])
                    ->columns(3),

                Fieldset::make('Officer Details')
                    ->schema([

                        TextInput::make('email')
                            ->placeholder('example@example.com')
                            ->autocomplete(false)
                            ->required()
                            ->label('Email Address'),


                        TextInput::make('phone')
                            ->numeric()
                            ->placeholder('91234567890')
                            ->length(10)
                            ->autocomplete(false)
                            ->required()
                            ->label('Contact Number')
                            ->prefix('+63'),

                        Select::make('position')
                            ->required()
                            ->label('Position')
                            ->options(Position::all()->pluck('name', 'id')),


                        // Select::make('class_schedule_id')
                        // ->required()
                        // ->label('Class Schedule')
                        // ->options(ClassSchedule::all()->pluck('name', 'id'))
                        // ->searchable(),

                        Radio::make('gender')
                            ->required()
                            ->label('Gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ])
                            ->inline()
                            ->inlineLabel(false),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('Position.name')
                    ->searchable()
                    ->sortable()
                    ->label('Position'),
                TextColumn::make('fname')
                    ->searchable()
                    ->sortable()
                    ->label('First Name'),
                TextColumn::make('mname')
                    ->searchable()
                    ->label('Middle Name'),
                TextColumn::make('lname')
                    ->searchable()
                    ->sortable()
                    ->label('Last Name'),
                // TextColumn::make('email')
                // ->label('Email Address'),
                BadgeColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500),
                BadgeColumn::make('phone')
                    ->label('Contact Number')
                    ->searchable()
                    ->copyable()
                    ->copyableState(fn(Officer $record): string => "Name: {$record->phone}"),
                // TextColumn::make('phone')
                //     ->label('Contact Number'),
                TextColumn::make('gender')
                    ->sortable()
                    ->label('Gender'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOfficers::route('/'),
            'create' => Pages\CreateOfficer::route('/create'),
            'edit' => Pages\EditOfficer::route('/{record}/edit'),
        ];
    }
}
