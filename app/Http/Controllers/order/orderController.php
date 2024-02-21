<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\centros\Centrocosto;
use App\Models\Listapreciodetalle;
use App\Models\Notacredito;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Subcentrocosto;
use App\Models\Third;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;
use App\Models\Centro_costo_product;
use App\Models\Cuentas_por_cobrar;
use App\Models\NotacreditoDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products\Meatcut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class orderController extends Controller
{
    public function getDireccionesByCliente($cliente_id)
    {
        $direcciones = Third::where('id', $cliente_id)->orderBy('id', 'desc')->get(); // despliega las mas reciente
        return response()->json($direcciones);
    }

    public function index()
    {
        $direccion = Third::where(function ($query) {
            $query->whereNotNull('direccion')
                ->orWhereNotNull('direccion1')
                ->orWhereNotNull('direccion2')
                ->orWhereNotNull('direccion3')
                ->orWhereNotNull('direccion4');
        })
            ->select('direccion', 'direccion1', 'direccion2', 'direccion3', 'direccion4')
            ->get();

        $ventas = Order::get();
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $vendedores = Third::Where('vendedor', 1)->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();
        $subcentrodecostos = Subcentrocosto::get();


        return view('order.index', compact('ventas', 'direccion', 'centros', 'clientes', 'vendedores', 'domiciliarios', 'subcentrodecostos'));
    }

    public function show()
    {
        $data = DB::table('orders as or')            
            ->join('thirds as tird', 'or.third_id', '=', 'tird.id')
            ->leftJoin('centro_costo as centro', 'or.centrocosto_id', '=', 'centro.id')
            ->join('thirds as vendedor', 'or.vendedor_id', '=', 'vendedor.id')
            ->select('or.*', 'or.status as status', 'total_valor_a_pagar', 'fecha_order', 'tird.direccion as direccion', 'or.resolucion as resolucion', 'tird.name as namethird', 'centro.name as namecentrocosto', 'total_utilidad', 'vendedor.name as nombre_vendedor')
            ->where('or.status', 1)
            ->get();

    

        //  $data = Sale::orderBy('id','desc');

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    $status = '<span class="badge bg-success">Close</span>';
                } else {
                    $status = '<span class="badge bg-danger">Open</span>';
                }
                return $status;
            })
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->created_at);
                $formattedDate = $date->format('M-d. H:i');
                return $formattedDate;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();

                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                        <div class="text-center">
					    
                        <a href="order/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFactura" target="_blank">
                        <i class="far fa-file-pdf"></i>
					    </a>				
					    <button class="btn btn-dark" title="Borrar venta" disabled>
						    <i class="fas fa-trash"></i>
					    </button>
                        </div>
                        ';
                } elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                        <div class="text-center">
					    <a href="order/create/' . $data->id . '" class="btn btn-dark" title="Detalles">
						    <i class="fas fa-directions"></i>
					    </a>
					   
                        <a href="order/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFacturaPendiente" target="_blank">
                        <i class="far fa-file-pdf"></i>
					    </a>
					  
                        </div>
                        ';
                    //ESTADO Cerrada
                } else {
                    $btn = '
                        <div class="text-center">
                        <a href="order/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFacturaCerrada" target="_blank">
                        <i class="far fa-file-pdf"></i>
					    </a>
					    <button class="btn btn-dark" title="Borra la venta" disabled>
						    <i class="fas fa-trash"></i>
					    </button>
					  
                        </div>
                        ';
                }
                return $btn;
            })
            ->rawColumns(['status', 'date', 'action'])
            ->make(true);
    }

    public function store(Request $request) // Crear nota credito desde ventana modal
    {
        try {
            $rules = [
                'ventaId' => 'required',
                'centrocosto' => 'required',
                'vendedor' => 'required',
                'subcentrodecosto' => 'required',
                /* 'factura' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $count = Order::where('sale_id', $value)->count();
                        if ($count >= 2) {
                            $fail('No se puede crear más de 2 notas de crédito para la misma factura');
                        }
                    }
                ], */
            ];
            $messages = [
                'ventaId.required' => 'El ventaId es requerido',
                'centrocosto.required' => 'Centro costo es requerido',
                'vendedor.required' => 'Vendedor es requerido',
                /* 'factura.required' => 'La factura es requerida', */
                'subcentrodecosto.required' => 'Sub Centro de costo es requerido',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }
            $getReg = Order::firstWhere('id', $request->ventaId);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
                $id_user = Auth::user()->id;
                //    $idcc = $request->centrocosto;
                $venta = new Order();
                $venta->user_id = $id_user;
                $venta->third_id = $request->cliente;
                $venta->vendedor_id = $request->vendedor;
                $venta->centrocosto_id = $request->centrocosto;
                $venta->subcentrocostos_id = $request->subcentrodecosto;
                //  dd($request->factura); // es el id de la factura de venta seleccionada en el modal create
                $venta->fecha_order = $currentDateFormat;
                $venta->fecha_entrega = $request->fecha_entrega;
                /*  $venta->fecha_cierre =  now(); */
                $venta->direccion_envio = $request->direccion_evio;
                $venta->items = 0;
                $venta->observacion = $request->observacion;
                $venta->save();
                /* //ACTUALIZA CONSECUTIVO 
                $idcc = $request->centrocosto;
                DB::update(
                    "
        UPDATE notacreditos a,    
        (
            SELECT @numeroConsecutivo:= (SELECT (COALESCE (max(consec),0) ) FROM sales where centrocosto_id = :vcentrocosto1 ),
            @documento:= (SELECT MAX(prefijo) FROM centro_costo where id = :vcentrocosto2 )
        ) as tabla
        SET a.consecutivo =  CONCAT( @documento,  LPAD( (@numeroConsecutivo:=@numeroConsecutivo + 1),5,'0' ) ),
            a.consec = @numeroConsecutivo
        WHERE a.consecutivo is null",
                    [
                        'vcentrocosto1' => $idcc,
                        'vcentrocosto2' => $idcc
                    ]
                ); */
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $venta->id
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'No se puede crear más de 2 notas de crédito para la misma factura'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function create($id)
    {
        $venta = Order::find($id);
        $prod = Product::Where([

            ['status', 1]
        ])
            ->orderBy('category_id', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        /*     $ventasdetalle = $this->getventasdetalle($id, $venta->centrocosto_id); */
        $arrayTotales = $this->sumTotales($id);

        $datacompensado = DB::table('orders as or')
            ->join('thirds as tird', 'or.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'or.centrocosto_id', '=', 'centro.id')
            ->select('or.*', 'tird.name as namethird', 'centro.name as namecentrocosto', 'tird.porc_descuento')
            ->where('or.id', $id)
            ->get();


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


        $detalleVenta = $this->getventasdetail($id);


        return view('order.create', compact('datacompensado', 'id', 'prod', 'detalleVenta', 'arrayTotales', 'status'));
    }

    /* public function getventasdetalle($ventaId, $centrocostoId)
    {
        $detail = DB::table('order_details as dv')
            ->join('products as pro', 'dv.product_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('dv.*', 'pro.name as nameprod', 'pro.code',  'ce.fisico')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stock')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],
                ['dv.order_id', $ventaId],
            ])->orderBy('dv.id', 'DESC')->get();

        return $detail;
    }
 */
    public function sumTotales($id)
    {
        $TotalBrutoSinDescuento = Order::where('id', $id)->value('total_bruto');
        $TotalDescuentos = Order::where('id', $id)->value('descuentos');
        $TotalBruto = (float)OrderDetail::Where([['order_id', $id]])->sum('total_bruto');
        $TotalIva = (float)OrderDetail::Where([['order_id', $id]])->sum('iva');
        $TotalOtroImpuesto = (float)OrderDetail::Where([['order_id', $id]])->sum('otro_impuesto');
        $TotalValorAPagar = (float)OrderDetail::Where([['order_id', $id]])->sum('total');

        $array = [
            'TotalBruto' => $TotalBruto,
            'TotalBrutoSinDescuento' => $TotalBrutoSinDescuento,
            'TotalDescuentos' => $TotalDescuentos,
            'TotalValorAPagar' => $TotalValorAPagar,
            'TotalIva' => $TotalIva,
            'TotalOtroImpuesto' => $TotalOtroImpuesto,
        ];

        return $array;
    }

    public function getventasdetail($ventaId)
    {
        $detalles = DB::table('order_details as de')
            ->join('products as pro', 'de.product_id', '=', 'pro.id')
            ->select('de.*', 'pro.name as nameprod', 'pro.code', 'de.porc_iva', 'de.iva', 'de.porc_otro_impuesto',)
            ->where([
                ['de.order_id', $ventaId],
                /*   ['de.status', 1] */
            ])->get();

        return $detalles;
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
            //$yourController->yourFunction($request);
            //$total = $request->kgrequeridos * $request->precioventa;
            //$preciov = $request->precioventa * 1.0;
            //$subtotal = $request->price * $request->quantity;

            //$total = $precioUnitarioBruto *  $request->iva;          

            $formatCantidad = new metodosrogercodeController();

            $formatPrVenta = $formatCantidad->MoneyToNumber($request->price);
            $formatPesoKg = $formatCantidad->MoneyToNumber($request->quantity);

            $getReg = OrderDetail::firstWhere('id', $request->regdetailId);

            $porcDescuento = $request->get('porc_descuento');
            $precioUnitarioBruto = ($formatPrVenta * $formatPesoKg);
            $descuento_prod = $precioUnitarioBruto * ($porcDescuento / 100);
            $porc_descuento = $request->get('porc_descuento_cli');

            $descuentoCliente = $precioUnitarioBruto * ($porc_descuento / 100);
            $totalDescuento = $descuento_prod + $descuentoCliente;

            $precioUnitarioBrutoConDesc = $precioUnitarioBruto - $totalDescuento;
            $porcIva = $request->get('porc_iva');
            $porcOtroImpuesto = $request->get('porc_otro_impuesto');

            $Impuestos = $porcIva + $request->porc_otro_impuesto;
            $TotalImpuestos = $precioUnitarioBrutoConDesc * ($Impuestos / 100);
            $valorAPagar = $TotalImpuestos + $precioUnitarioBrutoConDesc;

            $iva = $precioUnitarioBrutoConDesc * ($porcIva / 100);
            $otroImpuesto = $precioUnitarioBrutoConDesc * ($porcOtroImpuesto / 100);

            $totalOtrosImpuestos =  $precioUnitarioBrutoConDesc * ($request->porc_otro_impuesto / 100);

            $valorApagar = $precioUnitarioBrutoConDesc + $totalOtrosImpuestos;


            $totalCosto = $request->get('costo_prod') * $formatPesoKg;

            $utilidad = $precioUnitarioBrutoConDesc - $totalCosto;
            $porc_utilidad = ($utilidad / $precioUnitarioBrutoConDesc) * 100;

            if ($getReg == null) {
                $detail = new OrderDetail();
                $detail->order_id = $request->ventaId;
                $detail->product_id = $request->producto;
                $detail->price = $formatPrVenta;
                $detail->quantity = $formatPesoKg;              
                $detail->observaciones =  $request->get('observations');
                $detail->quantity_despachada =$request->get('quantity_despachada');
                $detail->costo_prod = $request->get('costo_prod');
                $detail->porc_desc_prod = $porcDescuento;
                $detail->descuento_prod = $descuento_prod;
                $detail->descuento_cliente = $descuentoCliente;
                $detail->porc_iva = $porcIva;
                $detail->iva = $iva;
                $detail->porc_otro_impuesto = $porcOtroImpuesto;
                $detail->otro_impuesto = $otroImpuesto;
                $detail->total_bruto = $precioUnitarioBrutoConDesc;
                $detail->total_costo = $totalCosto;
                $detail->utilidad = $utilidad;
                $detail->porc_utilidad = $porc_utilidad;             
                $detail->total = $valorAPagar;
                $detail->save();
            } else {
                $updateReg = OrderDetail::firstWhere('id', $request->regdetailId);
                $detalleVenta = $this->getventasdetail($request->ventaId);
                $ivaprod = $detalleVenta[0]->porc_iva;
                $updateReg->product_id = $request->producto;
                $updateReg->price = $formatPrVenta;
                $updateReg->quantity = $formatPesoKg;
                $updateReg->costo_prod =  $request->get('costo_prod');
                $updateReg->porc_desc_prod = $porcDescuento;
                $updateReg->descuento_prod = $descuento_prod;
                $updateReg->descuento_cliente = $descuentoCliente;
                $updateReg->iva = $iva;
                $updateReg->porc_iva = $porcIva;
                $updateReg->porc_otro_impuesto = $porcOtroImpuesto;
                $updateReg->otro_impuesto = $otroImpuesto;
                $updateReg->total_bruto = $precioUnitarioBrutoConDesc;
                $updateReg->total_costo = $totalCosto;
                $updateReg->total_costo = $totalCosto;
                $updateReg->utilidad = $utilidad;
                $updateReg->porc_utilidad = $porc_utilidad;
                $updateReg->save();
            }

            $order = Order::find($request->ventaId);
            $order->items = OrderDetail::where('order_id', $order->id)->count();
            $order->descuentos = $totalDescuento;
            $order->total_iva = $iva;
            $order->total_otros_impuestos = $totalOtrosImpuestos;
            $order->total_valor_a_pagar = $valorApagar;
            $saleDetails = OrderDetail::where('order_id', $order->id)->get();
            $totalBruto = 0;
            $totalDesc = 0;
            $order->total_valor_a_pagar = $saleDetails->where('order_id', $order->id)->sum('total');
            $order->total_utilidad = $saleDetails->where('order_id', $order->id)->sum('utilidad');
            $totalBruto = $saleDetails->sum(function ($saleDetail) {
                return $saleDetail->quantity * $saleDetail->price;
            });
            $totalDesc = $saleDetails->sum(function ($saleDetail) {
                return $saleDetail->descuento_prod + $saleDetail->descuento_cliente;
            });
            $order->total_bruto = $totalBruto;
            $order->descuentos = $totalDesc;
            $count = DB::table('orders')->where('status', '1')->count(); 
            $resolucion = 'OP ' . (1 + $count);
            $order->resolucion = $resolucion;
            $order->save();

            $arraydetail = $this->getventasdetail($request->ventaId);

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

    public function editOrder(Request $request)
    {
        $reg = OrderDetail::where('id', $request->id)->first();
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
    }

    public function destroy(Request $request)
    {


        try {

            $compe = OrderDetail::where('id', $request->id)->first();
            $compe->delete();

            $arraydetail = $this->getventasdetail($request->ventaId);

            $arrayTotales = $this->sumTotales($request->ventaId);


            $order = Sale::find($request->ventaId);
            $order->items = OrderDetail::where('order_id', $order->id)->count();
            $order->descuentos = 0;
            $order->total_iva = 0;
            $order->total_otros_impuestos = 0;
            $saleDetails = OrderDetail::where('order_id', $order->id)->get();
            $totalBruto = 0;
            $totalDesc = 0;
            $total_valor_a_pagar = $saleDetails->where('order_id', $order->id)->sum('total');
            $order->total_valor_a_pagar = $total_valor_a_pagar;
            $totalBruto = $saleDetails->sum(function ($saleDetail) {
                return $saleDetail->quantity * $saleDetail->price;
            });
            $totalDesc = $saleDetails->sum(function ($saleDetail) {
                return $saleDetail->descuento_prod + $saleDetail->descuento_cliente;
            });
            $order->total_bruto = $totalBruto;
            $order->descuentos = $totalDesc;
            $order->save();



            return response()->json([
                'status' => 1,
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales,
                'message' => 'Se realizo con exito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function storeOrder(Request $request, $id) // para cerrar detalles y cargar a inventario
    {

        $ventaId = Order::where('id', $request->id)->latest()->first(); // el ultimo mas reciente;

        $SaleIdNC = $ventaId->sale_id;

        //  dd($SaleIdNC);

        // Obtener los valores

        $tipo = $request->get('tipo');


        $status = '1'; //1 = pagado       

        try {

            $venta = Order::where('id', $id)->latest()->first(); // el ultimo mas reciente;
            $venta->user_id = $request->user()->id;
            $venta->sale_id = $SaleIdNC;
            $venta->tipo = $tipo;
            $venta->status = $status;
            $venta->fecha_notacredito = now();
            $venta->fecha_cierre = now();

            $count1 = DB::table('sales')->where('status', '1')->count();
            $count2 = DB::table('notacreditos')->where('status', '1')->count();
            $count3 = DB::table('notadebitos')->where('status', '1')->count();
            $count = $count1 + $count2 + $count3;
            $resolucion = 'ERPC ' . (1 + $count);
            $venta->resolucion = $resolucion;

            $venta->fecha_notacredito = now();
            $venta->fecha_cierre = now();

            $totalValor = (float)OrderDetail::Where([['notacredito_id', $id]])->sum('total');
            $venta->valor_total = $totalValor;

            $venta->save();

            // Call the cargarInventariocr method
            $this->cargarInventariocr($id);


            if ($venta->status == 1) {
                return redirect()->route('notacredito.index');
            }

            return response()->json([
                'status' => 1,
                'message' => 'Guardado correctamente',
                "registroId" => $venta->id,
                'redirect' => route('notacredito.index')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function obtenerValores(Request $request)
    {
        $centrocostoId = $request->input('centrocosto');
        $clienteId = $request->input('cliente');
        $cliente = Third::find($clienteId);
        $producto = Listapreciodetalle::join('products as prod', 'listapreciodetalles.product_id', '=', 'prod.id')
            ->join('thirds as t', 'listapreciodetalles.listaprecio_id', '=', 't.id')
            ->where('prod.id', $request->productId)
            ->where('t.id', $cliente->listaprecio_genericid)
            ->select('listapreciodetalles.precio', 'iva', 'otro_impuesto', 'listapreciodetalles.porc_descuento', 'cost') // Select only the
            ->first();
        if ($producto) {
            return response()->json([
                'precio' => $producto->precio,
                'iva' => $producto->iva,
                'otro_impuesto' => $producto->otro_impuesto,
                'porc_descuento' => $producto->porc_descuento,
                'costo_prod' => $producto->cost
            ]);
        } else {
            // En caso de que el producto no sea encontrado
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }
}
