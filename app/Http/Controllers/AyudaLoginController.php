<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Oficina;
use Illuminate\Support\Facades\Crypt;

class AyudaLoginController extends Controller
{
    public function showLoginForm()
    {
        $oficinas = Oficina::where('estado', 'Activo')->get();
        $diaSemana = date('N'); 
        $horaActual = date('H:i');

        return Inertia::render('Ayuda/LoginAyuda', [
            'oficinas' => $oficinas,
            'diaSemana' => $diaSemana,
            'horaActual' => $horaActual,
        ]);
    }

    public function login(Request $request)
    {
         // Validar los datos de entrada
         $request->validate([
            'nombre' => 'required',
            'password' => 'required',
        ]);

        $nombre = $request->input('nombre');
        $password = $request->input('password');

        $usuario = Oficina::where('nombre', $nombre)->first();
        //dd($usuario);
        if ($usuario && Crypt::decrypt($usuario->password) === $password) {

            Auth::guard('ayuda')->login($usuario);
            return redirect()->route('ayuda.create');
        } else {
            return back()->withErrors(['password' => 'Credenciales incorrectas'])->withInput();
        }
        //dd($password);

        // Las credenciales son incorrectas, mostrar mensaje de error y volver atrás
    }

}
