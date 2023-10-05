<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Oficina;
use App\Models\Solucion;
use App\Models\TipoProblema;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class IncidenciaController extends Controller
{
    
    public function index(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'nombre' => 'string|nullable',
        ]);

        $query = Incidencia::query();

        if ($request->has('nombre')) {
            $nombreFilter = $request->input('nombre');
            $query->where(function ($subquery) use ($nombreFilter) {
                $subquery->orWhere('dni', 'like', '%' . $nombreFilter . '%')
                    ->orWhere('celular', 'like', '%' . $nombreFilter . '%')
                    ->orWhereHas('tipo_problema', function ($subsubquery) use ($nombreFilter) {
                        $subsubquery->where('nombre', 'like', '%' . $nombreFilter . '%');
                    });
            });
        }

        //$incidencias = $query->with('oficina', 'tipo_problema')->get();
        $incidencias = $query->select('incidencias.*')
        ->from('incidencias')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('solucions')
                ->whereColumn('solucions.incidencias_id', 'incidencias.id');
        })
        ->with('oficina', 'tipo_problema')
        ->orderBy('created_at', 'desc')
        ->get();

        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'dni', 'label' => 'DNI'],
            ['key' => 'celular', 'label' => 'Celular'],
            ['key' => 'tipo_problema.nombre', 'label' => 'Problema'],
            ['key' => 'oficina.nombre', 'label' => 'Oficina'],
        ];

        $incidenciasPendientes = DB::table('incidencias')
        ->leftJoin('solucions', 'incidencias.id', '=', 'solucions.incidencias_id')
        ->whereNull('solucions.incidencias_id')
        ->count();

        return Inertia::render('Incidencia/Table', [
            'incidencia' => $incidencias,
            'tableColumns' => $tableColumns,
            'incidenciasPendientes' => $incidenciasPendientes,
        ]);
    }



    public function create()
    {
        $oficinas = Oficina::all();
        $tiposProblema = TipoProblema::all();
        //dd($oficinas);
        return Inertia::render('Incidencia/Create', [
            'oficinas' => $oficinas,
            'tiposProblema' => $tiposProblema,
        ]);
    }

     public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|digits:8|numeric',
            'celular' => 'required|digits:9|numeric',
            'tipo_problema_id' => 'required',
            'oficina_id' => 'required',
        ]);

        Incidencia::create($request->all());


        return redirect()->route('incidencia.index')->with('message', 'Incidencia creada');
        //return Inertia::location(route('incidencia.index'));

    }

    public function edit(Incidencia $incidencia)
    {
        $oficinas = Oficina::all();
        $tiposProblema = TipoProblema::all();
        $incidencia->load('oficina', 'tipo_problema');
        //dd($incidencia);
        return Inertia::render('Incidencia/Edit', [
            'incidencia' => $incidencia,
            'oficinas' => $oficinas,
            'tiposProblema' => $tiposProblema,
        ]);
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'dni' => 'required|digits:8|numeric',
            'celular' => 'required|digits:9|numeric',
            'tipo_problema_id' => 'required',
            'oficina_id' => 'required',
        ]);

        $incidencia->update($request->all());
        /*  $dependencia->update([
            'nombre'=>$request->nombre,
            ]);
        */

        return redirect()->route('incidencia.index');
        //return Inertia::location(route('incidencia.index'));

    }


    public function destroy($id)
    {
        $incidencia = Incidencia::find($id);
        $incidencia->delete();

        return redirect()->route('incidencia.index');
        //return Inertia::location(route('incidencia.index'));
    }

}
