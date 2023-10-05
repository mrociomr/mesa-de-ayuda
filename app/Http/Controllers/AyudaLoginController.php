<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Oficina;

class AyudaLoginController extends Controller
{
    public function showLoginForm()
    {
        $oficinas = Oficina::all();
        return Inertia::render('Ayuda/LoginAyuda', [
            'oficinas' => $oficinas,
        ]);
    }

    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required',
            'password' => 'required',
        ]);

        // Obtener las credenciales del formulario
        $nombre = $request->input('nombre');
        $password = $request->input('password');
        // Buscar un usuario con el nombre proporcionado
        $usuario = Oficina::where('nombre', $nombre)->first();
        //dd($usuario);
        // Verificar si se encontró un usuario y comparar contraseñas
        if ($usuario && password_verify($password, $usuario->password)) {
            // Las contraseñas coinciden, redireccionar al usuario autenticado
            // dd($usuario);
            Auth::guard('ayuda')->login($usuario); // Autenticar al usuario en el guardia 'ayuda'
            return redirect()->route('ayuda.create');
            //return Inertia::location(route('ayuda.create'));

        }
        //dd($password);

        // Las credenciales son incorrectas, mostrar mensaje de error y volver atrás
        return back()->withErrors(['password' => 'Credenciales incorrectas'])->withInput();
    }

}
