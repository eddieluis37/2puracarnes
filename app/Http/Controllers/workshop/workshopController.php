<?php

namespace App\Http\Controllers\workshop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
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
use App\Models\shopping\shopping_enlistment;
use App\Models\shopping\shopping_enlistment_details;
use App\Models\workshop\Workshop;
use App\Models\workshop\Workshop_detail;


class workshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::WhereIn('id', [1, 2, 3, 4])->get();
        $centros = Centrocosto::Where('status', 1)->get();
        return view("workshop.index", compact('category', 'centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //dd($id);
        $dataWorkshop = DB::table('workshops as ali')
            ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
            ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
            ->select('ali.*', 'cat.name as namecategoria', 'centro.name as namecentrocosto')
            ->where('ali.id', $id)
            ->get();

        $cortes = DB::table('products as p')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.*', 'ce.stock', 'ce.fisico', 'p.id as productopadreId')
            ->where([
                ['p.level_product_id', 1],
                ['p.meatcut_id', $dataWorkshop[0]->meatcut_id],
                ['p.status', 1],
                ['ce.centrocosto_id', $dataWorkshop[0]->centrocosto_id],
            ])->get();
        //  dd($cortes);
        // dd($dataWorkshop);
        /*  $cate = $dataWorkshop[0]->categoria_id;
        // dd($cate);
        switch ($cate) {
            case 1:
                $getCostoKilo = DB::table('desposteres')
                    ->join('products as p', 'desposteres.products_id', '=', 'p.id')
                    ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                    ->select('p.name', 'desposteres.costo_kilo')
                    ->where([
                        ['desposteres.status', 'VALID'],
                        ['p.level_product_id', 1],
                        ['p.meatcut_id', $dataWorkshop[0]->meatcut_id],
                        ['p.status', 1],
                        ['ce.centrocosto_id', $dataWorkshop[0]->centrocosto_id],
                    ])
                    ->orderBy('desposteres.created_at', 'desc')
                    ->orderBy('desposteres.costo_kilo', 'desc')
                    ->limit(1)
                    ->get();
                break;
            case 2:
                $getCostoKilo = DB::table('despostecerdos')
                    ->join('products as p', 'despostecerdos.products_id', '=', 'p.id')
                    //  ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                    ->select('p.name', 'despostecerdos.costo_kilo')
                    ->where([
                        ['despostecerdos.status', 'VALID'],
                        ['p.level_product_id', 1],
                        ['p.meatcut_id', $dataWorkshop[0]->meatcut_id],
                        ['p.status', 1],
                        // ['ce.centrocosto_id', $dataWorkshop[0]->centrocosto_id],
                    ])
                    ->orderBy('despostecerdos.costo_kilo', 'desc')
                    ->limit(1)
                    ->get();
                break;
            case 3:
                $getCostoKilo = DB::table('despostepollos')
                    ->join('products as p', 'despostepollos.products_id', '=', 'p.id')
                    ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                    ->select('p.name', 'despostepollos.costo_kilo')
                    ->where([
                        ['despostepollos.status', 'VALID'],
                        ['p.level_product_id', 1],
                        ['p.meatcut_id', $dataWorkshop[0]->meatcut_id],
                        ['p.status', 1],
                        ['ce.centrocosto_id', $dataWorkshop[0]->centrocosto_id],
                    ])
                    ->orderBy('despostepollos.costo_kilo', 'desc')
                    ->limit(1)
                    ->get();
                break;
            default:
                $getCostoKilo = DB::table('desposteres')
                    ->join('products as p', 'desposteres.products_id', '=', 'p.id')
                    ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                    ->select('p.name', 'desposteres.costo_kilo')
                    ->where([
                        ['desposteres.status', 'VALID'],
                        ['p.level_product_id', 1],
                        ['p.meatcut_id', $dataWorkshop[0]->meatcut_id],
                        ['p.status', 1],
                        ['ce.centrocosto_id', $dataWorkshop[0]->centrocosto_id],
                    ])
                    ->orderBy('desposteres.created_at', 'desc')
                    ->orderBy('desposteres.costo_kilo', 'desc')
                    ->limit(1)
                    ->get();
                break;
        }
        if ($getCostoKilo->isEmpty()) {
            echo "Advertencia: Costo Kilo esta vacio. Favor validar los valores en el Desposte";
        } */
        //  dd($getCostoKilo);

        /**************************************** */
        $status = '';
        $fechaAlistamientoCierre = Carbon::parse($dataWorkshop[0]->fecha_cierre);
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
        if ($dataWorkshop[0]->inventario == "added") {
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

        $workshops = $this->getworkshopdetail($id, $dataWorkshop[0]->centrocosto_id);

        $arrayTotales = $this->sumTotales($id);


        $costo_kilo_padre = $cortes[0]->cost;
        $workshop = Workshop::firstWhere('id', $id);
        /*    $workshop->costo_kilo_padre = $costo_kilo_padre; */
        $workshop->save();

        $total_valor_padre = $workshop->peso_producto_padre * $costo_kilo_padre;
        $workshop->total_valor_padre = $total_valor_padre;

        $workshop->save();

        Session::flash('refresh', true);

        return view('workshop.create', compact('dataWorkshop', 'cortes', 'workshops', 'arrayTotales', 'status', 'statusInventory', 'display'));

        /*     return redirect(url()->current()); */
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
                'tallerId' => 'required',
                'categoria' => 'required',
                'centrocosto' => 'required',
                'selectCortePadre' => 'required',
                'peso_producto_padre' => 'required|regex:/^\d+(\.\d+)?$/',


            ];

            $messages = [
                'tallerId.required' => 'El taller es requerido',
                'categoria.required' => 'La categoria es requerida',
                'centrocosto.required' => 'El centro de costo es requerido',
                'selectCortePadre.required' => 'El corte padre es requerido',
                'peso_producto_padre.required' => 'Peso producto padre es requerido',
                'peso_producto_padre.regex' => 'El peso producto padre debe ser un número entero o decimal separado por punto',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Workshop::firstWhere('id', $request->tallerId);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user = Auth::user()->id;

                $costo_kilo_padre = $request->input('costoKiloPadre');
                $peso_producto_padre = $request->peso_producto_padre;
                $total_valor_padre = $costo_kilo_padre * $peso_producto_padre;

                $alist = new Workshop();
                $alist->users_id = $id_user;
                $alist->categoria_id = $request->categoria;
                $alist->centrocosto_id = $request->centrocosto;
                $alist->meatcut_id = $request->selectCortePadre;
                $alist->peso_producto_padre = $request->peso_producto_padre;
                $alist->total_valor_padre = $total_valor_padre;
                $alist->fecha_workshop = $currentDateFormat;
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
        $data = DB::table('workshops as ali')
            ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
            ->join('meatcuts as cut', 'ali.meatcut_id', '=', 'cut.id')
            ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
            ->select('ali.*', 'cat.name as namecategoria', 'centro.name as namecentrocosto', 'cut.name as namecut')
            ->where('ali.status', 1)
            ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->fecha_workshop);
                $onlyDate = $date->toDateString();
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
					<a href="workshop/create/' . $data->id . '" class="btn btn-dark" title="TallerCerradoPorFecha" target="_blank">
                        <i class="fas fa-check-circle"></i>
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
					<a href="workshop/create/' . $data->id . '" class="btn btn-dark" title="HacerTaller" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Taller" onclick="downWorkshop(' . $data->id . ');" ' . $status . '>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } else {
                    $btn = '
                    <div class="text-center">
					<a href="workshop/create/' . $data->id . '" class="btn btn-dark" title="TallerCerrado" target="_blank">
                        <i class="fas fa-check-circle"></i>
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
            ->rawColumns(['date', 'inventory', 'action'])
            ->make(true);
    }

    public function getProducts(Request $request)
    {


        $products = Product::where([
            ['meatcut_id', $request->categoriaId],
            ['status', 1],
            ['level_product_id', 2]
        ])->get();

        Session::flash('refresh', true);

        return response()->json(['products' => $products]);
    }

    public function updatedetail(Request $request)
    {
        try {
            $prod = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico', 'p.price_fama')
                ->where([
                    ['p.id', $request->productoId],
                    ['ce.centrocosto_id', $request->centrocosto],
                    ['p.status', 1],
                ])->get();

            $newStock = $prod[0]->stock + $request->newpeso_producto_hijo;

            $updatedetails = workshop_detail::firstWhere('id', $request->id);
            $updatedetails->peso_producto_hijo = $request->newpeso_producto_hijo;
            $updatedetails->total = ($request->newpeso_producto_hijo) * ($prod[0]->price_fama);
            $updatedetails->newstock = $newStock;
            $updatedetails->save();

            // Update all records in the table
            workshop_detail::where('id', $request->id)
                ->update([
                    'total' => ($request->newpeso_producto_hijo) * ($prod[0]->price_fama),
                    'costo' => ($request->porcventa) * ($request->totalPrecioVenta),
                ]);

            $arrayTotales = $this->sumTotales($request->tallerId);

            // Update the "total" field for all records in the table

            $workshopDetails = workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;

            foreach ($workshopDetails as $detail) {
                $sumakilosTotal = (float)workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->sum('peso_producto_hijo');
                $porc = (float)number_format($detail->peso_producto_hijo / $sumakilosTotal, 4);

                $sumaTotal = (float)workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->sum('total');
                $porcve = (float)number_format($detail->total / $sumaTotal, 4);
                $porcentajeVenta = (float)number_format($porcve * 100, 2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);
                // $costoTotal = $porcentajecostoTotal * 2;                

                $workshop = Workshop::firstWhere('id', $request->tallerId);
                $costo_kilo_padre = $workshop->costo_kilo_padre;
                $peso_producto_padre = $workshop->peso_producto_padre;

                $total2 = $peso_producto_padre * $costo_kilo_padre;

                //  $total = $detail->peso_producto_hijo *  $costo_kilo_padre;

                $costo = $porcentajecostoTotal * $total2;
                $costo_kilo = $costo / $detail->peso_producto_hijo;

                $updateworkshop = workshop_detail::firstWhere('id', $detail->id);
                $updateworkshop->porcventa = $porcentajeVenta;
                $updateworkshop->costo = $costo;
                $updateworkshop->costo_kilo = $costo_kilo;

                $updateworkshop->save();


                //   $detail->porcventa = (float)number_format(($request->newpeso_producto_hijo * $prod[0]->price_fama) / ($arrayTotales['totalPesoProductoHijo']) * 100, 2);


                // $detail->save();
            }


            $arraydetail = $this->getworkshopdetail($request->tallerId, $request->centrocosto);

            $peso_producto_padre = $request->pesoProductoPadre;
            $sumakilosTotal = (float)workshop_detail::where([['workshops_id', $request->tallerId], ['status', 'VALID']])->sum('peso_producto_hijo');
            $merma = $peso_producto_padre - $sumakilosTotal;


            $newStockPadre = $request->stockPadre - $arrayTotales['totalPesoProductoHijo'];
            $alist = Workshop::firstWhere('id', $request->tallerId);
            $alist->nuevo_stock_padre = $newStockPadre;
            $alist->merma = 789;
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

    public function savedetail(Request $request)
    {
        try {
            $rules = [
                'peso_producto_hijo' => 'required',
                'producto' => 'required',
                'costo_kilo_padre' => 'required|regex:/^\d+(\.\d+)?$/'
            ];
            $messages = [
                'peso_producto_hijo.required' => 'Los kg requeridos son necesarios',
                'producto.required' => 'El producto es requerido',
                'costo_kilo_padre.regex' => 'costo_kilo_padre es un número entero o decimal separado por punto'
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
                ->select('ce.stock', 'ce.fisico', 'p.price_fama')
                ->where([
                    ['p.id', $request->producto],
                    ['ce.centrocosto_id', $request->centrocosto],
                    ['p.status', 1],
                ])->get();
            $formatCantidad = new metodosrogercodeController();
            $sumakilosTotal = (float)Workshop_detail::Where([['workshops_id', $request->workshopId], ['status', 'VALID']])->sum('peso');
            //  $porc = (float)number_format($key->peso / $sumakilosTotal,4);
            //   $porcentajeDesposte = (float)number_format($porc * 100,2);
            $formatpeso_producto_hijo = $formatCantidad->MoneyToNumber($request->peso_producto_hijo);
            $newStock = $prod[0]->stock + $formatpeso_producto_hijo;

            $users_id = Auth::user()->id;

            $details = new workshop_detail();
            $details->workshops_id = $request->tallerId;
            $details->products_id = $request->producto;
            $details->users_id = $users_id;
            $details->precio = $prod[0]->price_fama;
            $details->peso_producto_hijo = $formatpeso_producto_hijo;
            $details->total = $formatpeso_producto_hijo * $prod[0]->price_fama;

            $arrayTotales = $this->sumTotales($request->tallerId);

            $sumakilosTotal = (float)workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->sum('peso_producto_hijo');

            if ($sumakilosTotal != 0) {
                $porcve = (float)number_format($details->total / $sumakilosTotal, 4);
                $details->porcventa = $porcve;
            } else {
                $porcve = (float)number_format(100);
                $details->porcventa = $porcve;
            }

            $porcentajeVenta = (float)number_format($porcve * 100, 2);

            $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);

            $workshop = Workshop::firstWhere('id', $request->tallerId);
            $costo_kilo_padre = $workshop->costo_kilo_padre;
            $peso_producto_padre = $workshop->peso_producto_padre;
            $total2 = $peso_producto_padre * $costo_kilo_padre;
            $costo = $porcentajecostoTotal * $total2;
            $costo_kilo = $costo / $details->peso_producto_hijo;
            $details->costo = $costo;
            $details->costo_kilo = $costo_kilo;
            $details->save();

            $merma = $peso_producto_padre - $sumakilosTotal;

            //   $newStockPadre = $request->stockPadre - $arrayTotales['totalPesoProductoHijo'];
            $alist = Workshop::firstWhere('id', $request->tallerId);
            $alist->total_peso_producto_hijo =  $arrayTotales['totalPesoProductoHijo'];
            $alist->costo_kilo_padre = $request->input('costo_kilo_padre');
            $alist->merma = 99;
            //$alist->nuevo_stock_padre = $newStockPadre;
            $alist->save();

            $arrayTotales = $this->sumTotales($request->tallerId);
            $arraydetail = $this->getworkshopdetail($request->tallerId, $request->centrocosto);

            $workshopDetails = workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;

            foreach ($workshopDetails as $detail) {
                $sumakilosTotal = (float)workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->sum('peso_producto_hijo');
                $porc = (float)number_format($detail->peso_producto_hijo / $sumakilosTotal, 4);

                $sumaTotal = (float)workshop_detail::Where([['workshops_id', $request->tallerId], ['status', 'VALID']])->sum('total');
                $porcve = (float)number_format($detail->total / $sumaTotal, 4);
                $porcentajeVenta = (float)number_format($porcve * 100, 2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);
                // $costoTotal = $porcentajecostoTotal * 2;                

                $workshop = Workshop::firstWhere('id', $request->tallerId);
                $costo_kilo_padre = $workshop->costo_kilo_padre;
                $peso_producto_padre = $workshop->peso_producto_padre;

                $total2 = $peso_producto_padre * $costo_kilo_padre;

                //  $total = $detail->peso_producto_hijo *  $costo_kilo_padre;

                $costo = $porcentajecostoTotal * $total2;
                $costo_kilo = $costo / $detail->peso_producto_hijo;

                $updateworkshop = workshop_detail::firstWhere('id', $detail->id);
                $updateworkshop->porcventa = $porcentajeVenta;
                $updateworkshop->costo = $costo;
                $updateworkshop->costo_kilo = $costo_kilo;

                $updateworkshop->save();

            }

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

    public function getworkshopdetail($tallerId, $centrocostoId)
    {
        $detail = DB::table('workshop_details as wd')
            ->join('products as pro', 'wd.products_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('wd.*', 'pro.name as nameprod', 'pro.code', 'ce.stock', 'ce.fisico')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],
                ['wd.workshops_id', $tallerId],
                ['wd.status', 1]
            ])->get();

        return $detail;
    }

    public function sumTotales($id)
    {
        $totalPesoProductoHijo = (float)workshop_detail::Where([['workshops_id', $id], ['status', 1]])->sum('peso_producto_hijo');
        $totalPrecioVenta = (float)workshop_detail::Where([['workshops_id', $id], ['status', 1]])->sum('total');
        $porcVentaTotal = (float)workshop_detail::Where([['workshops_id', $id], ['status', 'VALID']])->sum('porcventa');
        $newTotalStock = (float)workshop_detail::Where([['workshops_id', $id], ['status', 1]])->sum('newstock');

        $workshop = workshop::find($id);
        $peso_producto_padre = $workshop->peso_producto_padre;
        $total_valor_padre = $workshop->total_valor_padre;

        $totalMerma = $totalPesoProductoHijo - $peso_producto_padre;
        $totalUtilidad = $totalPrecioVenta - $total_valor_padre;

        $porcUtilidad = 0;
        if ($totalPesoProductoHijo != 0) {
            $porcUtilidad = ($totalUtilidad / $totalPrecioVenta) * 100;
        }

        $array = [
            'totalPesoProductoHijo' => $totalPesoProductoHijo,
            'totalPrecioVenta' => $totalPrecioVenta,
            'porcVentaTotal' => $porcVentaTotal,
            'newTotalStock' => $newTotalStock,
            'totalMerma' => $totalMerma,
            'totalUtilidad' => $totalUtilidad,
            'porcUtilidad' => $porcUtilidad,
        ];

        return $array;
    }



    public function editWorkshop(Request $request)
    {
        $reg = Workshop::where('id', $request->id)->first();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $enlist = workshop_detail::where('id', $request->id)->first();
            $enlist->status = 'CANCELED';
            $enlist->save();

            $arraydetail = $this->getworkshopdetail($request->tallerId, $request->centrocosto);
            $arrayTotales = $this->sumTotales($request->tallerId);

            $newStockPadre = $request->stockPadre - $arrayTotales['totalPesoProductoHijo'];
            $alist = Workshop::firstWhere('id', $request->tallerId);
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

    public function destroyWorkshop(Request $request)
    {
        try {
            $alist = Workshop::where('id', $request->id)->first();
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
            $shopp->workshops_id = $request->tallerId;
            $shopp->category_id = $request->categoryId;
            $shopp->productopadre_id = $request->productoPadre;
            $shopp->centrocosto_id = $request->centrocosto;
            $shopp->stock_actual = $request->stockPadre;
            $shopp->ultimo_conteo_fisico = $request->pesokg;
            $shopp->nuevo_stock = $request->newStockPadre;
            $shopp->fecha_shopping = $currentDateTime;
            $shopp->save();

            $regProd = $this->getworkshopdetail($request->tallerId, $request->centrocosto);
            $count = count($regProd);
            if ($count == 0) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No tiene productos agregados'
                ]);
            }
            foreach ($regProd as $key) {
                $shoppDetails = new shopping_enlistment_details();
                $shoppDetails->shopping_enlistment_id = $shopp->id;
                $shoppDetails->products_id = $key->products_id;
                $shoppDetails->stock_actual = $key->stock;
                $shoppDetails->conteo_fisico = $key->fisico;
                $shoppDetails->peso_producto_hijo = $key->peso_producto_hijo;
                $shoppDetails->newstock = $key->newstock;
                $shoppDetails->save();
            }

            $invalist = Workshop::where('id', $request->tallerId)->first();
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

    public function afectarCostos(Request $request)
    {
        $tallerId = $request->input('tallerId');

        $currentDateTime = Carbon::now();
        $formattedDate = $currentDateTime->format('Y-m-d');

        $work = Workshop::find($tallerId);
        $work->fecha_cierre = $formattedDate;
        $work->save();

        $workshopc = Workshop::where('id', $tallerId)->get();

        DB::update(
            "
        UPDATE centro_costo_products c
        JOIN workshop_details d ON c.products_id = d.products_id
        JOIN workshops b ON b.id = d.workshops_id
        JOIN products p ON p.id = d.products_id
        SET       
            p.cost = d.costo_kilo
        WHERE d.workshops_id = :tallerId
        AND b.centrocosto_id = :cencosid 
        AND c.centrocosto_id = :cencosid2 ",
            [
                'tallerId' => $tallerId,
                'cencosid' =>  $work->centrocosto_id,
                'cencosid2' =>  $work->centrocosto_id
            ]
        );

        return response()->json([
            'status' => 1,
            'message' => 'Cargado al inventario exitosamente',
            'workshopc' => $workshopc
        ]);

        // return view('categorias.res.desposte.index', ['beneficio' => $beneficio]);
    }
}
