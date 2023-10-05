<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeysMensaje;
use Inertia\Inertia;

class KeysMensajeController extends Controller
{
    //
    public function index(Request $request){
        $query = KeysMensaje::query();

        if($request->has('name')) {
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

    }

    public function create(){
        return Inertia::render('KeyMensaje/Create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'number_key' => 'required',
        ]);

        KeysMensaje::create($request->all());

        return redirect()->route('key-mensaje.index');
        //return Inertia::location(route('tipo-problema.index'));
    }

    public function edit($id) {
        // Obtén los datos del modelo KeysMensaje directamente
        $keysMensaje = KeysMensaje::find($id);

        if (!$keysMensaje) {
            // Maneja el caso en el que no se encuentra el registro
            // Puedes redirigir a una página de error o hacer lo que necesites.
        }

        return Inertia::render('KeyMensaje/Edit', [
            'keysMensaje' => $keysMensaje,
        ]);
    }



    public function update(Request $request, $id) {
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


    public function destroy($id){
        $keyMensaje = KeysMensaje::find($id);
        $keyMensaje->delete();

        return redirect()->route('key-mensaje.index');
    }

}
