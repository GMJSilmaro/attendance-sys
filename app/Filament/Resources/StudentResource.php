<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use App\Models\ClassSchedule;
use App\Models\Course;
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
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TagsColumn;

use Filament\Tables\Columns\TextColumn;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Fieldset::make('Student Information')
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

                Fieldset::make('Student Details')
                    ->schema([
                        // ...
                        Select::make('course_id')
                            ->label('Course Code')
                            ->required()
                            ->options(Course::all()->pluck('description', 'id')),
                        Select::make('year')
                            ->required()
                            ->options([
                                '1st' => '1st Year',
                                '2nd' => '2nd Year',
                                '3rd' => '3rd Year',
                                '4th' => '4th Year',
                                '5th' => '5th Year',
                            ]),
                        Select::make('class_schedule_id')
                            ->required()
                            ->label('Class Schedule')
                            ->options(ClassSchedule::all()->pluck('name', 'id'))
                            ->searchable(),

                        Radio::make('gender')
                            ->required()
                            ->label('Gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ])
                            ->inline()
                            ->inlineLabel(false),

                        TextInput::make('role')
                            ->readOnly()
                            ->hidden()
                            ->default('2'),
                        // Select::make('createdBy')
                        // ->required()
                        // ->label('Created by')
                        // ->options(User::all()->pluck('name', 'id')),
                    ])
                    ->columns(2),
            ]);

        // Radio::make('feedback')
        //         ->label('Like this post??')
        //         ->boolean()
        //         ->inline()
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('fname')
                    ->searchable()
                    ->label('First Name'),
                TextColumn::make('mname')
                    ->searchable()
                    ->label('Middle Name'),
                TextColumn::make('lname')
                    ->searchable()
                    ->label('Last Name'),
                TagsColumn::make('course.name')
                    ->searchable()
                    ->label('Course'),
                TagsColumn::make('year')
                    ->searchable()
                    ->label('Year'),
                TagsColumn::make('ClassSchedule.name')
                    ->searchable()
                    ->label('Schedule'),
                TextColumn::make('gender')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
