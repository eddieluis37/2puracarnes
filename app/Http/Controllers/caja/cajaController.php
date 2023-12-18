<?php

namespace App\Http\Controllers\caja;

use App\Http\Controllers\Controller;

use App\Models\caja\Caja;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Products\Meatcut;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;
use App\Models\shopping\shopping_enlistment;
use App\Models\shopping\shopping_enlistment_details;


class cajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::WhereIn('id', [1, 2, 3])->get();
        $usuario = User::WhereIn('id', [9, 11, 12])->get();

        $centros = Centrocosto::WhereIn('id', [1])->get();
        return view("caja.index", compact('usuario', 'category', 'centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $dataValores = DB::table('cajas as ca')
            ->join('sales as sa', 'ca.cajero_id', '=', 'sa.user_id')
            ->join('users as u', 'ca.cajero_id', '=', 'u.id')
            /*  ->join('centro_costo as centro', 'ca.centrocosto_id', '=', 'centro.id') */
            /*   ->select('ca.*', 'sa.valor_a_pagar_efectivo', 'centro.name as namecentrocosto', 'u.name as namecajero') */
            ->where('ca.id', $id)
            ->whereDate('sa.fecha_venta', now())
            ->where('sa.third_id', 33)
            /* ->where('sa.user_id', 'u.id') */
            ->sum('sa.valor_a_pagar_efectivo');

        dd($dataValores);

        // dd($id);
        $dataAlistamiento = DB::table('cajas as ca')
            ->join('sales as sa', 'ca.user_id', '=', 'sa.id')
            ->join('users as u', 'ca.cajero_id', '=', 'u.id')
            ->join('centro_costo as centro', 'ca.centrocosto_id', '=', 'centro.id')
            ->select('ca.*', 'sa.valor_a_pagar_efectivo', 'centro.name as namecentrocosto', 'u.name as namecajero')
            ->where('ca.id', $id)
            ->whereDate('sa.fecha_venta', now())

            ->get();




        // dd($dataAlistamiento);


        /**************************************** */
        $status = '';
        $fechaAlistamientoCierre = Carbon::parse($dataAlistamiento[0]->fecha_hora_cierre);
        $date = Carbon::now();
        $currentDate = Carbon::parse($date->format('Y-m-d'));
        if ($currentDate->gt($fechaAlistamientoCierre)) {
            //'Date 1 is greater than Date 2';
            $status = 'false';
        } elseif ($currentDate->lt($fechaAlistamientoCierre)) {
            //'Date 1 is less than Date 2';
            $status = 'true';
        } else {
            //'Date 1 and Date 2 are equal';
            $status = 'false';
        }
        /**************************************** */
        $statusInventory = "";
        if ($dataAlistamiento[0]->estado == "added") {
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

        /*  $enlistments = $this->getalistamientodetail($id, $dataAlistamiento[0]->centrocosto_id); */
        /* 
        $arrayTotales = $this->sumTotales($id);
 */
        return view('caja.create', compact('dataAlistamiento', 'status', 'statusInventory', 'display'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'alistamientoId' => 'required',
                'cajero' => 'required',
                'centrocosto' => 'required',
            ];
            $messages = [
                'alistamientoId.required' => 'El alistamiento es requerido',
                'cajero.required' => 'El cajero es requerido',
                'centrocosto.required' => 'El centro de costo es requerido',
                'cajero_id.unique' => 'Ya existe un registro para este cajero en la fecha actual',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $currentDate = Carbon::now()->format('Y-m-d');
            $cajeroId = $request->cajero;
            $existingRecord = Caja::where('cajero_id', $cajeroId)
                ->whereDate('fecha_hora_inicio', $currentDate)
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Ya existe un registro para este cajero en la fecha actual',
                ]);
            }
            /* 
            $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format */

            $getReg = Caja::firstWhere('id', $request->alistamientoId);
            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $fechaHoraCierre =  $current_date->addHours(18);

                $fechaalistamiento = $request->fecha1;
                $id_user = Auth::user()->id;
                $alist = new Caja();
                $alist->user_id = $id_user;
                $alist->centrocosto_id = $request->centrocosto;
                $alist->cajero_id = $cajeroId;
                $alist->base = $request->base;
                //$alist->fecha_alistamiento = $currentDateFormat;
                $alist->fecha_hora_inicio = $currentDateTime;
                $alist->fecha_hora_cierre = $fechaHoraCierre;
                $alist->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $alist->id
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = DB::table('cajas as ali')
            ->join('users as u', 'ali.cajero_id', '=', 'u.id')
            /*   ->join('meatcuts as cut', 'ali.meatcut_id', '=', 'cut.id')*/
            ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
            ->select('ali.*', 'centro.name as namecentrocosto', 'u.name as namecajero')
            ->where('ali.status', 1)
            ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('fecha1', function ($data) {
                $fecha1 = Carbon::parse($data->fecha_hora_inicio);
                $formattedDate1 = $fecha1->format('M-d. H:i');
                return $formattedDate1;
            })
            ->addColumn('fecha2', function ($data) {
                $fecha2 = Carbon::parse($data->fecha_hora_cierre);
                $formattedDate = $fecha2->format('M-d. H:i');
                return $formattedDate;
            })
            ->addColumn('inventory', function ($data) {
                if ($data->estado == 'close') {
                    $statusInventory = '<span class="badge bg-warning">Cerrado</span>';
                } else {
                    $statusInventory = '<span class="badge bg-success">Abierto</span>';
                }
                return $statusInventory;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_hora_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="caja/create/' . $data->id . '" class="btn btn-dark" title="CuadreCaja" >
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
                } elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_hora_cierre))) {
                    $status = '';
                    if ($data->estado == 'close') {
                        $status = 'disabled';
                    }
                    $btn = '
                    <div class="text-center">
                    <a href="caja/create/' . $data->id . '" class="btn btn-dark" title="RetiroDinero" >
						<i class="fas fa-money-bill-alt"></i>
					</a>
					<a href="caja/create/' . $data->id . '" class="btn btn-dark" title="CuadreCaja" >
						<i class="fas fa-money-check-alt"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="downAlistamiento(' . $data->id . ');" ' . $status . '>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } else {
                    $btn = '
                    <div class="text-center">
					<a href="caja/create/' . $data->id . '" class="btn btn-dark" title="Alistar" >
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
            ->rawColumns(['fecha1', 'fecha2', 'inventory', 'action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function edit(Caja $caja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caja $caja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caja $caja)
    {
        //
    }
}
