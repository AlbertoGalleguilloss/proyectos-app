<?php

namespace App\Filament\Resources\ProyectoResource\Widgets;

use App\Models\Proyecto;
use Filament\Widgets\ChartWidget;

class ProyecStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Estados de los Proyectos',
                    'data' => [Proyecto::where("estado","=","Abierto")->count(), Proyecto::where("estado","=","Cerrado")->count()],
                    'backgroundColor' => ['#FF0000',' #0000ff'],
                    'borderColor' => ['#f85f5f','#6464c8'],
                ],
            ],
            'labels' => ['Abierto', 'Cerrado'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
