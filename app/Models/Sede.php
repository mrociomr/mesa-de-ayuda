<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'direccion',
        'latitud',
        'longitud',
        'descripcion',
        'estado'
    ];

    public function oficina(){
        return $this->hasMany(Oficina::class);
    }
}
