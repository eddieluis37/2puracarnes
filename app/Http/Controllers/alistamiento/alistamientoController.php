<?php

namespace App\Http\Controllers\alistamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\centros\Centrocosto;
use App\Models\alistamiento\Alistamiento;
use App\Models\alistamiento\enlistment_details;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Products\Meatcut;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;
use App\Models\Centro_costo_product;
use App\Models\shopping\shopping_enlistment;
use App\Models\shopping\shopping_enlistment_details;

class alistamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::WhereIn('id', [1, 2, 3])->get();
        $centros = Centrocosto::Where('status', 1)->get();
        return view("alistamiento.index", compact('category', 'centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //dd($id);
        $dataAlistamiento = DB::table('enlistments as ali')
            ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
            ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
            ->select('ali.*', 'cat.name as namecategoria', 'centro.name as namecentrocosto')
            ->where('ali.id', $id)
            ->get();

        $cortes = DB::table('products as p')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.*', 'ce.stock', 'ce.fisico', 'p.id as productopadreId')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stockPadre')
            ->where([
                ['p.level_product_id', 1],
                ['p.meatcut_id', $dataAlistamiento[0]->meatcut_id],
                ['p.status', 1],
                ['ce.centrocosto_id', $dataAlistamiento[0]->centrocosto_id],
            ])->get();

        /**************************************** */
        $status = '';
        $fechaAlistamientoCierre = Carbon::parse($dataAlistamiento[0]->fecha_cierre);
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
        if ($dataAlistamiento[0]->inventario == "added") {
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

        $enlistments = $this->getalistamientodetail($id, $dataAlistamiento[0]->centrocosto_id);

        $arrayTotales = $this->sumTotales($id);

        return view('alistamiento.create', compact('dataAlistamiento', 'cortes', 'enlistments', 'arrayTotales', 'status', 'statusInventory', 'display'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // Llenado del modal_create.blade
    {
        try {

            $rules = [
                'alistamientoId' => 'required',
                'categoria' => 'required',
                'centrocosto' => 'required',
                'selectCortePadre' => 'required',
            ];
            $messages = [
                'alistamientoId.required' => 'El alistamiento es requerido',
                'categoria.required' => 'La categoria es requerida',
                'centrocosto.required' => 'El centro de costo es requerido',
                'selectCortePadre.required' => 'El corte padre es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Alistamiento::firstWhere('id', $request->alistamientoId);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
                $fechaalistamiento = $request->fecha;
                $id_user = Auth::user()->id;

                $alist = new Alistamiento();
                $alist->users_id = $id_user;
                $alist->categoria_id = $request->categoria;
                $alist->centrocosto_id = $request->centrocosto;
                $alist->meatcut_id = $request->selectCortePadre;
                //$alist->fecha_alistamiento = $currentDateFormat;
                $alist->fecha_alistamiento = $fechaalistamiento;
                $alist->fecha_cierre = $dateNextMonday;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = DB::table('enlistments as ali')
            ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
            ->join('meatcuts as cut', 'ali.meatcut_id', '=', 'cut.id')
            ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
            ->select('ali.*', 'cat.name as namecategoria', 'centro.name as namecentrocosto', 'cut.name as namecut')
            ->where('ali.status', 1)
            ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('fecha', function ($data) {
                $fecha = Carbon::parse($data->fecha_alistamiento);
                $onlyDate = $fecha->toDateString();
                return $onlyDate;
            })
            ->addColumn('inventory', function ($data) {
                if ($data->inventario == 'pending') {
                    $statusInventory = '<span class="badge bg-warning">Pendiente</span>';
                } else {
                    $statusInventory = '<span class="badge bg-success">Agregado</span>';
                }
                return $statusInventory;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/' . $data->id . '" class="btn btn-dark" title="Transformar" >
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
                    $status = '';
                    if ($data->inventario == 'added') {
                        $status = 'disabled';
                    }
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/' . $data->id . '" class="btn btn-dark" title="Transformar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar transformación" onclick="downAlistamiento(' . $data->id . ');" ' . $status . '>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } else {
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/' . $data->id . '" class="btn btn-dark" title="Transformar" >
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
            ->rawColumns(['fecha', 'inventory', 'action'])
            ->make(true);
    }

    public function getproducts(Request $request)
    {
        $prod = Product::Where([
            ['meatcut_id', $request->categoriaId],
            ['status', 1],
            ['level_product_id', 2]
        ])->get();
        return response()->json(['products' => $prod]);
    }

    public function savedetail(Request $request)
    {
        try {

            $rules = [
                'kgrequeridos' => 'required',
                'producto' => 'required',
            ];
            $messages = [
                'kgrequeridos.required' => 'Los kg requeridos son necesarios',
                'producto.required' => 'El producto es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }


            $prod = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico', 'p.cost')
                ->where([
                    ['p.id', $request->producto],
                    ['ce.centrocosto_id', $request->centrocosto],
                    ['p.status', 1],

                ])->get();

            $formatCantidad = new metodosrogercodeController();
            //$prod = Product::firstWhere('id', $request->producto);

            $formatkgrequeridos = $formatCantidad->MoneyToNumber($request->kgrequeridos);
            $newStock = $prod[0]->stock + $formatkgrequeridos;
            $details = new enlistment_details();
            $details->enlistments_id = $request->alistamientoId;
            $details->products_id = $request->producto;
            $details->kgrequeridos = $formatkgrequeridos;
            $details->cost_transformation = $prod[0]->cost * $formatkgrequeridos;
            $details->newstock = $newStock;
            $details->save();


            $arraydetail = $this->getalistamientodetail($request->alistamientoId, $request->centrocosto);
            $arrayTotales = $this->sumTotales($request->alistamientoId);

            $newStockPadre = $request->stockPadre - $arrayTotales['kgTotalRequeridos'];
            $alist = Alistamiento::firstWhere('id', $request->alistamientoId);
            $alist->nuevo_stock_padre = $newStockPadre;
            $alist->save();

            return response()->json([
                'status' => 1,
                'message' => "Agregado correctamente",
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function getalistamientodetail($alistamientoId, $centrocostoId)
    {
        $detail = DB::table('enlistment_details as en')
            ->join('products as pro', 'en.products_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('en.*', 'pro.name as nameprod', 'pro.code', 'ce.stock', 'ce.fisico', 'en.cost_transformation')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stockHijo')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],
                ['en.enlistments_id', $alistamientoId],
                ['en.status', 1]
            ])->get();

        return $detail;
    }

    public function sumTotales($id)
    {

        $kgTotalRequeridos = (float)enlistment_details::Where([['enlistments_id', $id], ['status', 1]])->sum('kgrequeridos');
        $totalCostTranf = enlistment_details::Where([['enlistments_id', $id], ['status', 1]])->sum('cost_transformation');
        $newTotalStock = (float)enlistment_details::Where([['enlistments_id', $id], ['status', 1]])->sum('newstock');

        $array = [
            'kgTotalRequeridos' => $kgTotalRequeridos,
            'totalCostTranf' => $totalCostTranf,
            'newTotalStock' => $newTotalStock,
        ];

        return $array;
    }

    public function updatedetail(Request $request)
    {
        try {

            $prod = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico', 'p.cost')
                ->where([
                    ['p.id', $request->productoId],
                    ['ce.centrocosto_id', $request->centrocosto],
                    ['p.status', 1],

                ])->get();
            //$prod = Product::firstWhere('id', $request->productoId);
            //$newStock = $prod->stock + $request->newkgrequeridos;
            $newStock = $prod[0]->stock + $request->newkgrequeridos;

            $updatedetails = enlistment_details::firstWhere('id', $request->id);
            $updatedetails->kgrequeridos = $request->newkgrequeridos;
            $updatedetails->cost_transformation = $prod[0]->cost * $request->newkgrequeridos;
            $updatedetails->newstock = $newStock;
            $updatedetails->save();

            $arraydetail = $this->getalistamientodetail($request->alistamientoId, $request->centrocosto);
            $arrayTotales = $this->sumTotales($request->alistamientoId);

            $newStockPadre = $request->stockPadre - $arrayTotales['kgTotalRequeridos'];
            $alist = Alistamiento::firstWhere('id', $request->alistamientoId);
            $alist->nuevo_stock_padre = $newStockPadre;
            $alist->save();

            return response()->json([
                'status' => 1,
                'message' => 'Guardado correctamente',
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function editAlistamiento(Request $request)
    {
        $reg = Alistamiento::where('id', $request->id)->first();
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
    }

    public function getProductsCategoryPadre(Request $request)
    {
        $cortes = Meatcut::Where([
            ['category_id', $request->categoriaId],
            ['status', 1]
        ])->get();
        return response()->json(['products' => $cortes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $enlist = enlistment_details::where('id', $request->id)->first();
            $enlist->status = 0;
            $enlist->save();

            $arraydetail = $this->getalistamientodetail($request->alistamientoId, $request->centrocosto);
            $arrayTotales = $this->sumTotales($request->alistamientoId);

            $newStockPadre = $request->stockPadre - $arrayTotales['kgTotalRequeridos'];
            $alist = Alistamiento::firstWhere('id', $request->alistamientoId);
            $alist->nuevo_stock_padre = $newStockPadre;
            $alist->save();

            return response()->json([
                'status' => 1,
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function destroyAlistamiento(Request $request)
    {
        try {
            $alist = Alistamiento::where('id', $request->id)->first();
            $alist->status = 0;
            $alist->save();

            return response()->json([
                'status' => 1,
                'message' => 'Se realizo con exito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function add_shopping(Request $request)
    {
        try {
            $id_user = Auth::user()->id;
            $currentDateTime = Carbon::now();

            DB::beginTransaction();
            $shopp = new shopping_enlistment();
            $shopp->users_id = $id_user;
            $shopp->enlistments_id = $request->alistamientoId;
            $shopp->category_id = $request->categoryId;
            $shopp->productopadre_id = $request->productoPadre;
            $shopp->centrocosto_id = $request->centrocosto;
            $shopp->stock_actual = $request->stockPadre;
            $shopp->ultimo_conteo_fisico = $request->pesokg;
            $shopp->nuevo_stock = $request->newStockPadre;
            $shopp->fecha_shopping = $currentDateTime;
            $shopp->save();

            $regProd = $this->getalistamientodetail($request->alistamientoId, $request->centrocosto);
            $count = count($regProd);
            if ($count == 0) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No tiene productos agregados'
                ]);
            }
            $stockalistpadre = 0;
            foreach ($regProd as $key) {
                $shoppDetails = new shopping_enlistment_details();
                $shoppDetails->shopping_enlistment_id = $shopp->id;
                $shoppDetails->products_id = $key->products_id;
                $shoppDetails->stock_actual = $key->stock;
                $shoppDetails->conteo_fisico = $key->fisico;
                $shoppDetails->kgrequeridos = abs($key->newstock);
                $shoppDetails->newstock = $key->newstock;
                $shoppDetails->save();

                $stockalistpadre = $stockalistpadre + $key->kgrequeridos;

                DB::update(
                    "
                     UPDATE centro_costo_products c 
                     SET c.alistamiento = c.alistamiento + :krequeridos        
                     WHERE c.products_id = :vproducts_id 
                     AND c.centrocosto_id = :vcentrocosto",
                    [
                        'vproducts_id' => $key->products_id,
                        'krequeridos' => $key->kgrequeridos,
                        'vcentrocosto' => $request->centrocosto
                    ]
                );
            }

            $productopadreId = $shopp->productopadre_id;
            $centrocostoId = $shopp->centrocosto_id;

            DB::update(
                "
                     UPDATE centro_costo_products c 
                     SET c.alistamiento = c.alistamiento + :krequeridos        
                     WHERE c.products_id = :vproducts_id  
                     AND c.centrocosto_id = :vcentrocosto",
                [
                    'vproducts_id' => $productopadreId,
                    'krequeridos' => $stockalistpadre * -1,
                    'vcentrocosto' => $centrocostoId
                ]
            );


            $invalist = Alistamiento::where('id', $request->alistamientoId)->first();
            $invalist->inventario = "added";
            $invalist->save();

            DB::commit();
            return response()->json([
                'status' => 1,
                'alistamiento' => $regProd,
                'count' => $count,
                'message' => 'Se guardo co exito'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }
}
