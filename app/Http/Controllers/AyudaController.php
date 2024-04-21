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
use Carbon\Carbon; 

class AyudaController extends Controller
{
    public function create()
    {
        $fechaActual = Carbon::now()->toDateString();
        // $fechaFormateada = $fechaActual->format('Y-m-d');
        $oficinas = Oficina::where('estado', 'Activo')->get();
        $tiposProblema = TipoProblema::where('estado', 'Activo')->get();
        $incidencia = Incidencia::with('oficina', 'tipo_problema')->first(); // Cambiar 'first' si deseas cargar una incidencia específica
        $incidenciaID = Incidencia::latest('id')->first();
        $incidenciaAll = Incidencia::whereDate('created_at', $fechaActual)->get();
        
        // dd($fechaFormateada);
        // dd($incidenciaAll);
        return Inertia::render('Incidencia/Form', [
            'incidenciaID'=> $incidenciaID,
            'incidencia' => $incidencia,
            'oficinas' => $oficinas,
            'tiposProblema' => $tiposProblema,
            'incidenciaAll' => $incidenciaAll,
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
            if($id_users  || $token) {
            foreach ($id_users as $id_user) {
                $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $id_user . "&text=" . $message . '😊';

                // Envía el mensaje a este usuario
                Http::post($url);
            }
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
        Auth::guard('ayuda')->logout();

        return redirect()->route('ayuda.login')->with('success', 'El formulario se ha enviado con éxito.');
    }


}

//"6377075144:AAG41NVEEAjgQD3eq8E7frOUQK6HdRyuW_A"
