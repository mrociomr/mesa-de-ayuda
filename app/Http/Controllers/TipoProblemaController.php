<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoProblema;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class TipoProblemaController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('tipo-solucion.index')) {

            $query = TipoProblema::query();

            if ($request->has('nombre')) {
                $nombreFilter = $request->input('nombre');
                $query->where('nombre', 'like', '%' . $nombreFilter . '%');
            }

            $tipoProblema = $query->get();

            $tableColumns = [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'nombre', 'label' => 'Nombre'],
                ['key' => 'prioridad', 'label' => 'Prioridad'],
                ['key' => 'estado', 'label' => 'Estado'],
            ];

            return Inertia::render('TipoProblema/Table', [
                'tipoProblema' => $tipoProblema,
                'tableColumns' => $tableColumns,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        if (Auth::user()->can('tipo-solucion.create')) {
            return Inertia::render('TipoProblema/Create');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|unique:tipo_problemas|max:100',
            'prioridad' => 'required|numeric|between:1,5',
            'estado' => 'required',
        ]);

        TipoProblema::create($request->all());

        return redirect()->route('tipo-problema.index')->with('message', 'Tipo de problema creada');
        //return Inertia::location(route('tipo-problema.index'));
    }

    public function edit(TipoProblema $tipoProblema)
    {
        if (Auth::user()->can('tipo-solucion.edit')) {

            return Inertia::render('TipoProblema/Edit', [
                'tipoProblema' => $tipoProblema,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request, TipoProblema $tipoProblema)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tipo_problemas')->ignore($tipoProblema->id),
            ],
            'prioridad' => 'required|numeric|between:1,5',
            'estado' => 'required',
        ]);

        $tipoProblema->update($request->all());

        return redirect()->route('tipo-problema.index')->with('message', 'Tipo de problema actualizado');
        //return Inertia::location(route('tipo-problema.index'));
    }

    public function destroy($id)
    {
        if (Auth::user()->can('tipo-solucion.destroy')) {
            $tipoProblema = TipoProblema::find($id);
            $tipoProblema->delete();
            return redirect()->route('tipo-problema.index');
        } else {
            return redirect()->route('dashboard');
        }

    }
}
