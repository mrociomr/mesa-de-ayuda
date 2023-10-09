<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenMensaje;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TokenMensajeController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->can('key-mensaje.index')) {

            $query = TokenMensaje::query();

            if ($request->has('name_token')) {
                $nombreFilter = $request->input('name_token');
                $query->where('name_token', 'like', '%' . $nombreFilter . '%');
            }

            $tokenMensaje = $query->get();

            $tableColumns = [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'name_token', 'label' => 'Token'],
            ];

            return Inertia::render('TokenMensaje/Table', [
                'tokenMensaje' => $tokenMensaje,
                'tableColumns' => $tableColumns,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        if (Auth::user()->can('key-mensaje.create')) {

            return Inertia::render('TokenMensaje/Create');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name_token' => 'required|unique:token_mensajes,name_token',
        ]);

        TokenMensaje::create($request->all());

        return redirect()->route('token-mensaje.index');
        //return Inertia::location(route('tipo-problema.index'));
    }

    public function edit(TokenMensaje $tokenMensaje)
    {
        if (Auth::user()->can('key-mensaje.edit')) {

            return Inertia::render('TokenMensaje/Edit', [
                'tokenMensaje' => $tokenMensaje,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request, TokenMensaje $tokenMensaje)
    {
        $request->validate([
            'name_token' => 'required|unique:token_mensajes,name_token',
        ]);

        $tokenMensaje->update($request->all());

        return redirect()->route('token-mensaje.index');
        //return Inertia::location(route('tipo-problema.index'));
    }

    public function destroy($id)
    {
        if (Auth::user()->can('key-mensaje.destroy')) {
            $tokenMensaje = TokenMensaje::find($id);
            $tokenMensaje->delete();

            return redirect()->route('token-mensaje.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
