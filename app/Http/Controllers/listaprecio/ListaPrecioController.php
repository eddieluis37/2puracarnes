<?php

namespace App\Http\Controllers\listaprecio;

use App\Models\Listaprecio;
use App\Models\Listapreciodetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\centros\Centrocosto;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class listaPrecioController extends Controller
{

    public function index()
    {
        $listaprecios = Listaprecio::with('centrocosto')->get();
        $centros = Centrocosto::Where('status', 1)->get();

        // dd($listaprecios);

        return view('listadeprecio.index', compact('listaprecios', 'centros'));
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $lp = new Listaprecio();

        $lp->centrocosto_id = $request->centrocosto_id;
        $lp->nombre = $request->nombre;
        $lp->tipo = $request->tipo;

        $lp->save();

        return redirect()->back();
    }


    public function show()
    {
        $data = DB::table('listaprecios as lp')
            ->join('centro_costo as cc', 'cc.id', '=', 'lp.centrocosto_id')
            ->select('lp.*', 'cc.name as namecentrocosto')
            /*  ->where('lp.status', 1) */
            ->get();

        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('fecha', function ($data) {
                $fecha = Carbon::parse($data->fecha_listado);
                $onlyDate = $fecha->toDateString();
                return $onlyDate;
            })
            ->addColumn('status_dos', function ($data) {
                if ($data->status_dos == 'PENDIENTE') {
                    $status_dos = '<span class="badge bg-warning">Pendiente</span>';
                } else {
                    $status_dos = '<span class="badge bg-success">Aprobado</span>';
                }
                return $status_dos;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="lista_de_precio/create/' . $data->id . '" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $status_dos = '';
                    if ($data->status_dos == 'added') {
                        $status_dos = 'disabled';
                    }
                    $btn = '
                    <div class="text-center">
					<a href="lista_de_precio/create/' . $data->id . '" class="btn btn-dark" title="CrearDetalle" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="downAlistamiento(' . $data->id . ');" ' . $status_dos . '>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } else {
                    $btn = '
                    <div class="text-center">
					<a href="lista_de_precio/create/' . $data->id . '" class="btn btn-dark" title="CrearDetalle" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }
                return $btn;
            })
            ->rawColumns(['fecha', 'status_dos', 'action'])
            ->make(true);
    }


    public function edit($lpId)
    {
        $lp = Listaprecio::find($lpId);
        $centrocostos = Centrocosto::all();

        return request()->expectsJson()
            ? response()->json([
                'data' => $lp,
                'dataurl' => "/lista_de_precio/$lpId"
            ])
            : view('listadeprecio.modal_update', compact('lp', 'centrocostos'));
    }


    public function update(Request $request, $lpId)
    {
        $lp = Listaprecio::find($lpId);

        $lp->centrocosto_id = $request->centrocosto_id;
        $lp->nombre = $request->nombre;
        $lp->tipo = $request->tipo;

        $lp->save();

        return redirect()->back();
    }


    public function delete(Request $request, $lpId)
    {
        $lp = Listaprecio::find($lpId);
        $lp->delete();
        return redirect()->back();
    }
}
