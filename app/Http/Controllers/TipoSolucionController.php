<?php

namespace App\Http\Controllers;

use App\Models\TipoSolucion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;


class TipoSolucionController extends Controller
{
    
    public function index(Request $request)
    {
        $query = TipoSolucion::query();

        if ($request->has('nombre')) {
            $nombreFilter = $request->input('nombre');
            $query->where(function ($subquery) use ($nombreFilter) {
                $subquery->orWhere('nombre', 'like', '%' . $nombreFilter . '%')
                    ->orWhere('estado', 'like', '%' . $nombreFilter . '%');
            });
        }

        $tipoSolucion = $query->get();

        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'nombre', 'label' => 'Nombre'],          
            ['key' => 'estado', 'label' => 'Estado'],

        ];

        return Inertia::render('TipoSolucion/Table', [
            'tipoSolucion' => $tipoSolucion,
            'tableColumns' => $tableColumns,
        ]);
    }

    public function show($id)
    {
        $tipoSolucion = TipoSolucion::find($id);

        if (!$tipoSolucion) {
            return response()->json(['error' => 'Tipo de solución no encontrado'], 404);
        }

        return response()->json(['data' => $tipoSolucion]);
    }

    public function create()
    {
        return Inertia::render('TipoSolucion/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:tipo_solucions|max:100',
            'estado' => 'required',
        ]);

        TipoSolucion::create($request->all());

        return redirect()->route('tipo-solucion.index')->with('message', 'Tipo de solución creada');
        //return Inertia::location(route('tipo-solucion.index'));

    }

    public function edit(TipoSolucion $tipoSolucion)
    {
        return Inertia::render('TipoSolucion/Edit', [
            'tipoSolucion' => $tipoSolucion,
        ]);
    }


    public function update(Request $request, TipoSolucion $tipoSolucion)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tipo_solucions')->ignore($tipoSolucion->id),
            ],
            'estado' => 'required',
        ]);
        

        $tipoSolucion->update($request->all());

        return redirect()->route('tipo-solucion.index')->with('message', 'Tipo de solución actualizado');
        //return Inertia::location(route('tipo-solucion.index'));

    }


    public function destroy($id)
    {
        $tipoSolucion = TipoSolucion::find($id);
        $tipoSolucion->delete();

        return redirect()->route('tipo-solucion.index');
        //return Inertia::location(route('tipo-solucion.index'));

    }
}
