<?php

namespace App\Filament\Resources\ProyectoResource\Pages;

use App\Filament\Resources\ProyectoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class DetailsProyectos extends ViewRecord
{
    protected static string $resource = ProyectoResource::class;

    public static bool $isDetailsProyectos = true;

    protected static ?string $title = 'Detalle del Proyecto';
}
