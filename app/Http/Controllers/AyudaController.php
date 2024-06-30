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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AyudaController extends Controller
{



    public function create()
    {
        //         $mesActual = Carbon::now()->month;
// dd($mesActual);
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
            'incidenciaID' => $incidenciaID,
            'incidencia' => $incidencia,
            'oficinas' => $oficinas,
            'tiposProblema' => $tiposProblema,
            'incidenciaAll' => $incidenciaAll,
        ]);
    }


    // public function store(Request $request)
    // {
    //     try {
    //         $mesActual = Carbon::now()->month;

    //         // Agregar mensajes flash a la sesión
    //         session()->flash('success', 'Incidencia creada');
    //         session()->flash('mesActual', $mesActual);

    //         // Redirigir usando Inertia
    //         return redirect()->route('ayuda.login');
    //     } catch (\Exception $e) {
    //         // Log any exceptions for debugging
    //         Log::error('Error en el método store: ' . $e->getMessage());

    //         // Redirect back with an error message
    //         return redirect()->back()->withErrors('Ocurrió un error al procesar la solicitud.');
    //     }
    // }

    public function store(Request $request)
    {
        // $mesActual = Carbon::now()->month;

        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'celular' => 'required|numeric|digits:9',
            'tipo_problema_id' => 'required',
            'oficina_id' => 'required',
            'otros' => 'required_if:tipo_problema_id,Otros',
            'nTicket',
        ]);

        $message = $request->input('message');

        $id_users = KeysMensaje::all()->pluck('number_key');
        // $token = TokenMensaje::all()->pluck('name_token');
        $token = TokenMensaje::first()->name_token;


        // Obtiene el mes y año actuales
        $mesActual = Carbon::now()->format('m');
        $anioActual = Carbon::now()->format('Y');

        // Obtiene el último número de ticket del mes y año actuales
        $ultimoTicket = DB::table('incidencias')
            ->whereYear('created_at', $anioActual)
            ->whereMonth('created_at', $mesActual)
            ->orderBy('nTicket', 'desc')
            ->first();

        // Calcula el nuevo número de ticket
        $nuevoNumero = $ultimoTicket ? intval(substr($ultimoTicket->nTicket, 0, 3)) + 1 : 1;
        $nuevoNumero = str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);
        $nTicket = $nuevoNumero . '-' . $mesActual . '-' . $anioActual;

        // Crea la incidencia con el nuevo número de ticket
        $createdData = Incidencia::create(
            array_merge(
                $request->all(),
                ['nTicket' => $nTicket]
            )
        );

        // // Obtiene el mensaje desde la solicitud
        //$createdData = Incidencia::create($request->all());
        if ($createdData) {
            // Itera sobre los usuarios y envía un mensaje a cada uno
            if ($id_users || $token) {
                foreach ($id_users as $id_user) {
                    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $id_user . "&text=" . $message . '😊';

                    // Envía el mensaje a este usuario
                    Http::post($url);
                }
            }
        } else {

        }

        // $url = "https://api.telegram.org/bot" . $token
        //   . "/sendMessage?" . "chat_id=" . $id_user . "&text=" . $message . '😊';

        //  Send the message using Guzzle HTTP client
        //Http::post($url);
        return redirect()->route('miTicked', ['id' => $createdData->id]);

        /*$request->path();
        Auth::logout();
        */
        //return redirect()->route('ayuda.login')
        //    ->with(['success' => 'Incidencia creada', 'mesActual' => $mesActual]);

        //Auth::guard('ayuda')->logout();

        //return redirect()->route('ayuda.login')->with('success', 'El formulario se ha enviado con éxito.');
    }


    public function miTicked($id)
    {
        //$incidencia = Incidencia::findOrFail($id);
        $dataTicked = DB::select('
            SELECT nTicket, dni, incidencias.created_at AS fecha, tp.nombre AS nTipoProblema, of.nombre nOficina FROM incidencias
            INNER JOIN tipo_problemas tp ON tp.id = incidencias.tipo_problema_id
            INNER JOIN oficinas of ON of.id = incidencias.oficina_id
            WHERE incidencias.id = ?',[$id]);
        return Inertia::render('Incidencia/MiTicked', [
            'dataTicked' => $dataTicked
        ]);
    }



}

//"6377075144:AAG41NVEEAjgQD3eq8E7frOUQK6HdRyuW_A"
