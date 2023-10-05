<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Oficina extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    use HasFactory;

    protected $fillable = [
        'nombre',
        'abreviatura',
        'nivel',
        'prioridad',
        'estado',
        'sede_id',
        'dependencia_id',
        'password'

    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }
    public function equipo()
    {
        return $this->hasMany(Equipo::class);
    }
    public function incidencia()
    {
        return $this->hasMany(Incidencia::class);
    }

}
