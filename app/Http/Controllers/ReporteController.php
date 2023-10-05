<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Solucion;


class ReporteController extends Controller
{
    //
    public function index(Request $request, $mess = 1, $añoss = 2023)
    {
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
            ->select('solucions.id', 'tipo_problemas.nombre AS Tipo Problema', 'tipo_solucions.nombre AS Tipo Solucion', 'solucions.descripcion', 'solucions.equipos', 'oficinas.nombre', 'solucions.estado', DB::raw('solucions.created_at AS Fecha'))
            ->join('incidencias', 'incidencias.id', '=', 'solucions.incidencias_id')
            ->join('tipo_problemas', 'tipo_problemas.id', '=', 'incidencias.tipo_problema_id')
            ->join('tipo_solucions', 'tipo_solucions.id', '=', 'solucions.tipo_solucion_id')
            ->join('oficinas', 'oficinas.id', '=', 'incidencias.oficina_id')
            ->whereRaw('MONTH(solucions.created_at) = ?', [$mess])
            ->get();

        $tableColumns = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'Tipo Problema', 'label' => 'Tipo de Problema'],
            ['key' => 'Tipo Solucion', 'label' => 'Tipo de Solución'],
            ['key' => 'descripcion', 'label' => 'Descripción'],
            ['key' => 'nombre', 'label' => 'Oficina'],
            ['key' => 'estado', 'label' => 'Estado'],
            ['key' => 'Fecha', 'label' => 'Fecha'],

        ];


        return Inertia::render('Reporte/Reporte', [
            'graficoData' => $finalData,
            'reporte' => $resultadoMes,
            'tableColumns' => $tableColumns,
            'mess' => $mess,
            // Asegúrate de pasar el valor del mes a la vista

        ]);
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
