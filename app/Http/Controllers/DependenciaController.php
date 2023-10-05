<?php

namespace App\Http\Controllers;

use App\Http\Resources\DependenciaResource;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class DependenciaController extends Controller
{


    public function index(Request $request)
    {
       // if (Auth::user()->can('dependencia.index')) {
            $query = Dependencia::query();

            if ($request->has('nombre')) {
                $nombreFilter = $request->input('nombre');
                $query->where('nombre', 'like', '%' . $nombreFilter . '%');
            }

            $dependencia = $query->get();
            //$dependencia = $query->paginate(1);

            $tableColumns = [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'nombre', 'label' => 'Nombre'],

            ];

            return Inertia::render('Dependencia/Table', [
                'dependencia' => $dependencia,
                'tableColumns' => $tableColumns,
            ]);

      //  } else {
      //      return redirect()->route('dashboard');
      //  }
    }

    public function create()
    {

        return Inertia::render('Dependencia/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:dependencias|max:100',
        ]);

        Dependencia::create($request->all());

        //return Inertia::location(route('dependencia.index'));
        return redirect()->route('dependencia.index')->with('message', 'Dependencia creada');
    }


    /*   public function edit(Dependencia $dependencia): Response
         {
             return Inertia::render('Dependencia/FormEdit', ['dependencia' => new DependenciaResource($dependencia)]);
         }
    */
    public function edit(Dependencia $dependencia)
    {
        return Inertia::render('Dependencia/Edit', [
            'dependencias' => $dependencia,
        ]);
    }


    public function update(Request $request, Dependencia $dependencia)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('dependencias')->ignore($dependencia->id),
            ],
        ]);

        $dependencia->update($request->all());
        /*  $dependencia->update([
            'nombre'=>$request->nombre,
            ]);
        */

        return redirect()->route('dependencia.index')->with('message', 'Dependencia actualizada');
        //return Inertia::location(route('dependencia.index'));

    }


    public function destroy($id)
    {
        $dependencias = Dependencia::find($id);
        $dependencias->delete();
        return redirect()->route('dependencia.index');
        //return Inertia::location(route('dependencia.index'));
    }

}