<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use Illuminate\Support\Facades\DB;

class inventoryController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startDate = '2023-05-01';
        $endDate = '2023-05-08';

        $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get();

        $centros = Centrocosto::Where('status', 1)->get();

        // llama al metodo para calcular el stock
        //   $this->totales(request());
        $response = $this->totales(request()); // Call the totales method
        $totalStock = $response->getData()->totalStock; // Retrieve the totalStock value from the response

        return view('inventory.consolidado', compact('category', 'centros', 'startDate', 'endDate', 'totalStock'));
    }

    public function show(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');
        $data = DB::table('centro_costo_products as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'ccp.invinicial as invinicial',
                'ccp.compralote as compraLote',
                'ccp.alistamiento',
                'ccp.compensados as compensados',
                'ccp.trasladoing as trasladoing',
                'ccp.trasladosal as trasladosal',
                'ccp.venta as venta',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('ccp.tipoinventario', 'inicial')
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        // Calculo de la stock ideal 

        foreach ($data as $item) {
            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta + $item->trasladosal);
            $item->stock = round($stock, 2);
        }

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function totales(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');
        $data = DB::table('centro_costo_products as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'ccp.invinicial as invinicial',
                'ccp.compralote as compraLote',
                'ccp.alistamiento',
                'ccp.compensados as compensados',
                'ccp.trasladoing as trasladoing',
                'ccp.trasladosal as trasladosal',
                'ccp.venta as venta',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('ccp.tipoinventario', 'inicial')
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        $totalStock = 0;
        $totalInvInicial = 0;
        $totalCompraLote = 0;
        $totalAlistamiento = 0;
        $totalCompensados = 0;
        $totalTrasladoIng = 0;
        $totalVenta = 0;
        $totalTrasladoSal = 0;
        $totalIngresos = 0;
        $totalSalidas = 0;
        $totalConteoFisico = 0;
        
        $diferenciaKilos = 0;
        $porcMermaPermitida = 0;
        $difKilosPermitidos = 0;
        $difKilos = 0;
        $porcMerma = 0;
        $difPorcentajeMerma = 0;

        foreach ($data as $item) {

            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta + $item->trasladosal);
            $item->stock = round($stock, 2);
            $totalStock += $stock;

            $ingresos = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing);
            $item->ingresos = round($ingresos, 2);
            $totalIngresos += $ingresos;

            $salidas = ($item->venta + $item->trasladosal);
            $item->salidas = round($salidas, 2);
            $totalSalidas += $salidas;           

            $totalInvInicial += $item->invinicial;
            $totalCompraLote += $item->compraLote;
            $totalAlistamiento += $item->alistamiento;
            $totalCompensados += $item->compensados;
            $totalTrasladoIng += $item->trasladoing;
            $totalVenta += $item->venta;
            $totalTrasladoSal += $item->trasladosal;

            $totalConteoFisico += $item->fisico;
            $diferenciaKilos = $totalConteoFisico - $totalStock;
            $porcMerma = $diferenciaKilos / $totalIngresos;
        }

            
             
            $porcMermaPermitida = 0.005;
            $difKilosPermitidos = -1 * ($totalIngresos * $porcMermaPermitida);
            $difKilos = $diferenciaKilos - $difKilosPermitidos;
            
           
            $difPorcentajeMerma = $porcMerma + $porcMermaPermitida;

        return response()->json(
            [
                'totalStock' => number_format($totalStock, 2),

                'totalInvInicial' => number_format($totalInvInicial, 2),
                'totalCompraLote' => number_format($totalCompraLote, 2),
                'totalAlistamiento' => number_format($totalAlistamiento, 2),
                'totalCompensados' => number_format($totalCompensados, 2),
                'totalTrasladoing' => number_format($totalTrasladoIng, 2),

                'totalVenta' => number_format($totalVenta, 2),
                'totalTrasladoSal' => number_format($totalTrasladoSal, 2),

                'totalIngresos' => number_format($totalIngresos, 2),
                'totalSalidas' => number_format($totalSalidas, 2),

                'totalConteoFisico' => number_format($totalConteoFisico, 2),
                
                'diferenciaKilos' => number_format($diferenciaKilos, 2),                
                'difKilosPermitidos' => number_format($difKilosPermitidos, 2),
                'porcMerma' => number_format($porcMerma*100, 2),
                'porcMermaPermitida' => number_format($porcMermaPermitida*100, 2),
                'difKilos' => number_format($difKilos, 2),
                'difPorcentajeMerma' => number_format($difPorcentajeMerma*100, 2),

            ]
        );
    }

    public function cargarInventariohist(Request $request)
    {
        $v_centrocostoId = $request->input('centrocostoId');
        $v_categoriaId = $request->input('categoriaId');
                          
        // PASO 1 VOLCADO EN LA TABLA DE HISTORICO 

        DB::update("
        INSERT INTO centro_costo_product_hists  
        (
          centrocosto_id
         ,products_id
         ,consecutivo
         ,fecha
         ,tipoinventario 
         ,invinicial
         ,compralote
         ,alistamiento
         ,compensados
         ,trasladoing
         ,trasladosal
         ,venta
         ,stock 
         ,fisico 
         ,price_fama 
         ,cto_invinicial
         ,cto_compralote
         ,cto_alistamiento
         ,cto_compensados
         ,cto_trasladoing
         ,cto_trasladosal
         ,cto_invfisico 
         ,cto_invinicial_total
         ,cto_compralote_total
         ,cto_alistamiento_total
         ,cto_compensados_total
         ,cto_trasladoing_total
         ,cto_trasladosal_total
         ,cto_invfisico_total
         ,cto_venta_total 
         ,precioventa_min
        )
        
        SELECT c.centrocosto_id
         ,c.products_id
         ,(SELECT COALESCE(MAX(consecutivo)+1,1)FROM centro_costo_product_hists)
         ,CURDATE()
         ,'Final'
         ,c.invinicial
         ,c.compralote
         ,c.alistamiento
         ,c.compensados
         ,c.trasladoing
         ,c.trasladosal
         ,c.venta
         ,c.stock 
         ,c.fisico 
         ,c.price_fama 
         ,c.cto_invinicial
         ,c.cto_compralote
         ,c.cto_alistamiento
         ,c.cto_compensados
         ,c.cto_trasladoing
         ,c.cto_trasladosal
         ,c.cto_invfisico 
         ,c.cto_invinicial_total
         ,c.cto_compralote_total
         ,c.cto_alistamiento_total
         ,c.cto_compensados_total
         ,c.cto_trasladoing_total
         ,c.cto_trasladosal_total
         ,c.cto_invfisico_total
         ,c.cto_venta_total 
         ,c.precioventa_min
        
        FROM centro_costo_products c INNER JOIN products p ON p.id = c.products_id
        WHERE c.centrocosto_id = :centrocostoId
        AND p.category_id = :categoriaId
        AND c.tipoinventario = 'Inicial' " , 
        [
            'centrocostoId' => $v_centrocostoId,
            'categoriaId' => $v_categoriaId            
        ]
         );
         
         // PASO 2 ACTUALIZAR INVENTARIO INICIAL DESDE EL FISICO 
         
         DB::update("
         UPDATE centro_costo_products c INNER JOIN products p ON p.id = c.products_id
         SET c.invinicial = c.fisico       
         WHERE c.centrocosto_id = :centrocostoId
         AND p.category_id = :categoriaId
         AND c.tipoinventario = 'Inicial' ",
        [
            'centrocostoId' => $v_centrocostoId,
            'categoriaId' => $v_categoriaId            
        ]
         );

      // PASO 3 COLOCAR LOS DATOS EN CERO 
         
        DB::update("
        UPDATE centro_costo_products c INNER JOIN products p ON p.id = c.products_id
        SET
         c.compralote = 0
         ,c.alistamiento = 0
         ,c.compensados = 0
         ,c.trasladoing = 0
         ,c.trasladosal = 0
         ,c.venta = 0
         ,c.stock  = 0
         ,c.fisico  = 0
         ,c.price_fama = 0
         ,c.cto_invinicial = 0
         ,c.cto_compralote = 0
         ,c.cto_alistamiento = 0
         ,c.cto_compensados = 0
         ,c.cto_trasladoing = 0
         ,c.cto_trasladosal = 0
         ,c.cto_invfisico  = 0
         ,c.cto_invinicial_total = 0
         ,c.cto_compralote_total = 0
         ,c.cto_alistamiento_total = 0
         ,c.cto_compensados_total = 0
         ,c.cto_trasladoing_total = 0
         ,c.cto_trasladosal_total = 0
         ,c.cto_invfisico_total = 0
         ,c.cto_venta_total = 0
         ,c.precioventa_min = 0       
         WHERE c.centrocosto_id = :centrocostoId
         AND p.category_id = :categoriaId
         AND tipoinventario = 'Inicial' ",
        [
            'centrocostoId' => $v_centrocostoId,
            'categoriaId' => $v_categoriaId            
        ]
        );

        return response()->json([
            'status' => 1,
            'message' => 'Cargado al inventario exitosamente',
            
        ]);
    }

    public function indexhistorico()
    {
        $startDate = '2023-05-01';
        $endDate = '2023-05-08';

        $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get();

        $centros = Centrocosto::Where('status', 1)->get();

        // llama al metodo para calcular el stock
        //   $this->totales(request());
        $response = $this->totaleshist(request()); // Call the totales method
        $totalStock = $response->getData()->totalStock; // Retrieve the totalStock value from the response

        return view('inventory.consolidado_historico', compact('category', 'centros', 'startDate', 'endDate', 'totalStock'));
    }
    public function showhistorico(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');

        $data = DB::table('centro_costo_product_hists as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'fecha',
                'ccp.consecutivo',
                'ccp.invinicial as invinicial',
                'ccp.compralote as compraLote',
                'ccp.alistamiento',
                'ccp.compensados as compensados',
                'ccp.trasladoing as trasladoing',
                'ccp.trasladosal as trasladosal',
                'ccp.venta as venta',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)         
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->whereBetween('fecha', [$fechai, $fechaf])
            ->get();

        // Calculo de la stock ideal 

        foreach ($data as $item) {
            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta + $item->trasladosal);
            $item->stock = round($stock, 2);
        }

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function totaleshist(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');

        $data = DB::table('centro_costo_product_hists as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'ccp.invinicial as invinicial',
                'ccp.compralote as compraLote',
                'ccp.alistamiento',
                'ccp.compensados as compensados',
                'ccp.trasladoing as trasladoing',
                'ccp.trasladosal as trasladosal',
                'ccp.venta as venta',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)   
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->whereBetween('fecha', [$fechai, $fechaf])
            ->get();

        $totalStock = 0;
        $totalInvInicial = 0;
        $totalCompraLote = 0;
        $totalAlistamiento = 0;
        $totalCompensados = 0;
        $totalTrasladoIng = 0;
        $totalVenta = 0;
        $totalTrasladoSal = 0;

        foreach ($data as $item) {

            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta + $item->trasladosal);
            $item->stock = round($stock, 2);
            $totalStock += $stock;

            $totalInvInicial += $item->invinicial;
            $totalCompraLote += $item->compraLote;
            $totalAlistamiento += $item->alistamiento;
            $totalCompensados += $item->compensados;
            $totalTrasladoIng += $item->trasladoing;
            $totalVenta += $item->venta;
            $totalTrasladoSal += $item->trasladosal;
        }

        return response()->json(
            [
                'totalStock' => number_format($totalStock, 2),
                'totalInvInicial' => number_format($totalInvInicial, 2),

                'totalCompraLote' => number_format($totalCompraLote, 2),
                'totalAlistamiento' => number_format($totalAlistamiento, 2),
                'totalCompensados' => number_format($totalCompensados, 2),
                'totalTrasladoing' => number_format($totalTrasladoIng, 2),

                'totalVenta' => number_format($totalVenta, 2),
                'totalTrasladoSal' => number_format($totalTrasladoSal, 2),

            ]
        );
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
    public function destroy($id)
    {
        //
    }
}