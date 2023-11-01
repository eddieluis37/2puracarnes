<?php

namespace App\Http\Controllers\listaprecio;

use App\Models\Listaprecio;
use App\Models\Listapreciodetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\centros\Centrocosto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class listaPrecioController extends Controller
{

    public function index()
    {
        $listaprecios = Listaprecio::with('centrocosto')->get();
        $centros = Centrocosto::Where('status', 1)->get();

        // dd($listaprecios);

        return view('listadeprecio.index', compact('listaprecios', 'centros'));
    }

    public function create($id)
    {
       // dd($id);
        $dataListaPrecio = DB::table('listaprecios as lp')
            ->join('categories as cat', 'lp.categoria_id', '=', 'cat.id')
            ->join('centro_costo as centro', 'lp.centrocosto_id', '=', 'centro.id')
            ->select('lp.*', 'cat.name as namecategoria', 'centro.name as namecentrocosto')
            ->where('lp.id', $id)
            ->get();

        $cortes = DB::table('products as p')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.*', 'ce.stock', 'ce.fisico', 'p.id as productopadreId')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stockPadre')
            ->where([
                ['p.level_product_id', 1],             
                ['p.meatcut_id', $dataListaPrecio[0]->meatcut_id],
                ['p.status', 1],
                ['ce.centrocosto_id', $dataListaPrecio[0]->centrocosto_id],
            ])->get();

        /**************************************** */
        $status = '';
        $fechaListaPrecioCierre = Carbon::parse($dataListaPrecio[0]->fecha_cierre);
        $date = Carbon::now();
        $currentDate = Carbon::parse($date->format('Y-m-d'));
        if ($currentDate->gt($fechaListaPrecioCierre)) {
            //'Date 1 is greater than Date 2';
            $status = 'false';
        } elseif ($currentDate->lt($fechaListaPrecioCierre)) {
            //'Date 1 is less than Date 2';
            $status = 'true';
        } else {
            //'Date 1 and Date 2 are equal';
            $status = 'false';
        }
        /**************************************** */
        $statusInventory = "";
        if ($dataListaPrecio[0]->status_dos == "AGREGADO") {
            $statusInventory = "true";
        } else {
            $statusInventory = "false";
        }
        /**************************************** */
        //dd($tt = [$status, $statusInventory]);

        $display = "";
        if ($status == "false" || $statusInventory == "true") {
            $display = "display:none;";
        }

        $listaprecios = $this->getalistamientodetail($id, $dataListaPrecio[0]->centrocosto_id);

        $arrayTotales = $this->sumTotales($id);

        return view('alistamiento.create', compact('dataListaPrecio', 'cortes', 'listaprecios', 'arrayTotales', 'status', 'statusInventory', 'display'));
    }
 


/* 
    public function store(Request $request)
    {
        $lp = new Listaprecio();

        $lp->centrocosto_id = $request->centrocosto_id;
        $lp->nombre = $request->nombre;
        $lp->tipo = $request->tipo;

        $lp->save();

        return redirect()->back();
    } */

    public function store(Request $request) // Llenado del modal_create.blade
    {
        try {

            $rules = [
              /*   'listaPrecioId' => 'required', */
                'centrocosto' => 'required',
                'nombre' => 'required',
                'tipo' => 'required',
            ];
            $messages = [
             /*    'listaPrecioId.required' => 'El lista precio es requerido', */
                'centrocosto.required' => 'El centro de costo es requerido',
                'nombre.required' => 'La nombre es requerida',               
                'tipo.required' => 'El tipo es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Listaprecio::firstWhere('id', $request->listaPrecioId);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
                $fechalistado = $request->fecha;
                $id_user = Auth::user()->id;

                $list = new Listaprecio();
                $list->users_id = $id_user;              
                $list->centrocosto_id = $request->centrocosto;               
                $list->nombre = $request->nombre;
                $list->tipo = $request->tipo;
                //$list->fecha_listado = $currentDateFormat;
                $list->fecha_listado = $fechalistado;
                $list->fecha_cierre = $dateNextMonday;
                $list->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $list->id
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
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
