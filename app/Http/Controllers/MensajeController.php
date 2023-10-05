<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MensajeController extends Controller
{

    public function index(){
        return Inertia::render('Mensaje/Tabla');
    }

    public function create()
    {

        return Inertia::render('Mensaje/Form');
    }
    public function store(Request $request)
    {
        $message = $request->input('message'); // Obtiene el mensaje desde la solicitud
        //1813979798
        // Realiza el envío del mensaje a través de la API de Telegram
        $id_user = "1109635273";
        $url = "https://api.telegram.org/bot" . "6377075144:AAG41NVEEAjgQD3eq8E7frOUQK6HdRyuW_A"
            . "/sendMessage?" . "chat_id=" . $id_user . "&text=" . $message . '😊';

        // Send the message using Guzzle HTTP client
        Http::post($url);

    }

}
