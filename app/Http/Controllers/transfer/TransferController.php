<?php

namespace App\Http\Controllers\transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\centros\Centrocosto;
use App\Models\Category;
use App\Models\alistamiento\Alistamiento;
use App\Models\alistamiento\enlistment_details;
use App\Models\transfer\Transfer;
use App\Models\transfer\transfer_details;
use App\Models\Centro_costo_product;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Products\Meatcut;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;
use App\Models\shopping\shopping_enlistment;
use App\Models\shopping\shopping_enlistment_details;



class transferController extends Controller
{
    public function index()
    {
        $category = Category::WhereIn('id', [1, 2, 3])->get();
        $costcenter = Centrocosto::Where('status', 1)->get();
        $centros = Centrocosto::Where('status',1)->get();
        $centroCostoProductos = Centro_costo_product::all();
        //  $products = Product::pluck('name', 'id');
        /*  $dataAlistamiento = DB::table('enlistments as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto')
        ->where('ali.id', $id)
        ->get(); */

        return view("transfer.index", compact('category', 'costcenter', 'centros', 'centroCostoProductos'));
    }

    
    public function create($id)
    {
        //dd($id);
        $dataTransfer = DB::table('enlistments as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto')
        ->where('ali.id', $id)
        ->get();

        $cortes = DB::table('products as p')
        ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
        ->select('p.*', 'ce.stock','ce.fisico','p.id as productopadreId')
            ->where([
                ['p.level_product_id',1],
                ['p.meatcut_id',$dataTransfer[0]->meatcut_id],
                ['p.status',1],
                ['ce.centrocosto_id',$dataTransfer[0]->centrocosto_id],
            ])->get();
        

        /**************************************** */
        $status = '';
        $fechaAlistamientoCierre = Carbon::parse($dataTransfer[0]->fecha_cierre);
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
        if ($dataTransfer[0]->inventario == "added") {
            $statusInventory = "true";
        }else{
            $statusInventory = "false";
        }
        /**************************************** */
        //dd($tt = [$status, $statusInventory]);

        $display = "";
        if($status == "false" || $statusInventory == "true"){
            $display = "display:none;";
        }

        $enlistments = $this->gettransferdetail($id,$dataTransfer[0]->centrocosto_id);

        $arrayTotales = $this->sumTotales($id);

        return view('transfer.create', compact('dataTransfer','cortes','enlistments','arrayTotales','status','statusInventory', 'display'));
    }

   /*    public function store(Request $request)
    {
        try {

            $rules = [
                'centrocostoorigen' => 'required',
                'centrocostodestino' => 'required',
            ];
            $messages = [
                'centrocostoorigen.required' => 'El centro de costo origen es requerido',
                'centrocostodestino.required' => 'El centro de costo destino es requerido',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Transfer::firstWhere('id', $request->transferId);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user = Auth::user()->id;

                $tran = new Transfer();
                $tran->users_id = $id_user;
                $tran->centro_costo_origen_id = $request->centrocostoorigen;
                $tran->centro_costo_destino_id = $request->centrocostodestino;
                
                $tran->fecha_transfer = $currentDateFormat;
                $tran->fecha_cierre = $dateNextMonday;
                $tran->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $tran->id
                ]);
            }
            //}else{
            //$getReg = Compensadores::firstWhere('id', $request->compensadoId);
            //$getReg->categoria_id = $request->categoria;
            //$getReg->thirds_id = $request->provider;
            //$getReg->centrocosto_id = $request->centrocosto;
            //$getReg->factura = $request->factura;
            //$getReg->save();

            //return response()->json([
            //'status' => 1,
            //'message' => 'Guardado correctamente',
            //"registroId" => 0
            //]);
            //}


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    } */

