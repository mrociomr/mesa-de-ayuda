<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeysMensaje;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class KeysMensajeController extends Controller
{
    //key-mensaje
    public function index(Request $request)
    {
        if (Auth::user()->can('key-mensaje.index')) {

            $query = KeysMensaje::query();

            if ($request->has('name')) {
                $nombreFilter = $request->input('name');
                $query->where('name', 'like', '%' . $nombreFilter . '%');
            }

            $keyMensaje = $query->get();

            $tableColumns = [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'name', 'label' => 'name'],
                ['key' => 'number_key', 'label' => 'Key_user'],
            ];


            return Inertia::render('KeyMensaje/Table', [
                'keyMensaje' => $keyMensaje,
                'tableColumns' => $tableColumns,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        if (Auth::user()->can('key-mensaje.create')) {
            return Inertia::render('KeyMensaje/Create');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'number_key' => 'required',
        ]);

        KeysMensaje::create($request->all());

        return redirect()->route('key-mensaje.index');
        //return Inertia::location(route('tipo-problema.index'));
    }

    public function edit($id)
    {
        if (Auth::user()->can('key-mensaje.edit')) {

            // Obtén los datos del modelo KeysMensaje directamente
            $keysMensaje = KeysMensaje::find($id);

            if (!$keysMensaje) {
                // Maneja el caso en el que no se encuentra el registro
                // Puedes redirigir a una página de error o hacer lo que necesites.
            }

            return Inertia::render('KeyMensaje/Edit', [
                'keysMensaje' => $keysMensaje,
            ]);
        } else {
            return redirect()->route('dashboard');
        }

    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'number_key' => 'required',
        ]);

        $keysMensaje = KeysMensaje::find($id);

        if (!$keysMensaje) {
            // Maneja el caso en el que no se encuentra el registro
            // Puedes redirigir a una página de error o hacer lo que necesites.
        }

        $keysMensaje->update($request->all());

        return redirect()->route('key-mensaje.index');
    }


    public function destroy($id)
    {
        if (Auth::user()->can('key-mensaje.destroy')) {

            $keyMensaje = KeysMensaje::find($id);
            $keyMensaje->delete();

            return redirect()->route('key-mensaje.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

}
