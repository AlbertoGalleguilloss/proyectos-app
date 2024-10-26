<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_termino',
        'estado',
        'id_usuario',
    ];

    public function tareas()
    {
        return $this->hasMany(Tarea::class,"id_proyecto");
    }
}
