<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
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

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ColorColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Fieldset::make('User Details')
                ->schema([
                    // ...

                    TextInput::make('name')
                    ->autocomplete(false)
                    ->required()
                    ->placeholder('Enter Username')
                    ->label('Name'),
                    TextInput::make('email')
                    ->autocomplete(false)
                    ->required()
                    ->placeholder('example@example.com')
                    ->label('Email Address'),
                    // ->helperText(new HtmlString('Your <strong>full name</strong> here, including any middle names.')),
                    TextInput::make('password')
                    ->placeholder('Enter Password')
                    ->autocomplete(false)
                    ->required()
                    ->password()
                    ->hiddenOn('edit')
                    ->label('Password'),

                    Select::make('role')
                    ->required()
                    ->label('Role')
                    ->options(Role::all()->pluck('name', 'id')),
                ])
                ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
                BadgeColumn::make('email')
                ->copyable()
                ->copyMessage('Email address copied')
                ->copyMessageDuration(1500),
                TagsColumn::make('roles.name'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
