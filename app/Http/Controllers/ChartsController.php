<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\TipoProblema;
use App\Models\Incidencia;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *

     */

    public function index(Request $request)
    {
        // $backgroundColor = $request->input('backgroundColor');
        // $borderColor = $request->input('borderColor');
        $data = DB::table('incidencias')
            ->selectRaw('YEAR(incidencias.created_at) AS Anio, MONTH(incidencias.created_at) AS Mes, tipo_problemas.nombre AS NombreTipoProblema, COUNT(*) AS CantidadProblema')
            ->leftJoin('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
            ->whereYear('incidencias.created_at', '=', 2023) // Cambia el año que desees filtrar
            ->groupBy('Anio', 'Mes', 'incidencias.tipo_problema_id', 'NombreTipoProblema')
            ->orderBy('Anio', 'asc')
            ->orderBy('Mes', 'asc')
            ->orderBy('incidencias.tipo_problema_id', 'asc')
            ->get();

        // Crear un array final para pasar a la vista
        $finalData = [
            'labels' => [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Setiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ],
            // Puedes personalizar estos meses según tus necesidades
            'datasets' => [],
        ];

        // Obtener una lista de todos los tipos de problema
        $tipoProblemaNames = DB::table('tipo_problemas')
            ->pluck('nombre')
            ->toArray();

        // Inicializar los datasets para cada tipo de problema
        foreach ($tipoProblemaNames as $nombreTipoProblema) {
            $dataset = [
                'label' => $nombreTipoProblema,
                'backgroundColor' => '',
                // Sin comillas para obtener el valor de la variable CSS
                // Puedes personalizar esto
                'borderColor' => '',
                // Sin comillas para obtener el valor de la variable CSS
                // Puedes personalizar esto
                'data' => array_fill(0, 12, 0),
                // Inicializar el array 'data' con ceros
            ];

            // Llenar el array 'data' con los valores correspondientes a los meses
            foreach ($data as $item) {
                if ($item->NombreTipoProblema === $nombreTipoProblema) {
                    $mes = $item->Mes;
                    $dataset['data'][$mes - 1] = $item->CantidadProblema; // Restar 1 para ajustar al índice del array
                }
            }

            $finalData['datasets'][] = $dataset;
        }

        $GrafPendSolu = DB::table('incidencias')
            ->leftJoin('solucions', 'incidencias.id', '=', 'solucions.incidencias_id')
            ->selectRaw('COUNT(DISTINCT incidencias.id) - COALESCE(COUNT(DISTINCT solucions.incidencias_id), 0) AS incidencias_pendientes')
            ->selectRaw('COALESCE(COUNT(DISTINCT solucions.incidencias_id), 0) AS soluciones_realizadas')
            ->first();


        $fechaActual = Carbon::now()->format('Y-m-d');

        $datosDias = Incidencia::selectRaw('DATE(created_at) AS fecha, COUNT(*) AS cantidad_incidencias')
            ->whereDate('created_at', $fechaActual)
            ->groupBy('fecha')
            ->get();

        $semanaActual = now()->format('oW'); // 'o' para el año ISO y 'W' para la semana ISO

        $datosSemana = Incidencia::selectRaw('YEARWEEK(created_at, 3) AS semana, COUNT(*) AS cantidad_incidencias')
            ->whereRaw('YEARWEEK(created_at, 3) = ?', [$semanaActual]) // Filtrar por la semana actual
            ->whereRaw('DAYOFWEEK(created_at) BETWEEN 1 AND 6') // Filtrar desde el domingo hasta el viernes
            ->groupBy('semana')
            ->get();

        $mesActual = Carbon::now()->format('Y-m');
        $datosMes = Incidencia::selectRaw("DATE_FORMAT(created_at, '%Y-%m') AS mes, COUNT(*) AS cantidad_incidencias")
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$mesActual])
            ->groupBy('mes')
            ->get();

        $today = now()->toDateString(); // Obtiene la fecha actual en formato "Y-m-d"
        $incidencias = Incidencia::whereDate('created_at', '=', $today)
            ->with('oficina', 'tipo_problema')
            ->get();

        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'dni', 'label' => 'DNI'],
            ['key' => 'celular', 'label' => 'Celular'],
            ['key' => 'tipo_problema.nombre', 'label' => 'Problema'],
            ['key' => 'oficina.nombre', 'label' => 'Oficina'],
        ];
        // Pasar los datos formateados a la vista
        return Inertia::render('Dashboard', [
            'datosDias' => $datosDias,
            'datosSemana' => $datosSemana,
            'datosMes' => $datosMes,
            'incidencias' => $incidencias,
            'graficoData' => $finalData,
            'GrafPendSolu' => $GrafPendSolu,
            'tableColumns' => $tableColumns
        ]);
    }

    /*   public function index()
       {
           $totalIncidencias = DB::table('incidencias')
           ->selectRaw('YEAR(incidencias.created_at) AS Anio, MONTH(incidencias.created_at) AS Mes, tipo_problemas.nombre AS NombreTipoProblema, COUNT(*) AS CantidadProblema')
           ->leftJoin('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
           ->whereYear('incidencias.created_at', '=', 2023) // Cambia el año que desees filtrar
           ->groupBy('Anio', 'Mes', 'incidencias.tipo_problema_id', 'NombreTipoProblema')
           ->orderBy('Anio', 'asc')
           ->orderBy('Mes', 'asc')
           ->orderBy('incidencias.tipo_problema_id', 'asc')
           ->get();
           dd($totalIncidencias);
           return Inertia::render('Dashboard', [
               'GrafPendSolu' => $totalIncidencias,
           ]);
       }*/

    /*
$GrafPendSolu = DB::table('incidencias')
        ->leftJoin('solucions', 'incidencias.id', '=', 'solucions.incidencias_id')
        ->selectRaw('COUNT(DISTINCT incidencias.id) - COALESCE(COUNT(DISTINCT solucions.incidencias_id), 0) AS incidencias_pendientes')
        ->selectRaw('COALESCE(COUNT(DISTINCT solucions.incidencias_id), 0) AS soluciones_realizadas')
        ->first();
    */

    /*
   $totalIncidencias = DB::table('incidencias')
        ->selectRaw('YEAR(created_at) AS Anio, MONTH(created_at) AS Mes, tipo_problemas.nombre, COUNT(*) AS CantidadProblema')
        ->leftJoin('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
        ->whereYear('created_at', '=', 2023) // Cambia el año que desees filtrar
        ->groupBy('Anio', 'Mes', 'incidencias.tipo_problema_id')
        ->orderBy('Anio', 'Mes', 'incidencias.tipo_problema_id')
        ->get();
    */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
