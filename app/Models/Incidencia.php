<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'dni',
        'celular',
        'tipo_problema_id',
        'oficina_id',
        'otros',
        
    ];

    public function tipo_problema(){
        return $this->belongsTo(TipoProblema::class);
    }

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

    public function solucion(){
        return $this->hasMany(Solucion::class);
    }
}
