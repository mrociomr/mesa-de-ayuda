<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solucion extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'estado',
        'equipos',
        'tipo_solucion_id',
        'incidencias_id',
    ];

    public function equipo(){
        return $this->belongsTo(Equipo::class);
    }
    public function tipo_solucion(){
        return $this->belongsTo(TipoSolucion::class);
    }

    public function incidencias(){
        return $this->belongsTo(Incidencia::class);
    }
}
