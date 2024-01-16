<?php

namespace App\Http\Controllers\notacredito;

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
use App\Models\NotacreditoDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class notacreditoController extends Controller
{
    public function storeNotacredito(Request $request, $id)
    {

        $ventaId = Sale::find($id);

        //  dd($ventaId->id);
        // Obtener los valores

        $tipo = $request->get('tipo');


        $status = '1'; //1 = pagado

        // Call the cargarInventariocr method
        //   $this->cargarInventariocr($ventaId);

        try {

            $venta = new Notacredito();

            //  dd($venta);
            $venta->user_id = $request->user()->id;
            $venta->sale_id = $ventaId->id;
            $venta->tipo = $tipo;
            $venta->status = $status;
            $venta->fecha_notacredito = now();
            $venta->fecha_cierre = now();

            $count = DB::table('notacreditos')->where('status', '1')->count();
            $resolucion = 'NC ' . str_pad(9000 + $count, 4, '0', STR_PAD_LEFT);
            $venta->resolucion = $resolucion;

            $venta->fecha_notacredito = now();
            $venta->fecha_cierre = now();

            $totalValor = (float)NotacreditoDetail::Where([['sale_id', $id]])->sum('total');
            $venta->valor_total = $totalValor;

            $venta->save();


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


    public function index()
    {
        $ventas = Sale::get();
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $vendedores = Third::Where('vendedor', 1)->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();
        $subcentrodecostos = Subcentrocosto::get();

        return view('notacredito.index', compact('ventas', 'centros', 'clientes', 'vendedores', 'domiciliarios', 'subcentrodecostos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $venta = Notacredito::find($id);
        /*    $detalle = SaleDetail::firstWhere('sale_id', $id); */
        $prod = Product::Where([
            ['status', 1]
        ])
            ->orderBy('category_id', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $ventasdetalle = $this->getventasdetalle($id, 1);
        $arrayTotales = $this->sumTotales($id);

        $detalle = $this->notacreditodetalle($id, 1);


        $datacompensado = DB::table('sales as sa')
            ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('sa.*', 'tird.name as namethird', 'centro.name as namecentrocosto', 'tird.porc_descuento')
            ->where('sa.id', $id)
            ->get();
        //dd($datacompensado);

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


        // dd($ventasdetalle);



        return view('notacredito.create', compact('datacompensado', 'id', 'prod', 'ventasdetalle', 'detalle', 'arrayTotales', 'status'));
    }

    public function obtenerPreciosProducto(Request $request)
    {
        $centrocostoId = $request->input('centrocosto');
        $clienteId = $request->input('cliente');
        $cliente = Third::find($clienteId);
        $producto = Listapreciodetalle::join('products as prod', 'listapreciodetalles.product_id', '=', 'prod.id')
            ->join('thirds as t', 'listapreciodetalles.listaprecio_id', '=', 't.id')
            ->where('prod.id', $request->productId)
            ->where('t.id', $cliente->listaprecio_genericid)
            ->first();
        if ($producto) {
            return response()->json([
                'precio' => $producto->precio,
                'iva' => $producto->iva,
                'otro_impuesto' => $producto->otro_impuesto,
                'porc_desc' => $producto->porc_desc
            ]);
        } else {
            // En caso de que el producto no sea encontrado
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }

    public function getventasdetalle($ventaId, $centrocostoId)
    {
        $detail = DB::table('notacredito_details as dv')
            ->join('products as pro', 'dv.product_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('dv.*', 'pro.name as nameprod', 'pro.code',  'ce.fisico')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stock')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],
                ['dv.sale_id', $ventaId],
            ])->orderBy('dv.id', 'DESC')->get();

        return $detail;
    }

    public function notacreditodetalle($ventaId, $centrocostoId)
    {
        $detail = DB::table('notacredito_details as dv')
            ->join('products as pro', 'dv.product_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('dv.*', 'pro.name as nameprod', 'pro.code',  'ce.fisico')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stock')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],
                ['dv.sale_id', $ventaId],
            ])->orderBy('dv.id', 'DESC')->get();

        return $detail;
    }

    public function sumTotales($id)
    {
        $TotalBrutoSinDescuento = Sale::where('id', $id)->value('total_bruto');
        $TotalDescuentos = Sale::where('id', $id)->value('descuentos');
        $TotalBruto = (float)NotacreditoDetail::Where([['sale_id', $id]])->sum('total_bruto');
        $TotalIva = (float)NotacreditoDetail::Where([['sale_id', $id]])->sum('iva');
        $TotalOtroImpuesto = (float)NotacreditoDetail::Where([['sale_id', $id]])->sum('otro_impuesto');
        $TotalValorAPagar = (float)NotacreditoDetail::Where([['sale_id', $id]])->sum('total');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // Guardar crear nota credito
    {
        try {

            $rules = [
                'ventaId' => 'required',
                'factura' => 'required',

            ];
            $messages = [
                'ventaId.required' => 'El ventaId es requerido',
                'factura.required' => 'La factura es requerida',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Notacredito::firstWhere('id', $request->factura);


            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user = Auth::user()->id;
                //    $idcc = $request->centrocosto;

                $venta = new Notacredito();
                $venta->user_id = $id_user;
                $venta->sale_id = $request->factura;

                $venta->fecha_notacredito = $currentDateFormat;
                $venta->fecha_cierre = $dateNextMonday;

                $venta->valor_total = 0;

                $venta->save();

                //ACTUALIZA CONSECUTIVO 
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
                );

                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
                    "registroId" => $venta->id
                ]);
            } else {
                $getReg = Notacredito::firstWhere('id', $request->factura);

                $getReg->fecha_cierre = now();
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
     * @param  \App\Models\Notacredito  $Notacredito
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        /*  $data = DB::table('notacreditos as nc')
             ->join('sales as sa', 'nc.sale_id', '=', 'sa.id')
              ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('nc')
            ->where('sa.status', 1) 
            ->get(); */

        $data = DB::table('sales as sa')
            ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->leftJoin('notacreditos as nc', 'sa.id', '=', 'nc.sale_id')
            ->select('sa.*', 'nc.tipo', 'sa.resolucion as saresolucion', 'nc.valor_total as nctotal',  'nc.resolucion as ncresolucion', 'nc.status as ncstatus', 'nc.fecha_notacredito', 'tird.name as namethird', 'centro.name as namecentrocosto')
            ->where('sa.tipo', '1')
            ->where('sa.status', '1')
            ->get();

        //  $data = Sale::orderBy('id','desc');

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('ncstatus', function ($data) {
                if ($data->ncstatus == 1) {
                    $ncstatus = '<span class="badge bg-success">Creada</span>';
                } else {
                    $ncstatus = '<span class="badge bg-danger">NO tiene</span>';
                }
                return $ncstatus;
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
					    
                        <a href="notacredito/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFactura" target="_blank">
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
					    <a href="notacredito/create/' . $data->id . '" class="btn btn-dark" title="Detalles">
						    <i class="fas fa-directions"></i>
					    </a>
					   
                        <a href="notacredito/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFacturaPendiente" target="_blank">
                        <i class="far fa-file-pdf"></i>
					    </a>
					  
                        </div>
                        ';
                    //ESTADO Cerrada
                } else {
                    $btn = '
                        <div class="text-center">
                        <a href="notacredito/create/' . $data->id . '" class="btn btn-dark" title="Detalles">
                            <i class="fas fa-directions"></i>
                        </a>
                        <a href="sale/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFacturaCerrada" target="_blank">
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
            ->rawColumns(['ncstatus', 'date', 'action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\notacredito  $notacredito
     * @return \Illuminate\Http\Response
     */

    public function getventasdetail($ventaId)
    {
        $detalles = DB::table('notacredito_details as de')
            ->join('products as pro', 'de.product_id', '=', 'pro.id')
            ->select('de.*', 'pro.name as nameprod', 'pro.code', 'de.porc_iva', 'de.iva', 'de.porc_otro_impuesto',)
            ->where([
                ['de.sale_id', $ventaId],
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

            $formatCantidad = new metodosrogercodeController();

            $formatPrVenta = $formatCantidad->MoneyToNumber($request->price);
            $formatPesoKg = $formatCantidad->MoneyToNumber($request->quantity);

            $getReg = NotacreditoDetail::firstWhere('id', $request->regdetailId);

            $porcDescuento = $request->get('porc_desc');
            $precioUnitarioBruto = ($formatPrVenta * $formatPesoKg);
            $descuento = $precioUnitarioBruto * ($porcDescuento / 100);
            $porc_descuento = $request->get('porc_descuento');

            $descuentoCliente = $precioUnitarioBruto * ($porc_descuento / 100);
            $totalDescuento = $descuento + $descuentoCliente;

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

            if ($getReg == null) {
                $detail = new NotacreditoDetail();
                $detail->sale_id = $request->ventaId;
                $detail->product_id = $request->producto;
                $detail->price = $formatPrVenta;
                $detail->quantity = $request->quantity;
                $detail->porc_desc = $porcDescuento;
                $detail->descuento = $descuento;

                $detail->descuento_cliente = $descuentoCliente;

                $detail->porc_iva = $porcIva;
                $detail->iva = $iva;
                $detail->porc_otro_impuesto = $porcOtroImpuesto;
                $detail->otro_impuesto = $otroImpuesto;

                $detail->total_bruto = $precioUnitarioBrutoConDesc;

                $detail->total = $valorAPagar;

                $detail->save();
            } else {
                $updateReg = NotacreditoDetail::firstWhere('id', $request->regdetailId);
                $detalleVenta = $this->getventasdetail($request->ventaId);
                $ivaprod = $detalleVenta[0]->porc_iva;
                $updateReg->product_id = $request->producto;
                $updateReg->price = $formatPrVenta;
                $updateReg->quantity = $formatPesoKg;
                $updateReg->porc_desc = $porcDescuento;
                $updateReg->descuento = $descuento;

                $updateReg->descuento_cliente = $descuentoCliente;

                $updateReg->iva = $iva;
                $updateReg->porc_iva = $porcIva;
                $updateReg->porc_otro_impuesto = $porcOtroImpuesto;
                $updateReg->otro_impuesto = $otroImpuesto;
                $updateReg->total_bruto = $precioUnitarioBrutoConDesc;
                $updateReg->total = $valorAPagar;
                $updateReg->save();
            }


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

    public function editNotacredito(Request $request)
    {
        $reg = NotacreditoDetail::where('id', $request->id)->first();
        //  dd($reg);
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
    }
}
