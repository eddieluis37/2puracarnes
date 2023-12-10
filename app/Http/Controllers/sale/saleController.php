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
use App\Models\Listapreciodetalle;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Subcentrocosto;

class saleController extends Controller
{
    
    public $valorCambio;

    public function storeRegistroPago(Request $request, $ventaId)
    {
        
       // return $this->valorCambio;
     //  dd($this->valorCambio);

      
        /*    $valorCambio = request()->input('cambio'); */
        /*  $valorCambio = session()->get('cambio'); */
        /* */
        $prueba = $request->user()->id;
        // dd($prueba);

        /*  $valorCambio = $request->input('cambio'); */
      
        $valorCambio = $request->input('porc_descuento');
        dd($valorCambio);

        $valorCambio = request()->input('cambio');

        try {
            $valor_a_pagar = $request->input('valor_a_pagar');
            $venta = Sale::find($ventaId);
            $venta->user_id = $request->user()->id;
            $venta->valor_a_pagar_efectivo = $valorCambio;
            $venta->save();
            return response()->json([
                'status' => 1,
                'message' => 'Guardado correctamente',
                "registroId" => $venta->id
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

        return view('sale.index', compact('ventas', 'centros', 'clientes', 'vendedores', 'domiciliarios', 'subcentrodecostos'));
    }

    public function create($id)
    {
        //$category = Category::WhereIn('id',[1,2,3])->get();
        //$providers = Third::Where('status',1)->get();
        //$centros = Centrocosto::Where('status',1)->get();
        $datacompensado = DB::table('sales as sa')
            ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('sa.*', 'tird.name as namethird', 'centro.name as namecentrocosto', 'tird.porc_descuento')
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

        $detalleVenta = $this->getventasdetail($id);

        //     dd($detalleVenta);

        $arrayTotales = $this->sumTotales($id);
        //  dd($arrayTotales);
        return view('sale.create', compact('datacompensado', 'prod', 'id', 'detalleVenta', 'arrayTotales', 'status'));
    }

    public function create_reg_pago($id)
    {
        $dataVenta = DB::table('sales as sa')
            ->join('thirds as tird', 'sa.third_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('sa.*', 'tird.name as namethird', 'centro.name as namecentrocosto', 'tird.porc_descuento', 'sa.total_iva', 'sa.vendedor_id')
            ->where('sa.id', $id)
            ->get();

        $vendedorId = $dataVenta[0]->vendedor_id;
        $vendedor = Third::where('id', $vendedorId)->value('name');
        $dataVenta[0]->vendedor_name = $vendedor;

        // dd($dataVenta);

        $venta = Sale::find($id);
        $producto = Product::get();
        /*   $ventasdetalle = $this->getventasdetalle($id, $venta->centrocosto_id); */
        $arrayTotales = $this->sumTotales($id);

        $descuento = $dataVenta[0]->porc_descuento / 100 * $arrayTotales['TotalValorAPagar'];
        $subtotal = $arrayTotales['TotalBrutoSinDescuento'] - $arrayTotales['TotalDescuentos'];


        return view('sale.registrar_pago', compact('venta', 'arrayTotales', 'producto', 'dataVenta', 'descuento', 'subtotal'));
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

    /*  public function getventasdetalle($ventaId, $centrocostoId)
    {
        $detail = DB::table('sale_details as dv')
            ->join('products as pro', 'dv.product_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('dv.*', 'pro.name as nameprod', 'pro.code',  'ce.fisico', 'dv.iva as ')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
             ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stock')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],
                ['dv.sale_id', $ventaId],
            ])->orderBy('dv.id', 'DESC')->get();

        return $detail;
    } */



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
            //$yourController->yourFunction($request);
            //$total = $request->kgrequeridos * $request->precioventa;
            //$preciov = $request->precioventa * 1.0;
            //$subtotal = $request->price * $request->quantity;

            //$total = $precioUnitarioBruto *  $request->iva;          

            $formatCantidad = new metodosrogercodeController();

            $formatPrVenta = $formatCantidad->MoneyToNumber($request->price);
            $formatPesoKg = $formatCantidad->MoneyToNumber($request->quantity);

            $getReg = SaleDetail::firstWhere('id', $request->regdetailId);

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
                $detail = new SaleDetail();
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
                $updateReg = SaleDetail::firstWhere('id', $request->regdetailId);
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

            $sale = Sale::find($request->ventaId);
            $sale->items = SaleDetail::where('sale_id', $sale->id)->count();
            $sale->descuentos = $totalDescuento;
            $sale->total_iva = $iva;
            $sale->total_otros_impuestos = $totalOtrosImpuestos;
            $sale->total_valor_a_pagar = $valorApagar;
            $saleDetails = SaleDetail::where('sale_id', $sale->id)->get();
            $totalBruto = 0;
            $totalDesc = 0;

            foreach ($saleDetails as $saleDetail) {
                $totalBruto += $saleDetail->quantity * $saleDetail->price;
                $totalDesc += $saleDetail->descuento + $saleDetail->descuento_cliente;
            }

            $sale->total_bruto = $totalBruto;
            $sale->descuentos = $totalDesc;
            $sale->save();


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

    public function store(Request $request) // Guardar venta por domicilio
    {
        try {

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
                $venta->subcentrocostos_id = $request->subcentrodecosto;

                $venta->fecha_venta = $currentDateFormat;
                $venta->fecha_cierre = $dateNextMonday;

                $venta->total_bruto = 0;
                $venta->descuentos = 0;
                $venta->subtotal = 0;
                $venta->total = 0;
                $venta->total_otros_descuentos = 0;
                $venta->valor_a_pagar_efectivo = 0;
                $venta->valor_a_pagar_tarjeta = 0;
                $venta->valor_a_pagar_otros = 0;
                $venta->valor_a_pagar_credito = 0;
                $venta->valor_pagado = 0;
                $venta->cambio = 0;

                $venta->items = 0;

                $venta->valor_pagado = 0;
                $venta->cambio = 0;


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
                $getReg->subcentrocostos_id = $request->subcentrodecosto;
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
                $formattedDate = $date->format('M-d. H:i');
                return $formattedDate;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                        <div class="text-center">
					    <a href="sale/create/' . $data->id . '" class="btn btn-dark" title="Detalles" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Borrar venta" onclick="showDataForm(' . $data->id . ')">
						    <i class="fas fa-eye"></i>
					    </button>
					    <button class="btn btn-dark" title="Borrar venta" disabled>
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

        $reg = Sale::where('id', $request->id)->first();
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
    }

    public function editCompensado(Request $request)
    {
        $reg = SaleDetail::where('id', $request->id)->first();
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
    public function destroyVenta(Request $request)
    {
        try {
            $compe = SaleDetail::where('id', $request->id)->first();
            $compe->status = 0;
            $compe->save();

            $arraydetail = $this->getventasdetail($request->ventaId);

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

    public function destroy(Request $request)
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

    public function storeVentaMostrador()
    {
        try {
            $currentDateTime = Carbon::now();
            $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
            $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
            $current_date->modify('next monday'); // Move to the next Monday
            $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
            $id_user = Auth::user()->id;

            $venta = new Sale();
            $venta->user_id = $id_user;
            $venta->centrocosto_id = 1; // Valor estático para el campo centrocosto
            $venta->third_id = 33; // Valor estático para el campo third_id
            $venta->vendedor_id = 33; // Valor estático para el campo vendedor_id

            $venta->fecha_venta = $currentDateFormat;
            $venta->fecha_cierre = $dateNextMonday;
            $venta->total_bruto = 0;
            $venta->descuentos = 0;
            $venta->subtotal = 0;
            $venta->total = 0;
            $venta->total_otros_descuentos = 0;
            $venta->valor_a_pagar_efectivo = 0;
            $venta->valor_a_pagar_tarjeta = 0;
            $venta->valor_a_pagar_otros = 0;
            $venta->valor_a_pagar_credito = 0;
            $venta->valor_pagado = 0;
            $venta->cambio = 0;
            $venta->items = 0;
            $venta->valor_pagado = 0;
            $venta->cambio = 0;
            $venta->save();

            return response()->json([
                'status' => 1,
                'message' => 'Inicio de venta por mostrador',
                'registroId' => $venta->id
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function obtenerNombreCliente($id)
    {
        $venta = Sale::find($id);
        if ($venta) {
            $nombreCliente = $venta->third->name;
            return "Nombre del cliente: " . $nombreCliente;
        } else {
            return "Venta no encontrada";
        }
    }
}
