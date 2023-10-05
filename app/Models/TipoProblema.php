<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProblema extends Model
{
    use HasFactory;
    protected  $fillable = [
        'nombre',
        'prioridad',
        'estado'
    ];

    public function incidencia(){
        return $this->hasMany(Incidencia::class);
    }
}
