<?php

namespace App\Http\Controllers\transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\centros\Centrocosto;
use App\Models\Category;
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
use App\Models\updating\updating_transfer;
use App\Models\updating\updating_transfer_details;


class transferController extends Controller
{
    public function index() // Alimenta el modal_create.blade para posterior store
    {
        // $category = Category::WhereIn('id', [1, 2, 3, 4, 5, 6, 7])->get();
        $costcenter = Centrocosto::Where('status', 1)->get();
        $centros = Centrocosto::Where('status', 1)->get();
        $centroCostoProductos = Centro_costo_product::all();

        return view("transfer.index", compact('costcenter', 'centros', 'centroCostoProductos'));
    }

    public function store(Request $request) // modal create primer paso del diligenciado y llenado de la tabla transfer.
    {
        try {

            $rules = [
                'transferId' => 'required',
                'centrocostoOrigen' => 'required|different:centrocostoDestino',
                'centrocostoDestino' => 'required',
            ];
            $messages = [
                'transferId.required' => 'El transferId es requerido',
                'centrocostoOrigen.required' => 'El centro de costo es requerido',
                'centrocostoOrigen.different' => 'El centro de costo de origen debe ser diferente al centro de costo destino',
                'centrocostoDestino.required' => 'El centro de costo es requerido',
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

                $tranf = new Transfer();
                $tranf->users_id = $id_user;
                $tranf->centrocostoOrigen_id = $request->centrocostoOrigen;
                $tranf->centrocostoDestino_id = $request->centrocostoDestino;
                //   $tranf->products_id = 2;
                $tranf->fecha_tranfer = $currentDateFormat;
                $tranf->fecha_cierre = $dateNextMonday;
                $tranf->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $tranf->id
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function create($id) // http://2puracarnes.test:8080/transfer/create/2  llenado de la vista Translado | Categoria
    {
        // dd($id);
        $dataTransfer = DB::table('transfers as tra')
            //  ->join('categories as cat', 'tra.categoria_id', '=', 'cat.id')
            ->join('centro_costo as centroOrigen', 'tra.centrocostoOrigen_id', '=', 'centroOrigen.id')
            ->join('centro_costo as centroDestino', 'tra.centrocostoDestino_id', '=', 'centroDestino.id')
            ->select('tra.*', 'centroOrigen.name as namecentrocostoOrigen', 'centroDestino.name as namecentrocostoDestino')
            ->where('tra.id', $id)
            ->get();
        // dd($dataTransfer);
        /**************************************** */
        $arrayProductsOrigin = DB::table('products as p')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.id', 'p.name', 'ce.stock as stock_origen', 'ce.fisico as fisico_origen')
            ->where([
                // ['p.level_product_id', [1,2]],
                //   ['p.id', $dataTransfer[0]->products_id],
                // ['p.category_id', $dataTransfer[0]->categoria_id],
                [
                    'p.status', 1
                ],
                ['ce.centrocosto_id', $dataTransfer[0]->centrocostoOrigen_id],                
            ])
            ->orderBy('p.category_id', 'asc')
            ->orderBy('p.name', 'asc')
            ->get();
        // dd($arrayProductsOrigin);
        /**************************************** */
        $arrayProductsDestination = DB::table('products as p')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.id', 'p.name', 'ce.stock as stock_destino', 'ce.fisico as fisico_destino')
            ->where([
                // ['p.level_product_id', [1,2]],
                //   ['p.id', $dataTransfer[0]->products_id],
                //    ['p.category_id', $dataTransfer[0]->categoria_id],
                [
                    'p.status', 1
                ],
                ['ce.centrocosto_id', $dataTransfer[0]->centrocostoDestino_id],          
            ])->get();
        // dd($arrayProductsDestination);
        /**************************************** */
        $status = '';
        $fechaTransferCierre = Carbon::parse($dataTransfer[0]->fecha_cierre);
        $date = Carbon::now();
        $currentDate = Carbon::parse($date->format('Y-m-d'));
        if ($currentDate->gt($fechaTransferCierre)) {
            //'Date 1 is greater than Date 2';
            $status = 'false';
        } elseif ($currentDate->lt($fechaTransferCierre)) {
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
        } else {
            $statusInventory = "false";
        }
        /**************************************** */
        //dd($tt = [$status, $statusInventory]);

        $display = "";
        if ($status == "false" || $statusInventory == "true") {
            $display = "display:none;";
        }

        $transfers = $this->gettransferdetail($id, $dataTransfer[0]->centrocostoOrigen_id);

        $arrayTotales = $this->sumTotales($id);

        return view('transfer.create', compact('dataTransfer', 'transfers', 'arrayProductsOrigin', 'arrayProductsDestination', 'arrayTotales', 'status', 'statusInventory', 'display'));
    }

    public function obtenerValoresProducto(Request $request)
    {
        $centrocostoOrigenId = $request->input('centrocostoOrigen');
        $producto = DB::table('centro_costo_products')
            ->where('products_id', $request->productId)
            ->where('centrocosto_id', $centrocostoOrigenId)
            ->first();
        if ($producto) {
            return response()->json([
                'stock' => $producto->stock,
                'fisico' => $producto->fisico
            ]);
        } else {
            // En caso de que el producto no sea encontrado
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }

    public function obtenerValoresProductoDestino(Request $request)
    {
        // $productId = $request->input('productId');
        // Obtén los valores de stock y fisico para el producto seleccionado
        $centrocostoDestinoId = $request->input('centrocostoDestino');
        $producto = DB::table('centro_costo_products')
            ->where('products_id', $request->productId)
            ->where('centrocosto_id', $centrocostoDestinoId)
            ->first();

        if ($producto) {
            return response()->json([
                'stock' => $producto->stock,
                'fisico' => $producto->fisico
            ]);
        } else {
            // Handle the case when $producto is null
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
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

            $prodOrigen = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico')
                ->where([
                    ['p.id', $request->producto],
                    ['ce.centrocosto_id', $request->centrocostoOrigen],
                    ['p.status', 1],                  
                ])->get();

            $prodDestino = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico')
                ->where([
                    ['p.id', $request->producto],
                    ['ce.centrocosto_id', $request->centrocostoDestino],
                    ['p.status', 1],                 
                ])->get();

            $formatCantidad = new metodosrogercodeController();
            //$prod = Product::firstWhere('id', $request->producto);

            $formatkgrequeridos = $formatCantidad->MoneyToNumber($request->kgrequeridos);
            $newStockOrigen = $prodOrigen[0]->stock - $formatkgrequeridos;
            $newStockDestino = $prodDestino[0]->stock + $formatkgrequeridos;

            $details = new transfer_details();
            $details->transfers_id = $request->transferId;
            $details->products_id = $request->producto;
            $details->kgrequeridos = $formatkgrequeridos;
            $details->actual_stock_origen = $request->stockOrigen;
            $details->nuevo_stock_origen = $newStockOrigen;
            $details->actual_stock_destino = $request->stockDestino;
            $details->nuevo_stock_destino = $newStockDestino;
            $details->save();

            $arraydetail = $this->gettransferdetail($request->transferId, $request->centrocostoOrigen);
            $arrayTotales = $this->sumTotales($request->transferId);

            $newStockOrigen = $request->stockOrigen - $arrayTotales['kgTotalRequeridos'];
            $tranf = Transfer::firstWhere('id', $request->transferId);
            // $tranf->nuevo_stock_origen = $newStockOrigen;
            $tranf->save();

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

    public function gettransferdetail($transferId, $centrocostoDestinoId)
    {
        $detail = DB::table('transfer_details as td')
            ->join('products as pro', 'td.products_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('td.*', 'pro.name as nameprod', 'pro.code', 'ce.stock', 'ce.fisico')
            ->where([
                ['ce.centrocosto_id', $centrocostoDestinoId],
                ['td.transfers_id', $transferId],
                ['td.status', 1],        
            ])->get();

        return $detail;
    }

    public function sumTotales($id)
    {

        $kgTotalRequeridos = (float)transfer_details::Where([['transfers_id', $id], ['status', 1]])->sum('kgrequeridos');
        $newTotalStock = (float)transfer_details::Where([['transfers_id', $id], ['status', 1]])->sum('nuevo_stock_origen');

        $array = [
            'kgTotalRequeridos' => $kgTotalRequeridos,
            'newTotalStock' => $newTotalStock,
        ];

        return $array;
    }

    public function show() // http://2puracarnes.test:8080/transfer  Datatable Traslado | listado
    {
        $data = DB::table('transfers as tra')
            //  ->join('categories as cat', 'tra.categoria_id', '=', 'cat.id')
            //   ->join('products as cut', 'tra.products_id', '=', 'cut.id')
            ->join('centro_costo as centroOrigen', 'tra.centrocostoOrigen_id', '=', 'centroOrigen.id')
            ->join('centro_costo as centroDestino', 'tra.centrocostoDestino_id', '=', 'centroDestino.id')
            ->select('tra.*', 'centroOrigen.name as namecentrocostoOrigen', 'centroDestino.name as namecentrocostoDestino')
            ->where('tra.status', 1)
            ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->fecha_tranfer);
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
					<a href="transfer/create/' . $data->id . '" class="btn btn-dark" title="tranfar" >
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
					<a href="transfer/create/' . $data->id . '" class="btn btn-dark" title="tranfar" >
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
					<a href="transfer/create/' . $data->id . '" class="btn btn-dark" title="tranfar" >
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

            $prodOrigen = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico')
                ->where([
                    ['p.id', $request->producto],
                    ['ce.centrocosto_id', $request->centrocostoOrigen],
                    ['p.status', 1],          
                ])->get();

            $prodDestino = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico')
                ->where([
                    ['p.id', $request->producto],
                    ['ce.centrocosto_id', $request->centrocostoDestino],
                    ['p.status', 1],             
                ])->get();


            //$prod = Product::firstWhere('id', $request->productoId);
            //$newStockOrigen = $prod->stock + $request->newkgrequeridos;
            $newStockOrigen = $prodOrigen[0]->stock + $request->newkgrequeridos;
            $newStockDestino = $prodDestino[0]->stock + $request->newkgrequeridos;

            $updatedetails = transfer_details::firstWhere('id', $request->id);
            $updatedetails->actual_stock_origen = $request->StockOrigen;
            $updatedetails->kgrequeridos = $request->newkgrequeridos;
            $updatedetails->nuevo_stock_origen = $newStockOrigen;
            $updatedetails->actual_stock_destino = $request->stockDestino;
            $updatedetails->nuevo_stock_destino = $request->$newStockDestino;

            $updatedetails->save();

            $arraydetail = $this->gettransferdetail($request->transferId, $request->centrocostoOrigen);
            $arrayTotales = $this->sumTotales($request->transferId);

            $newStockOrigen = $request->stockOrigen - $arrayTotales['kgTotalRequeridos'];
            $tranf = Transfer::firstWhere('id', $request->transferId);
            $tranf->nuevo_stock_origen = $newStockOrigen;
            $tranf->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $enlist = transfer_details::where('id', $request->id)->first();
            $enlist->status = 0;
            $enlist->save();

            $arraydetail = $this->gettransferdetail($request->transferId, $request->centrocostoOrigen);
            $arrayTotales = $this->sumTotales($request->transferId);

            $newStockOrigen = $request->stockOrigen - $arrayTotales['kgTotalRequeridos'];
            $tranf = Transfer::firstWhere('id', $request->transferId);
            //    $tranf->nuevo_stock_origen = $newStockOrigen;
            $tranf->save();

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

    public function destroyTransfer(Request $request)
    {
        try {
            $tranf = Transfer::where('id', $request->id)->first();
            $tranf->status = 0;
            $tranf->save();

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
            $shopp = new updating_transfer();
            $shopp->users_id = $id_user;
            $shopp->transfers_id = $request->transferId;
            //  $shopp->productopadre_id = $request->productoPadre;
            $shopp->centrocostoOrigen_id = $request->centrocostoOrigen;
            $shopp->centrocostoDestino_id = $request->centrocostoDestino;
            $shopp->stock_actual = $request->stockOrigen;
            $shopp->ultimo_conteo_tangible = $request->pesokg;
            $shopp->nuevo_stock = $request->newStockOrigen;
            $shopp->fecha_actualizacion = $currentDateTime;
            $shopp->save();

            $regProd = $this->gettransferdetail($request->transferId, $request->centrocostoOrigen);
            $count = count($regProd);
            if ($count == 0) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No tiene productos agregados'
                ]);
            }
            foreach ($regProd as $key) {
                $shoppDetails = new updating_transfer_details();
                $shoppDetails->updating_transfer_id = $shopp->id;
                $shoppDetails->products_id = $key->products_id;
                $shoppDetails->stock_actual = $key->stock;
                $shoppDetails->conteo_tangible = $key->fisico;
                $shoppDetails->kgrequeridos = $key->kgrequeridos;
                $shoppDetails->nuevo_stock_origen = $key->nuevo_stock_origen;
                $shoppDetails->nuevo_stock_destino = $key->nuevo_stock_destino;
                $shoppDetails->save();

                DB::table('centro_costo_products')
                    ->where('centro_costo_products.products_id', $key->products_id)
                    ->where('centro_costo_products.centrocosto_id', $request->centrocostoDestino)
                    ->join('updating_transfer', 'centro_costo_products.centrocosto_id', '=', 'updating_transfer.centrocostoDestino_id')
                    ->update([
                        'centro_costo_products.trasladoing' => DB::raw('centro_costo_products.trasladoing + ' . $key->kgrequeridos),
                        'centro_costo_products.stock' => DB::raw('centro_costo_products.invinicial + centro_costo_products.compralote + centro_costo_products.alistamiento
                         + centro_costo_products.compensados + centro_costo_products.trasladoing - (centro_costo_products.venta + centro_costo_products.trasladosal)')
                    ]);

                DB::table('centro_costo_products')
                    ->where('centro_costo_products.products_id', $key->products_id)
                    ->where('centro_costo_products.centrocosto_id', $request->centrocostoOrigen)
                    ->join('updating_transfer', 'centro_costo_products.centrocosto_id', '=', 'updating_transfer.centrocostoOrigen_id')
                    ->update([
                        'centro_costo_products.trasladosal' => DB::raw('centro_costo_products.trasladosal + ' . $key->kgrequeridos),
                        'centro_costo_products.stock' => DB::raw('centro_costo_products.invinicial + centro_costo_products.compralote + centro_costo_products.alistamiento
                        + centro_costo_products.compensados + centro_costo_products.trasladoing - (centro_costo_products.venta + centro_costo_products.trasladosal)')
                    ]);
            }

            $invtranf = Transfer::where('id', $request->transferId)->first();
            $invtranf->inventario = "added";
            $invtranf->save();

            DB::commit();
            return response()->json([
                'status' => 1,
                'transfer' => $regProd,
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
