<?php

namespace App\Http\Controllers\recibodecaja;

use App\Models\Recibodecaja;


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
use App\Models\caja\Caja;
use App\Models\Centro_costo_product;
use App\Models\Formapago;
use App\Models\Listapreciodetalle;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Subcentrocosto;


class recibodecajaController extends Controller
{
    public function facturasByCliente($cliente_id)
    {
        $facturas = Sale::where('third_id', $cliente_id)->orderBy('id', 'desc')->get(); // despliega las mas reciente
        return response()->json($facturas);
    }

    public function index()
    {
        $ventas = Sale::get();
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $formapagos = Formapago::whereIn('tipoformapago', ['EFECTIVO', 'TARJETA', 'OTROS'])->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();
        /*      $subcentrodecostos = Subcentrocosto::get(); */

        return view('recibodecaja.index', compact('ventas', 'centros', 'clientes', 'formapagos', 'domiciliarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
        $data = DB::table('recibodecajas as rc')
            ->join('sales as sa', 'rc.sale_id', '=', 'sa.id')
            ->join('thirds as tird', 'rc.third_id', '=', 'tird.id')
            /* ->join('subcentrocostos as centro', 'rc.subcentrocostos_id', '=', 'centro.id') */
            ->select('rc.*', 'sa.resolucion as resolucion_factura', 'tird.name as namethird')
            /*  ->where('rc.status', 1) */
            ->get();

        //  $data = Sale::orderBy('id','desc');

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    $status = '<span class="badge bg-success">Cerrada</span>';
                } else {
                    $status = '<span class="badge bg-danger">Pendiente</span>';
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

                if ($data->status == 1) {
                    $btn = '
                         <div class="text-center">                         
                         <a href="recibodecaja/showRecibodecaja/' . $data->id . '" class="btn btn-dark" title="RecibodecajaCerrado" target="_blank">
                         <i class="far fa-file-pdf"></i>
                         </a>				
                         <button class="btn btn-dark" title="Borrar venta" disabled>
                             <i class="fas fa-trash"></i>
                         </button>
                         <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">E</a>
                         </div>
                         ';
                } elseif ($data->status == 0) {
                    $btn = '
                         <div class="text-center">
                         <a href="recibodecaja/create/' . $data->id . '" class="btn btn-dark" title="Detalles">
                             <i class="fas fa-directions"></i>
                         </a>
                        
                         <a href="recibodecaja/showRecibodecaja/' . $data->id . '" class="btn btn-dark" title="RecibodecajaPendiente" target="_blank">
                         <i class="far fa-file-pdf"></i>
                         </a>
                         <button class="btn btn-dark" title="Borrar venta">
                         <i class="fas fa-trash"></i>
                         </button>
                       
                         </div>
                         ';
                    //ESTADO Cerrada
                } else {
                    $btn = '
                         <div class="text-center">
                         <a href="recibodecaja/showRecibodecaja/' . $data->id . '" class="btn btn-dark" title="RecibodecajaCerrado" target="_blank">
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // Guardar venta por domicilio
    {
        try {

            $rules = [
                'recibocajaId' => 'required',
                'cliente' => 'required',
                'formapagos' => 'required',
                'tipo' => 'required',

            ];
            $messages = [
                'recibocajaId.required' => 'El recibocajaId es requerido',
                'cliente.required' => 'El cliente es requerido',
                'formapagos.required' => 'Forma pago es requerido',
                'tipo.required' => 'El tipo es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Recibodecaja::firstWhere('id', $request->recibocajaId);

           /*  $SaleIdRC = $getReg->sale_id; */

           // dd ($getReg);

            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user = Auth::user()->id;
                //    $idcc = $request->centrocosto;

                $recibo = new Recibodecaja();
                $recibo->user_id = $id_user;
                $recibo->third_id = $request->cliente;
                $recibo->sale_id = 1;
                $recibo->tipo = $request->tipo;
                $recibo->formapagos_id = $request->formapagos;
                $recibo->abono = 0;

                $recibo->fecha_elaboracion = $request->valor_recibo;
                $recibo->fecha_cierre = $dateNextMonday;

                $recibo->save();

                //ACTUALIZA CONSECUTIVO 
                $idcc = $request->centrocosto;
                DB::update(
                    "
        UPDATE recibodecajas a,    
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
                    "registroId" => $recibo->id
                ]);
            } else {
                $getReg = Recibodecaja::firstWhere('id', $request->recibocajaId);
                dd ($getReg);

                $getReg->third_id = $request->vendedor;

                $getReg->tipo = $request->tipo;

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

    public function create($id)
    {
        $venta = Recibodecaja::find($id);
        // dd($venta->third_id);
        $clienteId = $venta->third_id;

        $prod = Sale::Where([
            ['status', '1'],
            ['third_id', $clienteId]
        ])
            /* ->orderBy('category_id', 'asc')
            ->orderBy('name', 'asc') */
            ->get();
        $ventasdetalle = $this->getventasdetalle($id, $venta->centrocosto_id);
        $arrayTotales = $this->sumTotales($id);

        $datacompensado = DB::table('recibodecajas as rc')
            ->join('thirds as tird', 'rc.third_id', '=', 'tird.id')
            ->leftjoin('cuentas_por_cobrars as cc', 'rc.sale_id', '=', 'cc.sale_id')
            /*   ->join('subcentrocostos as centro', 'rc.subcentrocostos_id', '=', 'centro.id') */
            ->select('rc.*', 'cc.deuda_inicial', 'tird.name as namethird', 'tird.porc_descuento', 'tird.identification')
            ->where('rc.id', $id)
            ->orderBy('cc.id', 'desc')
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


        return view('recibodecaja.create', compact('datacompensado', 'id', 'prod', 'detalleVenta', 'ventasdetalle', 'arrayTotales', 'status'));
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
            ])->orderBy('dv.id', 'DESC')->get();

        return $detail;
    }

    public function sumTotales($id)
    {
        $TotalBrutoSinDescuento = Sale::where('id', $id)->value('total_bruto');
        $TotalDescuentos = Sale::where('id', $id)->value('descuentos');
        $TotalBruto = (float)SaleDetail::Where([['sale_id', $id]])->sum('total_bruto');
        $TotalIva = (float)SaleDetail::Where([['sale_id', $id]])->sum('iva');
        $TotalOtroImpuesto = (float)SaleDetail::Where([['sale_id', $id]])->sum('otro_impuesto');
        $TotalValorAPagar = (float)SaleDetail::Where([['sale_id', $id]])->sum('total');

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
        $detalles = DB::table('sale_details as de')
            ->join('products as pro', 'de.product_id', '=', 'pro.id')
            ->select('de.*', 'pro.name as nameprod', 'pro.code', 'de.porc_iva', 'de.iva', 'de.porc_otro_impuesto',)
            ->where([
                ['de.sale_id', $ventaId],
                /*   ['de.status', 1] */
            ])->get();

        return $detalles;
    }

    public function obtenerValores(Request $request)
    {
        $centrocostoId = $request->input('centrocosto');
        $clienteId = $request->input('cliente');
        $cliente = Third::find($clienteId);
        $producto = Sale::join('thirds as t', 'sales.third_id', '=', 't.id')
            ->leftjoin('recibodecajas as rc', 'sales.id', '=', 'rc.sale_id')
            ->where('sales.id', $request->productId)
            ->where('t.id', $cliente->id)
            ->selectRaw('sales.*, sales.valor_a_pagar_credito - SUM(rc.abono) as saldo_pendiente')
            ->groupBy('sales.id', 'rc.id')
            ->orderBy('rc.id', 'desc')
            ->first();
        if ($producto) {
            return response()->json([
                'precio' => $producto->precio,
                'iva' => $producto->iva,
                'facturaId' => $request->productId,
                'deuda_inicial' => $producto->valor_a_pagar_credito,
                'saldo_pendiente' => $producto->saldo_pendiente
            ]);
        } else {
            // En caso de que el producto no sea encontrado
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }

    public function gurdarrecibodecaja(Request $request)
    {
        try {
            $rules = [
                'recibodecajaId' => 'required',
                /*   'producto' => 'required', */
                'abono' => 'required',

            ];
            $messages = [
                'recibodecajaId.required' => 'El reciboId es requerido',
                /*   'producto.required' => 'La factura es requerida', */
                'abono.required' => 'El abono es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }


            $getReg = Recibodecaja::firstWhere('id', $request->recibodecajaId);
            $recibodecajaId = $request->get('recibodecajaId');
            $saldo = str_replace('.', '', $request->get('saldo'));
            $abono = str_replace('.', '', $request->get('abono'));
            $nuevo_saldo = str_replace('.', '', $request->get('nuevo_saldo'));
            //  dd($saldo, $abono, $nuevo_saldo);

            if ($getReg == null) {
                $detail = new Recibodecaja();
                $detail->sale_id = $request->ventaId;
                $detail->product_id = $request->producto;

                $detail->save();
            } else {
                $updateReg = Recibodecaja::firstWhere('id', $request->recibodecajaId);
                $updateReg->sale_id = $request->facturaId;
                $updateReg->abono =  $abono;
                $updateReg->nuevo_saldo = 0;
                $updateReg->status = '1';
                $updateReg->observations = $request->get('observations');

                $count1 = DB::table('recibodecajas')->where('status', '1')->count();
                $resolucion = 'RC' . (1 + $count1);
                $updateReg->consecutivo = $resolucion;
                $updateReg->save();
            }


            /*  $arraydetail = $this->getventasdetail($request->ventaId);

            $arrayTotales = $this->sumTotales($request->ventaId); */

            return response()->json([
                'status' => 1,
                'message' => "Agregado correctamente",
                "registroId" => $updateReg->id,
                /*   'redirect' => route('sale.index') */
                /*       'array' => $arraydetail,
                'arrayTotales' => $arrayTotales */
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => (array) $th
            ]);
        }
    }
}
