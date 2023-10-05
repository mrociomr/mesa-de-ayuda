<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oficina;
use App\Models\Sede;
use App\Models\Dependencia;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class OficinaController extends Controller
{
    public function index(Request $request)
    {
        $query = Oficina::query();

        if($request->has('nombre')){
            $nombreFilter = $request->input('nombre');
            $query->where('nombre', 'like', '%'. $nombreFilter .'%');
        }

        // $incidencia = $query->get();
        $oficina = $query->with('sede', 'dependencia')->get();

        //$dependencia = $query->paginate(1);

        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'nombre', 'label' => 'Oficina'],
            ['key' => 'sede.nombre', 'label' => 'Sede'],
            ['key' => 'dependencia.nombre', 'label' => 'Dependencia'],
            ['key' => 'estado', 'label' => 'Estado'],
        ];

        // dd($incidencia);
        return Inertia::render('Oficina/Table', [
            'oficina' => $oficina,
            'tableColumns' => $tableColumns,

        ]);
    }

    public function show($id){
        $oficina = Oficina::find($id);

        $data = [
            $oficina,
            $oficina->sede,
            $oficina->dependencia
        ];

        return Inertia::render('Oficina/Show',
            ['data' => $data]
        );

        //dd($data);
    }

    public function create()
    {
        $sedes = Sede::all();
        $dependencias = Dependencia::all();

        //dd($oficinas);
        return Inertia::render('Oficina/Create', [
            'sedes' => $sedes,
            'dependencias' => $dependencias,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:oficinas|max:255',
            'abreviatura' => 'required|unique:oficinas',
            'nivel' => 'required|numeric|between:1,5',
            'prioridad' => 'required|numeric|between:1,5',
            'estado' => 'required',
            'sede_id' => 'required',
            'dependencia_id' => 'required',
            'password' => 'required'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));

        Oficina::create($data);

        return redirect()->route('oficina.index')->with('message','Oficina creada');
        //return Inertia::location(route('oficina.index'));
    }

    public function edit(Oficina $oficina)
    {
        $sedes = Sede::all();
        $dependencias = Dependencia::all();

        $oficina->load('sede', 'dependencia');
        //dd($incidencia);
        return Inertia::render('Oficina/Edit', [
            'oficina' => $oficina,
            'sede' => $sedes,
            'dependencia' => $dependencias,

        ]);
    }

    public function update(Request $request, Oficina $oficina)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('oficinas')->ignore($oficina->id),
            ],
            'abreviatura' => [
                'required',
                'string',
                'max:10',
                Rule::unique('oficinas')->ignore($oficina->id),
            ],
            'nivel' => 'required|numeric|between:1,5',
            'prioridad' => 'required|numeric|between:1,5',
            'estado' => 'required',
            'sede_id' => 'required',
            'dependencia_id' => 'required',
            'password' => 'required'
        ]);

        if ($request->has('password')) {
            // Hashear la nueva contraseña antes de actualizarla
            $request->merge(['password' => Hash::make($request->input('password'))]);
        }

        $oficina->update($request->all());

        return redirect()->route('oficina.index')->with('message', 'Oficina actualizada');
        //return Inertia::location(route('oficina.index'));
    }

    public function destroy($id)
    {
        $oficina = Oficina::find($id);
        $oficina->delete();

        return redirect()->route('oficina.index');
        //return Inertia::location(route('oficina.index'));
    }
}
