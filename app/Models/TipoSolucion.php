<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSolucion extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'estado'
    ];
    public function solucion(){
        return  $this->hasMany(Solucion::class);
    }
}
