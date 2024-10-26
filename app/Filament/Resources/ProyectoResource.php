<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyectoResource\Pages;
use App\Filament\Resources\ProyectoResource\RelationManagers;
use App\Filament\Resources\ProyectoResource\Widgets\ProyectStatusOverview;
use App\Models\Proyecto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums;

class ProyectoResource extends Resource
{
    protected static ?string $model = Proyecto::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('descripcion')
                    ->required()
                    ->label('Descripción')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->required()
                    ->date()
                    ->label('Fecha de Inicio'),
                Forms\Components\DatePicker::make('fecha_termino')
                    ->date()
                    ->label('Fecha de Término')
                    ->minDate(function ($get) {
                        return $get('fecha_inicio');
                    }),
                Forms\Components\Select::make('estado')->options([
                    'Abierto' => 'Abierto',
                    'Cerrado' => 'Cerrado'
                ])->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable()
                    ->label('Descripción')
                    ->wrap(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->searchable()
                    ->label('Fecha de Inicio'),
                Tables\Columns\TextColumn::make('fecha_termino')
                    ->searchable()
                    ->label('Fecha de Término'),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable()
                    ->weight(Enums\FontWeight::Bold)
                    ->label('Estado')
                    ->badge(true)
                    ->colors([
                        'danger' => 'Abierto',  
                        'success' => 'Cerrado',    
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
                    'Abierto' => 'Abierto',  
                    'Cerrado' => 'Cerrado',  
                ])
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([ 
                    Tables\Actions\Action::make("detailsProyecto")->label('Detalle del Proyecto')
                    ->url(fn($record): string =>  self::getUrl('details', ['record' => $record]))
                    ->icon("heroicon-s-eye"),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
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
            RelationManagers\TareasRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProyectos::route('/'),
            'create' => Pages\CreateProyecto::route('/create'),
            'edit' => Pages\EditProyecto::route('/{record}/edit'),
            'details' => Pages\DetailsProyectos::route('/{record}/details')
        ];
    }

}
