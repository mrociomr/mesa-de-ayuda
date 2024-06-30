<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Oficina;
use App\Models\Solucion;
use App\Models\TipoProblema;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class IncidenciaController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('incidencia.index')) {

            // Validación de entrada
            $request->validate([
                'nombre' => 'string|nullable',
            ]);

            $query = Incidencia::query();

            if ($request->has('nombre')) {
                $nombreFilter = $request->input('nombre');
                $query->where(function ($subquery) use ($nombreFilter) {
                    $subquery->orWhere('dni', 'like', '%' . $nombreFilter . '%')
                        ->orWhere('celular', 'like', '%' . $nombreFilter . '%')
                        ->orWhere('nTicket', 'like', '%' . $nombreFilter . '%')
                        ->orWhereHas('tipo_problema', function ($subsubquery) use ($nombreFilter) {
                            $subsubquery->where('nombre', 'like', '%' . $nombreFilter . '%');
                        });
                });
            }

            //$incidencias = $query->with('oficina', 'tipo_problema')->get();
            $incidencias = $query->select('incidencias.*')
                ->from('incidencias')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('solucions')
                        ->whereColumn('solucions.incidencias_id', 'incidencias.id');
                })
                ->with('oficina', 'tipo_problema')
                ->orderBy('created_at', 'desc')
                ->get();

            $tableColumns = [
                ['key' => 'nTicket', 'label' => 'TICKED'],
                ['key' => 'dni', 'label' => 'DNI'],
                ['key' => 'celular', 'label' => 'Celular'],
                ['key' => 'tipo_problema.nombre', 'label' => 'Tipo de problema'],
                ['key' => 'oficina.nombre', 'label' => 'Oficina'],

            ];

            foreach ($incidencias as $incidencia) {
                if ($incidencia->tipo_problema && strtolower($incidencia->tipo_problema->nombre) === 'otros') {
                    $incidencia->tipo_problema->nombre = $incidencia->otros;
                }
            }

            $incidenciasPendientes = DB::table('incidencias')
                ->leftJoin('solucions', 'incidencias.id', '=', 'solucions.incidencias_id')
                ->whereNull('solucions.incidencias_id')
                ->count();

            return Inertia::render('Incidencia/Table', [
                'incidencia' => $incidencias,
                'tableColumns' => $tableColumns,
                'incidenciasPendientes' => $incidenciasPendientes,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }



    public function create()
    {
        if (Auth::user()->can('incidencia.create')) {

            $oficinas = Oficina::all();
            $tiposProblema = TipoProblema::all();
            //dd($oficinas);
            return Inertia::render('Incidencia/Create', [
                'oficinas' => $oficinas,
                'tiposProblema' => $tiposProblema,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {
        $mesActual = Carbon::now()->month;

        $request->validate([
            'dni' => 'required|digits:8|numeric',
            'celular' => 'required|digits:9|numeric',
            'tipo_problema_id' => 'required',
            'oficina_id' => 'required',
        ]);

        //Incidencia::create($request->all());

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


        return redirect()->route('incidencia.index')->with(['message' => 'Incidencia creada', 'data' => $createdData]);

        //return redirect()->route('incidencia.index')->with('message', 'Incidencia creada', $mesActual);
        //return Inertia::location(route('incidencia.index'));

    }

    public function edit(Incidencia $incidencia)
    {
        if (Auth::user()->can('incidencia.edit')) {

            $oficinas = Oficina::all();
            $tiposProblema = TipoProblema::all();
            $incidencia->load('oficina', 'tipo_problema');
            //dd($incidencia);
            return Inertia::render('Incidencia/Edit', [
                'incidencia' => $incidencia,
                'oficinas' => $oficinas,
                'tiposProblema' => $tiposProblema,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'dni' => 'required|digits:8|numeric',
            'celular' => 'required|digits:9|numeric',
            'tipo_problema_id' => 'required',
            'oficina_id' => 'required',
        ]);

        $incidencia->update($request->all());
        /*  $dependencia->update([
            'nombre'=>$request->nombre,
            ]);
        */

        return redirect()->route('incidencia.index');
        //return Inertia::location(route('incidencia.index'));

    }


    public function destroy($id)
    {
        if (Auth::user()->can('incidencia.destroy')) {

            $incidencia = Incidencia::find($id);
            $incidencia->delete();

            return redirect()->route('incidencia.index');
            //return Inertia::location(route('incidencia.index'));
        } else {
            return redirect()->route('dashboard');
        }
    }
}
