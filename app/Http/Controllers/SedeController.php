<?php

namespace App\Http\Controllers;
use App\Models\Sede;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class SedeController extends Controller
{
    public function index(Request $request){
        $query = Sede::query();


        if($request->has('nombre')){
            $nombreFilter = $request->input('nombre');
            $query->where('nombre', 'like', '%'. $nombreFilter .'%');
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
    }

    public function create(){

        return Inertia::render('Sede/Create');

    }

    public function store(Request $request){

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

    public function edit(Sede $sede) {

        return Inertia::render('Sede/Edit', [
            'sede' => $sede,
        ]);

    }

    public function update(Request $request, Sede $sede){

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

    public function destroy($id){

        $sede = Sede::find($id);
        $sede->delete();

        //return Inertia::location(route('sede.index'));
        return redirect()->route('sede.index');
    }
}
