<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Solucion;
use Illuminate\Support\Facades\Auth;


class ReporteController extends Controller
{
    //
    public function index(Request $request, $anisos = null, $mess = null)
    {
        if (Auth::user()->can('reporte.index')) {

            if ($anisos === null || $mess === null) {
                // Si no se proporcionó un año o mes, usa el año y mes actuales
                $anisos = date('Y');
                $mess = date('m');
            }

            $data = DB::table('solucions')
                ->selectRaw('YEAR(incidencias.created_at) AS Anio, MONTH(incidencias.created_at) AS Mes, tipo_problemas.nombre AS NombreTipoProblema, COUNT(*) AS CantidadProblema')
                ->leftJoin('incidencias', 'incidencias.id', '=', 'solucions.incidencias_id')
                ->leftJoin('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
                ->whereYear('incidencias.created_at', $anisos)
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

            $datasetsy = [];
            foreach ($tipoProblemaNames as $index => $nombreTipoProblema) {
                $y = 'y' . ($index + 1); // 'y1', 'y2', 'y3', ...
                $dataset = [
                    'label' => $nombreTipoProblema,
                    'fill' => false,
                    'yAxisID' => $y,
                    'tension' => 0.5,
                    //'backgroundColor' => '',
                    'borderColor' => '',
                    'data' => array_fill(0, 12, 0),
                ];

                foreach ($data as $item) {
                    if ($item->NombreTipoProblema === $nombreTipoProblema) {
                        $mes = $item->Mes;
                        $dataset['data'][$mes - 1] = $item->CantidadProblema; // Restar 1 para ajustar al índice del array
                    }
                }

                $finalData['datasets'][] = $dataset;
            }

            $dataCantidadPrblemas = DB::table('solucions')
                ->leftJoin('incidencias', 'incidencias.id', '=', 'solucions.incidencias_id')
                ->join('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
                ->select('tipo_problemas.nombre as labels', DB::raw('count(*) as data'))
                ->groupBy('tipo_problemas.nombre')
                ->get();

            $formattedDataCanProblems = [

                'data' => $dataCantidadPrblemas->pluck('data')->toArray(),
                'backgroundColor' => [],
                'label' => 'Tipo de Problemas',
                'labels' => $dataCantidadPrblemas->pluck('labels')->toArray(),

            ];

            $request->validate([
                'descripcion' => 'string|nullable',
            ]);
            $query = Solucion::query();

            if ($request->has('descripcion')) {
                $nombreFilter = $request->input('descripcion');
                $query->where(function ($subquery) use ($nombreFilter) {
                    $subquery->orWhere('descripcion', 'like', '%' . $nombreFilter . '%')
                        ->orWhere('estado', 'like', '%' . $nombreFilter . '%')
                        ->orWhereHas('incidencias_id', function ($subsubquery) use ($nombreFilter) {
                            $subsubquery->where('tipo_problema_id', 'like', '%' . $nombreFilter . '%');
                        });
                });
            }

            // $incidencia = $query->get();
            // $reporte = $query->with('incidencias', 'tipo_solucion')->get();

            //$mes = $request->input('mes_select'); // Suponiendo que 'mes' es el nombre del campo en el formulario
            //$mes = $request->session()->get('mes_seleccionado', 6); // El valor predeterminado es 6 si no se encuentra en la sesión

            $resultadoMes = DB::table('solucions')
            ->select(
                'solucions.id',
                'tipo_problemas.nombre AS TipoProblema',
                'incidencias.otros AS OtrosIncidencias',
                'tipo_solucions.nombre AS TipoSolucion',
                'solucions.descripcion',
                'solucions.equipos',
                'solucions.atendido_por AS Atendido',
                'oficinas.nombre',
                'solucions.estado',
                'incidencias.nTicket AS nTicket',
                DB::raw('solucions.created_at AS Fecha')
            )
            ->join('incidencias', 'incidencias.id', '=', 'solucions.incidencias_id')
            ->join('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
            ->join('tipo_solucions', 'tipo_solucions.id', '=', 'solucions.tipo_solucion_id')
            ->join('oficinas', 'oficinas.id', '=', 'incidencias.oficina_id')
            ->whereRaw('MONTH(solucions.created_at) = ?', [$mess])
            ->whereYear('incidencias.created_at', $anisos)
            ->get();

        $tableColumns = [
            ['key' => 'nTicket', 'label' => 'N° Ticket'],
            ['key' => 'TipoProblema', 'label' => 'Tipo de Problema'],
            ['key' => 'TipoSolucion', 'label' => 'Tipo de Solución'],
            ['key' => 'descripcion', 'label' => 'Descripción'],
            ['key' => 'nombre', 'label' => 'Oficina'],
            ['key' => 'estado', 'label' => 'Estado'],
            ['key' => 'Fecha', 'label' => 'Fecha'],
            ['key' => 'Atendido', 'label' => 'Atendido Por'],
        ];

        foreach ($resultadoMes as $resultado) {
            $resultado->TipoProblema = strtolower($resultado->TipoProblema) === 'otros' ? $resultado->OtrosIncidencias : $resultado->TipoProblema;
        }

            $userAut = Auth::user();

            $currentDate = now();
            $dateFormatted = $currentDate->format('d/m/Y');
            $year = $currentDate->year;
            $month = $currentDate->month;
            $day = $currentDate->day;
            $currentTime = now()->format('H:i:s');

            return Inertia::render('Reporte/Reporte', [
                'graficoData' => $finalData,
                'reporte' => $resultadoMes,
                'tableColumns' => $tableColumns,
                'mess' => $mess,
                'formattedDataCanProblems' => $formattedDataCanProblems,
                $formattedDataCanProblems,
                'anisos' => $anisos,
                'userAut' => $userAut,
                'currentDate' => $dateFormatted,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'currentTime' => $currentTime,
                // Asegúrate de pasar el valor del mes a la vista

            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {
        // Lógica para procesar el valor del mes enviado desde Vue
        //$mes = $request->input('mes');
        //$request->session()->flash('mes_seleccionado', $mes);

        //  dd('Valor del mes:', $mes);

        // Realiza las operaciones necesarias con el valor del mes (por ejemplo, almacénalo en la base de datos).

        // Luego, puedes redirigir a la vista deseada o devolver una respuesta JSON según tus necesidades.
        // Por ejemplo, podrías redirigir a la vista inicial después de procesar el mes.
        return redirect()->route('reporte.index');
    }

}
