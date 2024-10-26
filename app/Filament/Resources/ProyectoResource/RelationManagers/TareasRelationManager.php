<?php

namespace App\Filament\Resources\ProyectoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;

class TareasRelationManager extends RelationManager
{
    protected static string $relationship = 'tareas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full')
                    ->label("Nombre"),
                Forms\Components\Textarea::make('descripcion')
                    ->required()
                    ->columnSpan('full')
                    ->label("Descripción"),
                Forms\Components\Select::make('id_responsable')
                ->relationship('responsable','name')
                ->searchable()
                ->preload()
                ->columnSpan('full')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            //->recordTitleAttribute('nombre')
            ->columns([
                Tables\Columns\TextColumn::make('nombre'),
                Tables\Columns\TextColumn::make('descripcion')->wrap(),
                Tables\Columns\TextColumn::make('responsable.name'),
                Tables\Columns\TextColumn::make('estado')
                ->badge(true)
                ->colors([
                    'danger' => 'Pendiente',  
                    'primary' => 'En Proceso',  
                    'success' => 'Completado',  
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('trabajarConLaTarea')
                    ->label('Trabajar con Esta Tarea')
                    ->icon("heroicon-m-wrench")
                    ->requiresConfirmation()
                    ->action(function ($record){
                        $record->estado="En Proceso";
                        $record->save();
                    })
                    ->visible(function ($record){
                        if($record->estado=="Pendiente" && $record->id_responsable==auth()->user()->id){
                            if($this->pageClass === "App\Filament\Resources\ProyectoResource\Pages\DetailsProyectos"){
                                return true;
                            }
                        }
                    }),
                Tables\Actions\Action::make('completarTarea')
                    ->label('Completar Esta Tarea')
                    ->icon("heroicon-s-check-circle")
                    ->requiresConfirmation()
                    ->action(function ($record){
                        $record->estado="Completado";
                        $record->save();

                        $existeTareas=false;
                        $hayTareaAbierta=false;
                        foreach($record->proyecto->tareas as $tarea){
                            $existeTareas=true;
                            if($tarea->estado=="En Proceso" || $tarea->estado=="Pendiente"){
                                $hayTareaAbierta=true;
                            }
                        }

                        if($existeTareas==true && $hayTareaAbierta==false){
                            $proyecto=$record->proyecto;
                            $proyecto->estado="Cerrado";
                            $proyecto->save();
                        }
                    })
                    ->visible(function ($record){
                        if($record->estado=="En Proceso" && $record->id_responsable==auth()->user()->id){
                            if($this->pageClass === "App\Filament\Resources\ProyectoResource\Pages\DetailsProyectos"){
                                return true;
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
