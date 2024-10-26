<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\RawJs;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function getNavigationLabel(): string
    {
        return 'Usuarios';
    }

    public static function getPluralLabel(): string
    {
        return 'Usuarios';
    }
    
    public static function getLabel(): string
    {
        return 'Usuario';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre')
                    ->visible(fn ($livewire) => !property_exists($livewire, 'isEditCredentials') || !$livewire::$isEditCredentials),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Correo Electrónico'),
                Forms\Components\TextInput::make('cargo')
                    ->required()
                    ->maxLength(255)
                    ->visible(fn ($livewire) => !property_exists($livewire, 'isEditCredentials') || !$livewire::$isEditCredentials),
                Forms\Components\TextInput::make('telefono')
                    ->required()
                    ->minLength(15)
                    ->label('Teléfono')
                   // ->mask('+{1} (000) 000-0000'),
                    ->mask(RawJs::make(<<<'JS'
                        $input.startsWith('34') || $input.startsWith('37') ? '9999 999999 99999' : '+56 9 9999 9999'
                    JS))
                    ->visible(fn ($livewire) => !property_exists($livewire, 'isEditCredentials') || !$livewire::$isEditCredentials),
                Forms\Components\Select::make('estado')
                    ->options([
                        'Operativo' => 'Operativo',
                        'Inactivo' => 'Inactivo'
                    ])
                    ->required()
                    ->visible(function ($livewire){
                        if($livewire instanceof \Filament\Resources\Pages\EditRecord){
                            if(!property_exists($livewire, 'isEditCredentials')){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->label('Contraseña')
                    ->visible(fn ($livewire) => isset($livewire::$isEditCredentials) && $livewire::$isEditCredentials),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->label('Correo Electrónico'),
                Tables\Columns\TextColumn::make('cargo')
                    ->searchable()
                    ->label('Cargo'),
                Tables\Columns\TextColumn::make('telefono')
                    ->searchable()
                    ->icon('heroicon-s-phone')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable()
                    ->weight(Enums\FontWeight::Bold)
                    ->label('Estado')
                    ->badge(true)
                    ->colors([
                        'danger' => 'Inactivo',  
                        'success' => 'Operativo',    
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de Creación')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('d-m-Y H:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de Edición')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('d-m-Y H:i:s'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                ->options([
                    'Inactivo' => 'Inactivo',  
                    'Operativo' => 'Operativo',  
                ])
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->visible(fn ($record) => $record->admin_maestro == false || ($record->admin_maestro == true && auth()->user()->admin_maestro == true)),
                    Tables\Actions\Action::make("editCredentials")->label('Editar Credenciales')
                    ->visible(fn ($record) => $record->admin_maestro == false || ($record->admin_maestro == true && auth()->user()->admin_maestro == true))
                    ->url(fn($record): string =>  self::getUrl('edit-credentials', ['record' => $record]))
                    ->icon("heroicon-m-pencil-square"),
                    Tables\Actions\DeleteAction::make()->visible(fn ($record) => $record->admin_maestro == false),
                ])->button()->label('Acciones')
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
            'edit-credentials' => Pages\EditCredentials::route('/{record}/edit-credentials')
        ];
    }
}
