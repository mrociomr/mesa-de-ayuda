<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipoController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Equipo::query();

        if ($request->has('nombre')) {
            $nombreFilter = $request->input('nombre');
            $query->where('nombre', 'like', '%' . $nombreFilter . '%');
        }

        $equipo = $query->get();
        //$dependencia = $query->paginate(1);


        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'codigop', 'label' => 'Codigo'],
            ['key' => 'articulo', 'label' => 'Articulo'],
            ['key' => 'marca', 'label' => 'Marca'],
            ['key' => 'oficina_id', 'label' => 'Oficina'],

        ];

        return Inertia::render('Equipo/Table', [
            'equipo' => $equipo,
            'tableColumns' => $tableColumns,
        ]);
    }

    public function create()
    {
        return Inertia::render('Equipo/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigop' => 'required',
            'articulo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'oficina_id' => 'required'
        ]);

        Equipo::create($request->all());

        return redirect()->route('equipo.index');
    }


    public function edit(Equipo $equipo)
    {
        return Inertia::render('Equipo/Edit', [
            'equipo' => $equipo,
        ]);
    }


    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'codigop' => 'required',
            'articulo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'oficina_id' => 'required'
        ]);

        $equipo->update($request->all());
        /*  $dependencia->update([
            'nombre'=>$request->nombre,
            ]);
        */

        //return redirect()->route('dependencia.index');
        return redirect()->route('equipo.index')->with('message', 'Equipo Updated Successfully');

    }


    public function destroy($id)
    {
        $equipo = Equipo::find($id);
        $equipo->delete();
        return redirect()->route('equipo.index');
    }

}
