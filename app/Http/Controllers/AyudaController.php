<?php

namespace App\Http\Controllers;

use App\Models\KeysMensaje;
use App\Models\Oficina;
use App\Models\TipoProblema;
use App\Models\Incidencia;
use App\Models\TokenMensaje;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AyudaController extends Controller
{
    public function create()
    {
        $oficinas = Oficina::all();
        $tiposProblema = TipoProblema::all();
        $incidencia = Incidencia::with('oficina', 'tipo_problema')->first(); // Cambiar 'first' si deseas cargar una incidencia específica

        //dd($oficinas);
        return Inertia::render('Incidencia/Form', [
            'incidencia' => $incidencia,
            'oficinas' => $oficinas,
            'tiposProblema' => $tiposProblema,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'celular' => 'required|numeric|digits:9',
            'tipo_problema_id' => 'required',
            'oficina_id' => 'required',
            'otros' => 'required_if:tipo_problema_id,Otros',
        ]);


        $message = $request->input('message');

        $id_users = KeysMensaje::all()->pluck('number_key');
        // $token = TokenMensaje::all()->pluck('name_token');
        $token = TokenMensaje::first()->name_token;

        // Obtiene el mensaje desde la solicitud
        if (Incidencia::create($request->all())) {
            // Itera sobre los usuarios y envía un mensaje a cada uno
            foreach ($id_users as $id_user) {
                $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $id_user . "&text=" . $message . '😊';

                // Envía el mensaje a este usuario
                Http::post($url);
            }
        } else {

        }

        //$url = "https://api.telegram.org/bot" . $token
        //   . "/sendMessage?" . "chat_id=" . $id_user . "&text=" . $message . '😊';

        // Send the message using Guzzle HTTP client
        //Http::post($url);

        /*$request->path();
        Auth::logout();
        */
        return redirect()->route('ayuda.login');
    }


}

//"6377075144:AAG41NVEEAjgQD3eq8E7frOUQK6HdRyuW_A"
