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
        $formapagos = Formapago::whereIn('tipoformapago', ['TARJETA', 'OTROS'])->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();
        $subcentrodecostos = Subcentrocosto::get();

        return view('recibodecaja.index', compact('ventas', 'centros', 'clientes', 'formapagos', 'domiciliarios', 'subcentrodecostos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
        $data = DB::table('recibodecajas as rc')
            /*   ->join('categories as cat', 'rc.categoria_id', '=', 'cat.id') */
            ->join('thirds as tird', 'rc.third_id', '=', 'tird.id')
            ->join('subcentrocostos as centro', 'rc.subcentrocostos_id', '=', 'centro.id')
            ->select('rc.*', 'tird.name as namethird', 'centro.name as namecentrocosto')
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

                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                         <div class="text-center">
                         
                         <a href="sale/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFactura" target="_blank">
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
                         <a href="recibodecaja/create/' . $data->id . '" class="btn btn-dark" title="Detalles">
                             <i class="fas fa-directions"></i>
                         </a>
                        
                         <a href="sale/showFactura/' . $data->id . '" class="btn btn-dark" title="VerFacturaPendiente" target="_blank">
                         <i class="far fa-file-pdf"></i>
                         </a>
                       
                         </div>
                         ';
                    //ESTADO Cerrada
                } else {
                    $btn = '
                         <div class="text-center">
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

                'subcentrodecosto' => 'required',

            ];
            $messages = [
                'recibocajaId.required' => 'El recibocajaId es requerido',
                'cliente.required' => 'El cliente es requerido',
                'formapagos.required' => 'Forma pago es requerido',
                'subcentrodecosto.required' => 'El subcentro de costo es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Recibodecaja::firstWhere('id', $request->recibocajaId);


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
                $recibo->subcentrocostos_id = $request->subcentrodecosto;
                $recibo->formapagos_id = $request->formapagos;
                $recibo->valor_recibido = 0;

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
                $getReg->third_id = $request->vendedor;

                $getReg->subcentrocostos_id = $request->subcentrodecosto;

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
        
        $prod = Sale::Where([

            ['status', '1']
        ])
            /* ->orderBy('category_id', 'asc')
            ->orderBy('name', 'asc') */
            ->get();
        $ventasdetalle = $this->getventasdetalle($id, $venta->centrocosto_id);
        $arrayTotales = $this->sumTotales($id);

        $datacompensado = DB::table('recibodecajas as rc')
            ->join('thirds as tird', 'rc.third_id', '=', 'tird.id')
            ->join('subcentrocostos as centro', 'rc.subcentrocostos_id', '=', 'centro.id')
            ->select('rc.*', 'tird.name as namethird', 'centro.name as namecentrocosto', 'tird.porc_descuento')
            ->where('rc.id', $id)
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


}
