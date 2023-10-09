<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SedeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('sede.index')) {

            $query = Sede::query();


            if ($request->has('nombre')) {
                $nombreFilter = $request->input('nombre');
                $query->where('nombre', 'like', '%' . $nombreFilter . '%');
            }

            $sede = $query->get();

            $tableColumns = [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'nombre', 'label' => 'Nombre'],
                ['key' => 'direccion', 'label' => 'Dirección'],
                ['key' => 'latitud', 'label' => 'Latitud'],
                ['key' => 'longitud', 'label' => 'Longitud'],
                ['key' => 'estado', 'label' => 'Estado'],
            ];

            return Inertia::render('Sede/Table', [
                'sede' => $sede,
                'tableColumns' => $tableColumns,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        if (Auth::user()->can('sede.create')) {

            return Inertia::render('Sede/Create');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|unique:sedes|max:150',
            'direccion' => 'required|max:150',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'estado' => 'required',
            'descripcion' => 'nullable'
        ]);

        Sede::create($request->all());

        return redirect()->route('sede.index')->with('message', 'Sede creada');
        //  return Inertia::location(route('sede.index'));

    }

    public function edit(Sede $sede)
    {
        if (Auth::user()->can('sede.edit')) {

            return Inertia::render('Sede/Edit', [
                'sede' => $sede,
            ]);
        } else {
            return redirect()->route('dashboard');
        }

    }

    public function update(Request $request, Sede $sede)
    {

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('sedes')->ignore($sede->id),
            ],
            'direccion' => 'required|max:150',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'estado' => 'required',
            'descripcion' => 'nullable'
        ]);

        $sede->update($request->all());

        return redirect()->route('sede.index')->with('message', 'Sede actualizada');
        //return Inertia::location(route('sede.index'));
    }

    public function destroy($id)
    {
        if (Auth::user()->can('sede.destroy')) {

            $sede = Sede::find($id);
            $sede->delete();

            //return Inertia::location(route('sede.index'));
            return redirect()->route('sede.index');

        } else {
            return redirect()->route('dashboard');
        }
    }
}
