<?php

namespace App\Filament\Resources\ProyectoResource\Widgets;

use App\Models\Proyecto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProyectStatusOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Proyectos Abiertos', Proyecto::where("estado","=","Abierto")->count()),
            Stat::make('Proyectos Cerrados', Proyecto::where("estado","=","Cerrado")->count()),
        ];
    }
}
