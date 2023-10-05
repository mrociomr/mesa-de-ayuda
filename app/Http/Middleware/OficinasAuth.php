<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OficinasAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            // Si el usuario ya está autenticado en el guardia "web",
            // redirige o maneja según sea necesario (puede que no sea necesario autenticar de nuevo).
            return redirect('/');
        }

        // Lógica de autenticación específica de oficinas aquí
        if ($this->authenticate($request)) {
            // Autenticación exitosa, permite el acceso a las rutas protegidas por este middleware
            return $next($request);
        }

        // Autenticación fallida, redirige al formulario de inicio de sesión correspondiente
        return redirect()->route('ayuda.create')->with('error', 'Acceso no autorizado');
    }

    protected function authenticate($request)
    {
        // Lógica de autenticación específica de oficinas aquí
        // Verificar si el usuario debe estar autenticado en el sistema de oficinas

        // Por ejemplo, podrías verificar si el usuario actual tiene un rol específico que
        // identifica a las oficinas o si existe alguna otra condición en tu base de datos.
        // Supongamos que en tu base de datos, las oficinas tienen un campo "es_oficina" que
        // es igual a 1 cuando son oficinas.

        $user = Auth::user(); // Obtenemos el usuario actual autenticado

        if ($user && $user->es_oficina == 1) {
            // El usuario actual es una oficina, permitir la autenticación
            return true;
        }

        // No se cumple la condición de autenticación para una oficina
        return false;
    }
}