    public function store(Request $request)
    {
        try {

            $rules = [
                'transferId' => 'required',
                'categoria' => 'required',
                'centrocosto' => 'required',
                'selectCortePadre' => 'required',
            ];
            $messages = [
                'transferId.required' => 'El transferId es requerido',
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

            $getReg = Alistamiento::firstWhere('id', $request->compensadoId);

            if($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
			    $current_date->modify('next monday'); // Move to the next Monday
			    $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user= Auth::user()->id;

                $alist = new Alistamiento();
                $alist->users_id = $id_user;
                $alist->categoria_id = $request->categoria;
                $alist->centrocosto_id = $request->centrocosto;
                $alist->meatcut_id = $request->selectCortePadre;
                $alist->fecha_alistamiento= $currentDateFormat;
                $alist->fecha_cierre = $dateNextMonday;
                $alist->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
					"registroId" => $alist->id
                ]);
            }    
            //}else{
                //$getReg = Compensadores::firstWhere('id', $request->compensadoId);
                //$getReg->categoria_id = $request->categoria;
                //$getReg->thirds_id = $request->provider;
                //$getReg->centrocosto_id = $request->centrocosto;
                //$getReg->factura = $request->factura;
                //$getReg->save();

                //return response()->json([
                    //'status' => 1,
                    //'message' => 'Guardado correctamente',
					//"registroId" => 0
                //]);
            //}


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function getProductsByCostcenterOrigin(Request $request)
    {
        $productsorigin = Product::join('centro_costo_products', 'products.id', '=', 'centro_costo_products.products_id')
            ->where('centro_costo_products.centrocosto_id', $request->centrocostoorigenId)
            ->where('products.status', 1)
            ->whereIn('products.level_product_id', [1, 2])
            ->orderBy('products.name')
            ->get(['products.*', 'centro_costo_products.*'])
            ->toArray();

        $categories = Category::all();

        return response()->json([
            'productsorigin' => $productsorigin,
            'categories' => $categories
        ]);
    }

    public function ProductsByCostcenterDest(Request $request)
    {
        $productsdest = Product::join('centro_costo_products', 'products.id', '=', 'centro_costo_products.products_id')
            ->where('centro_costo_products.centrocosto_id', $request->centrocostodestinoId)
            ->where('products.status', 1)
            ->whereIn('products.level_product_id', [1, 2])
            ->orderBy('products.name')
            ->get(['products.*', 'centro_costo_products.*'])
            ->toArray();

        $categories = Category::all();

        return response()->json([
            'productsdest' => $productsdest,
            'categories' => $categories
        ]);
    }

  

    public function gettransferdetail($transferId,$centrocostoId)
    {
        $detail = DB::table('transfer_details as en')
        ->join('products as pro', 'en.products_id', '=', 'pro.id')
        ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
        ->select('en.*', 'pro.name as nameprod','pro.code','ce.stock','ce.fisico')
        ->where([
            ['ce.centrocosto_id',$centrocostoId],
            ['en.transfers_id',$transferId],
            ['en.status',1]
        ])->get();

        return $detail;
    }

    public function sumTotales($id)
    {

        $kgTotalRequeridos = (float)transfer_details::Where([['transfers_id',$id],['status',1]])->sum('kgrequeridos');
        $newTotalStock = (float)transfer_details::Where([['transfers_id',$id],['status',1]])->sum('newstock');

        $array = [
            'kgTotalRequeridos' => $kgTotalRequeridos,
            'newTotalStock' => $newTotalStock,
        ];

        return $array;
    }

    public function show()
    {
        $data = DB::table('transfers as tra')
            ->join('categories as cat', 'tra.categoria_id', '=', 'cat.id')
            ->join('meatcuts as cut', 'tra.meatcut_id', '=', 'cut.id')
            ->join('centro_costo as centro', 'tra.centrocosto_id', '=', 'centro.id')
            ->select('tra.*', 'cat.name as namecategoria', 'centro.name as namecentrocosto', 'cut.name as namecut')
            ->where('tra.status', 1)
            ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->fecha_alistamiento);
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
					<a href="transfer/create/' . $data->id . '" class="btn btn-dark" title="Alistar" >
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
					<a href="transfer/create/' . $data->id . '" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="downTransfer(' . $data->id . ');" ' . $status . '>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } else {
                    $btn = '
                    <div class="text-center">
					<a href="transfer/create/' . $data->id . '" class="btn btn-dark" title="Alistar" >
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
            ->rawColumns(['date', 'inventory', 'action'])
            ->make(true);
    }

    public function updatedetail(Request $request)
    {   
        try {

           $prod = DB::table('products as p')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('ce.stock','ce.fisico')
            ->where([
                ['p.id',$request->productoId],
                ['ce.centrocosto_id',$request->centrocosto],
                ['p.status',1],
                
            ])->get();
            //$prod = Product::firstWhere('id', $request->productoId);
            //$newStock = $prod->stock + $request->newkgrequeridos;
            $newStock = $prod[0]->stock + $request->newkgrequeridos;

            $updatedetails = transfer_details::firstWhere('id', $request->id);
            $updatedetails->kgrequeridos = $request->newkgrequeridos;
            $updatedetails->newstock = $newStock;
            $updatedetails->save();

            $arraydetail = $this->gettransferdetail($request->transferId, $request->centrocosto );
            $arrayTotales = $this->sumTotales($request->transferId);

            $newStockPadre = $request->stockPadre - $arrayTotales['kgTotalRequeridos'];
            $alist = Alistamiento::firstWhere('id', $request->transferId);
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


    public function editTransfer(Request $request)
    {
        $reg = Transfer::where('id', $request->id)->first();
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

    public function getproducts(Request $request)
    {
        $prod = Product::Where([
            ['meatcut_id', $request->categoriaId],
            ['status', 1],
            ['level_product_id', 2]
        ])->get();
        return response()->json(['products' => $prod]);
    }
}
