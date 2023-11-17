<?php

namespace App\Http\Controllers\sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Third;
use App\Models\centros\Centrocosto;
use App\Models\compensado\Compensadores;
use App\Models\compensado\Compensadores_detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;
use App\Models\Centro_costo_product;
use App\Models\Sale;
use App\Models\SaleDetail;



class saleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Sale::get();
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $vendedores = Third::Where('vendedor', 1)->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();

        return view('sale.index',compact('centros','clientes','vendedores','domiciliarios','ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function create($id)
     {
         //$category = Category::WhereIn('id',[1,2,3])->get();
         //$providers = Third::Where('status',1)->get();
         //$centros = Centrocosto::Where('status',1)->get();
         $datacompensado = DB::table('sales as sa')
             /*    ->join('categories as cat', 'sa.categoria_id', '=', 'cat.id') */
             ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
             ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
             ->select('sa.*', 'tird.name as namethird', 'centro.name as namecentrocosto',)
             ->where('sa.id', $id)
             ->get();
 
         $prod = Product::Where([
             /*  ['category_id',$datacompensado[0]->categoria_id], */
             ['status', 1]
         ])
             ->orderBy('category_id', 'asc')
             ->orderBy('name', 'asc')
             ->get();
 
         /**************************************** */
         $status = '';
         $fechaCompensadoCierre = Carbon::parse($datacompensado[0]->fecha_cierre);
         $date = Carbon::now();
         $currentDate = Carbon::parse($date->format('Y-m-d'));
         if ($currentDate->gt($fechaCompensadoCierre)) {
             //'Date 1 is greater than Date 2';
             $status = 'false';
         } elseif ($currentDate->lt($fechaCompensadoCierre)) {
             //'Date 1 is less than Date 2';
             $status = 'true';
         } else {
             //'Date 1 and Date 2 are equal';
             $status = 'false';
         }
         /**************************************** */
 
         $detail = $this->getcompensadoresdetail($id);
 
         $arrayTotales = $this->sumTotales($id);
         //dd($arrayTotales);
         return view('sale.create', compact('datacompensado', 'prod', 'id', 'detail', 'arrayTotales', 'status'));
     }

     public function getventasdetalle($ventaId, $centrocostoId)
     {
         $detail = DB::table('sale_details as dv')
             ->join('products as pro', 'dv.product_id', '=', 'pro.id')
             ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
             ->select('dv.*', 'pro.name as nameprod', 'pro.code',  'ce.fisico')
             ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
             ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stock')
             ->where([
                 ['ce.centrocosto_id', $centrocostoId],                
                 ['dv.sale_id', $ventaId],                
             ])->orderBy('dv.id','DESC')->get();
 
         return $detail;
     }
 
 

    public function getcompensadoresdetail($ventaId)
    {

        $detail = DB::table('sale_details as de')
            ->join('products as pro', 'de.product_id', '=', 'pro.id')
            ->select('de.*', 'pro.name as nameprod', 'pro.code')
            ->where([
                ['de.sale_id', $ventaId],
              /*   ['de.status', 1] */
            ])->get();

        return $detail;
    }

    public function getproducts(Request $request)
    {
        $prod = Product::Where([
            /*   ['category_id',$request->categoriaId], */
            ['status', 1]
        ])->get();
        return response()->json(['products' => $prod]);
    }


    public function savedetail(Request $request)
    {
        try {
            $rules = [
                'ventaId' => 'required',
                'producto' => 'required',
                'price' => 'required',
                'quantity' => 'required',
            ];
            $messages = [
                'ventaId.required' => 'El compensado es requerido',
                'producto.required' => 'El producto es requerido',
                'price.required' => 'El precio de compra es requerido',
                'quantity.required' => 'El peso es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $formatCantidad = new metodosrogercodeController();
            //$yourController->yourFunction($request);
           
            $formatPcompra = $formatCantidad->MoneyToNumber($request->price);
            $formatPesoKg = $formatCantidad->MoneyToNumber($request->quantity);
            $subtotal = $formatPcompra * $formatPesoKg;

            $total = $request->kgrequeridos * $request->precioventa; 
            $preciov = $request->precioventa * 1.0; 

            $getReg = SaleDetail::firstWhere('id', $request->regdetailId);

            if ($getReg == null) {
                //$subtotal = $request->price * $request->quantity;
                $detail = new SaleDetail();
                $detail->sale_id = $request->ventaId;
                $detail->product_id = $request->producto;
                $detail->price = $formatPcompra;
                $detail->quantity = $request->quantity;
                $detail->porciva = 0;
                $detail->iva = 0;            
                $detail->total = $total ;
               
                $detail->save();
            } else {
                $updateReg = SaleDetail::firstWhere('id', $request->regdetailId);
                //$subtotal = $request->price * $request->quantity;
                $updateReg->product_id = $request->producto;
                $updateReg->price = $formatPcompra;
                $updateReg->quantity = $formatPesoKg;
                $updateReg->total = $total;
                $updateReg->save();
            }

            $arraydetail = $this->getcompensadoresdetail($request->ventaId);

            $arrayTotales = $this->sumTotales($request->ventaId);

            return response()->json([
                'status' => 1,
                'message' => "Agregado correctamente",
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => (array) $th
            ]);
        }
    }


    public function sumTotales($id)
    {

        //$TotalDesposte = (float)Compensadores_detail::Where([['compensadores_id',$id],['status',1]])->sum('porcdesposte');
        //$TotalVenta = (float)Compensadores_detail::Where([['compensadores_id',$id],['status',1]])->sum('totalventa');
        //$porcVentaTotal = (float)Compensadores_detail::Where([['compensadores_id',$id],['status',1]])->sum('porcventa');
        $pesoTotalGlobal = (float)Compensadores_detail::Where([['compensadores_id', $id], ['status', 1]])->sum('peso');
        $totalGlobal = (float)Compensadores_detail::Where([['compensadores_id', $id], ['status', 1]])->sum('subtotal');
        //$costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.');

        $array = [
            //'TotalDesposte' => $TotalDesposte,
            //'TotalVenta' => $TotalVenta,
            //'porcVentaTotal' => $porcVentaTotal,
            'pesoTotalGlobal' => $pesoTotalGlobal,
            'totalGlobal' => $totalGlobal,
            //'costoKiloTotal' => $costoKiloTotal,
        ];

        return $array;
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
                'ventaId' => 'required',
                'vendedor' => 'required',
                'centrocosto' => 'required',
             
            ];
            $messages = [
                'ventaId.required' => 'El ventaId es requerido',
                'vendedor.required' => 'El proveedor es requerido',
                'centrocosto.required' => 'El centro de costo es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Sale::firstWhere('id', $request->ventaId);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user = Auth::user()->id;
            //    $idcc = $request->centrocosto;

                $venta = new Sale();
                $venta->user_id = $id_user;
                $venta->centrocosto_id = $request->centrocosto;
                $venta->third_id = $request->cliente;
                $venta->vendedor_id = $request->vendedor;
                $venta->domiciliario_id = $request->domiciliario;
              
                $venta->fecha_venta = $currentDateFormat;
                $venta->fecha_cierre = $dateNextMonday;

                $venta->total = 0;
                $venta->items = 0;
                $venta->cash = 0;
                $venta->change = 0;
       
               
                $venta->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $venta->id
                ]);
            } else {
                $getReg = Sale::firstWhere('id', $request->ventaId);
                $getReg->third_id = $request->vendedor;
                $getReg->centrocosto_id = $request->centrocosto;
                $getReg->factura = $request->factura;
                $getReg->save();

                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => 0
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
        $data = DB::table('sales as sa')
            /*   ->join('categories as cat', 'sa.categoria_id', '=', 'cat.id') */
            ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('sa.*', 'tird.name as namethird', 'centro.name as namecentrocosto')
            ->where('sa.status', 1)
            ->get();
        //$data = Sale::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            /*->addColumn('status', function($data){
                    if ($data->estado == 1) {
                        $status = '<span class="badge bg-success">Activo</span>';
                    }else{
                        $status= '<span class="badge bg-danger">Inactivo</span>';
                    }
                    return $status;
                })*/
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->created_at);
                $onlyDate = $date->toDateString();
                return $onlyDate;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                        <div class="text-center">
					    <a href="sale/create/' . $data->id . '" class="btn btn-dark" title="Detalles" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Borrar Compensado" onclick="showDataForm(' . $data->id . ')">
						    <i class="fas fa-eye"></i>
					    </button>
					    <button class="btn btn-dark" title="Borrar Compensado" disabled>
						    <i class="fas fa-trash"></i>
					    </button>
                        </div>
                        ';
                } elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                        <div class="text-center">
					    <a href="sale/create/' . $data->id . '" class="btn btn-dark" title="Detalles" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Compensado" onclick="editCompensado(' . $data->id . ');">
						    <i class="fas fa-edit"></i>
					    </button>
					  
                        </div>
                        ';
                } else {
                    $btn = '
                        <div class="text-center">
					    <a href="sale/create/' . $data->id . '" class="btn btn-dark" title="Detalles" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Compensado" disabled>
						    <i class="fas fa-eye"></i>
					    </button>
					  
                        </div>
                        ';
                }
                return $btn;
            })
            ->rawColumns(['date', 'action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $reg = SaleDetail::where('id', $request->id)->first();
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
    }

    public function editCompensado(Request $request)
    {
        $reg = Sale::where('id', $request->id)->first();
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
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
            $compe = Compensadores_detail::where('id', $request->id)->first();
            $compe->status = 0;
            $compe->save();

            $arraydetail = $this->getcompensadoresdetail($request->ventaId);

            $arrayTotales = $this->sumTotales($request->ventaId);
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

    public function destroyCompensado(Request $request)
    {
        try {
            $compe = Sale::where('id', $request->id)->first();
            $compe->status = 0;
            $compe->save();

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


    public function cargarInventariocr(Request $request)
    {
        $currentDateTime = Carbon::now();
        $formattedDate = $currentDateTime->format('Y-m-d');
        $ventaId = $request->input('ventaId');
        $compensadores = Sale::find($ventaId);
        $compensadores->fecha_cierre = $formattedDate;
        $compensadores->save();
        $compensadores = Sale::where('id', $ventaId)->get();
        $centrocosto_id = $compensadores->first()->centrocosto_id;

        DB::update(
            "
            UPDATE centro_costo_products c
            JOIN compensadores_details d ON c.products_id = d.products_id
            JOIN compensadores b ON b.id = d.compensadores_id
            SET c.cto_compensados =  c.cto_compensados + d.price,
                c.cto_compensados_total  = c.cto_compensados_total + (d.price * d.peso),
                c.tipoinventario = 'cerrado'
            WHERE d.compensadores_id = :compensadoresid
            AND b.centrocosto_id = :cencosid 
            AND c.centrocosto_id = :cencosid2 ",
            [
                'compensadoresid' => $ventaId,
                'cencosid' => $centrocosto_id,
                'cencosid2' => $centrocosto_id
            ]
        );
        // Calcular el peso acumulado del producto 
        $centroCostoProducts = Centro_costo_product::where('tipoinventario', 'cerrado')
            ->where('centrocosto_id', $centrocosto_id)
            ->get();

        foreach ($centroCostoProducts as $centroCostoProduct) {
            $accumulatedWeight = Compensadores_detail::where('compensadores_id', '=', $ventaId)
                ->where('products_id', $centroCostoProduct->products_id)
                ->sum('peso');

            // Almacenar el peso acomulado en la tabla temporal
            DB::table('temporary_accumulatedWeights')->insert([
                'product_id' => $centroCostoProduct->products_id,
                'accumulated_weight' => $accumulatedWeight
            ]);
        }

        // Recuperar los registros de la tabla temporary_accumulatedWeights
        $accumulatedWeights = DB::table('temporary_accumulatedWeights')->get();

        foreach ($accumulatedWeights as $accumulatedWeight) {
            $centroCostoProduct = Centro_costo_product::find($accumulatedWeight->product_id);

            // Sumar el valor de accumulatedWeight al campo compensados
            $centroCostoProduct->compensados += $accumulatedWeight->accumulated_weight;
            $centroCostoProduct->save();            
            
            // Limpiar la tabla temporary_accumulatedWeights
            DB::table('temporary_accumulatedWeights')->truncate();

        }

        return response()->json([
            'status' => 1,
            'message' => 'Cargado al inventario exitosamente',
            'compensadores' => $compensadores
        ]);
    }
}
