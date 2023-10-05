<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigop',
        'articulo',
        'marca',
        'modelo',
        'oficina_id'
    ];

    public function oficina(){
        return  $this->belongsTo(Oficina::class);
    }

    public function solucion(){
        return $this->hasMany(Solucion::class);
    }
}
