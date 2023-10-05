<?php

namespace App\Http\Controllers;

use App\Models\Solucion;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Equipo;
use App\Models\TipoSolucion;
use Illuminate\Support\Facades\DB;



class SolucionController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Solucion::query();

        if ($request->has('nombre')) {
            $nombreFilter = $request->input('nombre');
            $query->where(function ($subquery) use ($nombreFilter) {
                $subquery->orWhere('id', 'like', '%' . $nombreFilter . '%')
                    ->orWhere('descripcion', 'like', '%' . $nombreFilter . '%')
                    ->orWhere('estado', 'like', '%' . $nombreFilter . '%')
                    ->orWhere('equipos.codigop', 'like', '%' . $nombreFilter . '%');
            });
        }


        // $incidencia = $query->get();
        $solucion = $query->with('incidencias', 'tipo_solucion')->get();
        //$dependencia = $query->paginate(1);


        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'equipo', 'label' => 'Equipo'],
            ['key' => 'incidencias.tipo_problema_id', 'label' => 'Problema'],
            ['key' => 'descripcion', 'label' => 'Descripción'],
            ['key' => 'estado', 'label' => 'Estado'],


        ];

        $incidenciasAtendidas = DB::table('solucions')
        ->where('estado', 'Atendido')
        ->count();

        $incidenciasRechazadas = DB::table('solucions')
        ->where('estado', 'Rechazado')
        ->count();
       // dd($solucion);
        return Inertia::render('Solucion/Table', [
            'solucion' => $solucion,
            'tableColumns' => $tableColumns,
            'incidenciasAtendidas' => $incidenciasAtendidas,
            'incidenciasRechazadas' => $incidenciasRechazadas,
        ]);
    }

    public function create($rowId)
    {
        $equipo = Equipo::all();
        $tipoSolucion = TipoSolucion::all();

        return Inertia::render('Solucion/Create', [
            'tipoSolucion' => $tipoSolucion,
            'rowsId' => $rowId, 
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|max:200|string',
            'estado' => 'required',
            'equipos' => 'required|max:30|string',
            'tipo_solucion_id' => 'required',
            'incidencias_id' => 'required',
        ]);

        Solucion::create($request->all());

        return redirect()->route('solucion.index')->with('message', 'Solución registrada');
    }


    public function edit(Solucion $solucion)
    {
        $equipo = Equipo::all();
        $tipoSolucion = TipoSolucion::all();
        $solucion->load('oficina', 'tipo_problema');
        //dd($incidencia);
        return Inertia::render('Incidencia/Edit', [
            'solucion' => $solucion,
            'tipoSolucion' => $tipoSolucion
        ]);
    }


    public function update(Request $request, Solucion $solucion)
    {
        $request->validate([
            'descripcion' => 'required|max:200|string',
            'estado' => 'required',
            'equipos' => 'required|max:30|string',
            'tipo_solucion_id' => 'required',
            'incidencias_id' => 'required',
        ]);

        $solucion->update($request->all());
        /*$dependencia->update([
            'nombre'=>$request->nombre,
            ]);*/

        //return redirect()->route('dependencia.index');
        return redirect()->route('solucion.index')->with('message', 'Solución actualizada correctamente');

    }


    public function destroy($id)
    {
        $solucion = Solucion::find($id);
        $solucion->delete();
        return redirect()->route('solucion.index');
    }
}