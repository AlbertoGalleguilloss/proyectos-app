<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_responsable'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,"id_proyecto");
    }

    public function responsable()
    {
        return $this->belongsTo(User::class,"id_responsable");
    }
}
