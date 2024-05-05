<?php

namespace App\Http\Controllers\reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class reporteventaprodController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startDate = Carbon::parse(Carbon::now())->format('Y-m-d');
        $endDate = Carbon::parse(Carbon::now())->format('Y-m-d');

        /*  $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get();
 */
        $category = Category::orderBy('name', 'asc')->get();
        $centros = Centrocosto::Where('status', 1)->get();

        // llama al metodo para calcular el stock
        //   $this->totales(request());
        $response = $this->totales(request()); // Call the totales method
        $totalStock = $response->getData()->totalStock; // Retrieve the totalStock value from the response

        return view('reportes.consolidado', compact('category', 'centros', 'startDate', 'endDate', 'totalStock'));
    }
    /*    public function show(Request $request)
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
                'ccp.notacredito as notacredito',
                'ccp.notadebito as notadebito',
                'ccp.venta_real as venta_real',
                'ccp.stock as stock',
                'ccp.fisico as fisico',
                'ccp.products_id as products_id'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where(function ($query) {
                $query->where('ccp.tipoinventario', 'cerrado')
                    ->orWhere('ccp.tipoinventario', 'inicial');
            })
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        // Calculo de la stock ideal y venta_real
        foreach ($data as $item) {
            
            $venta_real = (($item->venta - $item->notacredito) + $item->notadebito);
            $item->venta_real = round($venta_real, 2);

            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - (($item->venta_real) + $item->trasladosal);
            $item->stock = round($stock, 2);
            // Actualizar el stock 
            DB::table('centro_costo_products')
                ->where('centrocosto_id', $centrocostoId)
                ->where('products_id', $item->products_id)
                ->update([
                    'stock' => $item->stock,
                    'venta_real' => $item->venta_real
                ]);
        }
        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    } */

    public function show(Request $request)
    {
        $startDateId = $request->input('startDateId');
        $endDateId = $request->input('endDateId');

        $data = SaleDetail::with(['sale', 'product.category', 'product.notacredito_details', 'product.notadebito_details'])
            ->whereHas('sale', function ($query) use ($startDateId, $endDateId) {
                $query->whereBetween('created_at', [$startDateId, $endDateId])
                    ->where('status', '1');
            })
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                'categories.name as category_name',
                DB::raw('SUM(sale_details.quantity) as cantidad_venta'),
                'notacredito_details.quantity as notacredito_quantity',
                'notadebito_details.quantity as notadebito_quantity',
                DB::raw('(SUM(sale_details.quantity) + COALESCE(notadebito_details.quantity, 0)) - COALESCE(notacredito_details.quantity, 0) as cantidad_venta_real'),
                DB::raw('(SUM(sale_details.total_bruto) + COALESCE(notadebito_details.total_bruto, 0)) - COALESCE(notacredito_details.total_bruto, 0) as dinero_venta_real'),
                DB::raw('SUM(sale_details.descuento) as descuento_producto'),
                DB::raw('SUM(sale_details.descuento_cliente) as descuento_cliente'),
                DB::raw('(SUM(sale_details.total_bruto) + COALESCE(notadebito_details.total_bruto, 0)) - COALESCE(notacredito_details.total_bruto, 0) - SUM(sale_details.descuento) - SUM(sale_details.descuento_cliente) as sub_total'),
                DB::raw('SUM(sale_details.otro_impuesto) as impuesto_salud'),
                DB::raw('SUM(sale_details.iva) as iva'),
                DB::raw('(SUM(sale_details.total_bruto) + COALESCE(notadebito_details.total_bruto, 0)) - COALESCE(notacredito_details.total_bruto, 0) - SUM(sale_details.descuento) - SUM(sale_details.descuento_cliente) + SUM(sale_details.otro_impuesto) + SUM(sale_details.iva) as total'),
            )
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('notacredito_details', 'notacredito_details.product_id', '=', 'sale_details.product_id')
            ->leftjoin('notadebito_details', 'notadebito_details.product_id', '=', 'sale_details.product_id')
            ->groupBy('products.id', 'products.name', 'categories.name')
            ->orderBy('products.name', 'ASC')
            ->get();

        //  dd($data);

        /*   // Calculo de la stock ideal y venta_real
        foreach ($data as $item) {

            $venta_real = (($item->venta - $item->notacredito) + $item->notadebito);
            $item->venta_real = round($venta_real, 2);

            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - (($item->venta_real) + $item->trasladosal);
            $item->stock = round($stock, 2);
            // Actualizar el stock 
            DB::table('centro_costo_products')
                ->where('centrocosto_id', $centrocostoId)
                ->where('products_id', $item->products_id)
                ->update([
                    'stock' => $item->stock,
                    'venta_real' => $item->venta_real
                ]);
        }
        */
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
                'ccp.notacredito as notacredito',
                'ccp.notadebito as notadebito',
                'ccp.venta_real as venta_real',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where(function ($query) {
                $query->where('ccp.tipoinventario', 'cerrado')
                    ->orWhere('ccp.tipoinventario', 'inicial');
            })
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

            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta_real + $item->trasladosal);
            $item->stock = round($stock, 2);
            $totalStock += $stock;

            $ingresos = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing);
            $item->ingresos = round($ingresos, 2);
            $totalIngresos += $ingresos;

            $ventas = ($item->venta - $item->notacredito) + $item->notadebito;
            $item->ventas = round($ventas, 2);

            $salidas =  $item->trasladosal + (($item->venta - $item->notacredito) + $item->notadebito);
            $item->salidas = round($salidas, 2);
            $totalSalidas += $salidas;

            $totalInvInicial += $item->invinicial;
            $totalCompraLote += $item->compraLote;
            $totalAlistamiento += $item->alistamiento;
            $totalCompensados += $item->compensados;
            $totalTrasladoIng += $item->trasladoing;
            $totalVenta += $item->ventas;
            $totalTrasladoSal += $item->trasladosal;

            $totalConteoFisico += $item->fisico;
            $diferenciaKilos = $totalConteoFisico - $totalStock;
        }

        if ($totalIngresos <= 0) {
            $totalIngresos = 1;
        }

        $porcMerma = $diferenciaKilos / $totalIngresos;

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
                'porcMerma' => number_format($porcMerma * 100, 2),
                'porcMermaPermitida' => number_format($porcMermaPermitida * 100, 2),
                'difKilos' => number_format($difKilos, 2),
                'difPorcentajeMerma' => number_format($difPorcentajeMerma * 100, 2),

            ]
        );
    }

    public function cargarInventariohist(Request $request)
    {
        $v_centrocostoId = $request->input('centrocostoId');
        $v_categoriaId = $request->input('categoriaId');

        // PASO 1 COPIAR DATOS DESDE LA TABLA CENTRO COSTO PRODUCTS HASTA TABLA DE HISTORICO 

        DB::update(
            "
        INSERT INTO centro_costo_product_hists  
        (
          centrocosto_id,
          products_id,
          consecutivo,
          fecha,
          tipoinventario,
          invinicial,
          compralote,
          alistamiento,
          compensados,
          trasladoing,
          trasladosal,
          venta,
          notadebito,
          notacredito,
          venta_real,
          stock,
          fisico,
          price_fama,
          cto_invinicial,
          cto_compralote,
          cto_alistamiento,
          cto_compensados,
          cto_trasladoing,
          cto_trasladosal,
          cto_invfinal,
          cto_invinicial_total,
          cto_compralote_total,
          cto_alistamiento_total,
          cto_compensados_total,
          cto_trasladoing_total,
          cto_trasladosal_total,
          cto_invfinal_total,
          costos,
          cto_venta_total,
          cto_notacredito,
          cto_notadebito,
          total_venta,
          utilidad,
          precioventa_min
        )
        SELECT 
          c.centrocosto_id,
          c.products_id,
          COALESCE((SELECT MAX(consecutivo)+1 FROM centro_costo_product_hists), 1),
          CURDATE(),
          'Final',
          c.invinicial,
          c.compralote,
          c.alistamiento,
          c.compensados,
          c.trasladoing,
          c.trasladosal,
          c.venta,	
          c.notadebito, 
          c.notacredito, 
          c.venta_real,
          c.stock,
          c.fisico,
          c.price_fama,
          c.cto_invinicial,
          c.cto_compralote,
          c.cto_alistamiento,
          c.cto_compensados,
          c.cto_trasladoing,
          c.cto_trasladosal,
          c.cto_invfinal,
          c.cto_invinicial_total,
          c.cto_compralote_total,
          c.cto_alistamiento_total,
          c.cto_compensados_total,
          c.cto_trasladoing_total,
          c.cto_trasladosal_total,
          c.cto_invfinal_total,
          c.costos,
          c.cto_venta_total,
          c.cto_notacredito,
          c.cto_notadebito,
          c.total_venta,
          c.utilidad,
          c.precioventa_min
        FROM centro_costo_products c 
        INNER JOIN products p ON p.id = c.products_id
        WHERE c.centrocosto_id = :centrocostoId        
        AND c.tipoinventario = 'cerrado' 
        OR c.tipoinventario = 'inicial' ",
            [
                'centrocostoId' => $v_centrocostoId,
            ]
        );

        // PASO 2 ACTUALIZAR INVENTARIO INICIAL DESDE EL FISICO 

        DB::update(
            "
         UPDATE centro_costo_products c INNER JOIN products p ON p.id = c.products_id
         SET c.invinicial = c.fisico,
             c.cto_invinicial_total = c.cto_invfinal_total  
         WHERE c.centrocosto_id = :centrocostoId       
         AND c.tipoinventario = 'cerrado'
         OR c.tipoinventario = 'inicial' ",
            [
                'centrocostoId' => $v_centrocostoId,

            ]
        );

        // PASO 3 COLOCAR LOS DATOS EN CERO 

        DB::update(
            "
        UPDATE centro_costo_products c INNER JOIN products p ON p.id = c.products_id
        SET
          c.tipoinventario = 'inicial'
         ,c.compralote = 0
         ,c.alistamiento = 0
         ,c.compensados = 0
         ,c.trasladoing = 0
         ,c.trasladosal = 0
         ,c.venta = 0
         ,c.notadebito = 0
         ,c.notacredito = 0
         ,c.venta_real = 0
         ,c.stock  = 0
         ,c.fisico  = 0
         ,c.price_fama = 0
         ,c.cto_invinicial = 0
         ,c.cto_compralote = 0
         ,c.cto_alistamiento = 0
         ,c.cto_compensados = 0
         ,c.cto_trasladoing = 0
         ,c.cto_trasladosal = 0
         ,c.cto_invfinal = 0         
         ,c.cto_compralote_total = 0
         ,c.cto_alistamiento_total = 0
         ,c.cto_compensados_total = 0
         ,c.cto_trasladoing_total = 0
         ,c.cto_trasladosal_total = 0
         ,c.cto_invfinal_total = 0
         ,c.costos = 0
         ,c.cto_venta_total = 0
         ,c.cto_notacredito = 0
         ,c.cto_notadebito = 0
         ,c.total_venta = 0
         ,c.utilidad = 0
         ,c.precioventa_min = 0       
         WHERE c.centrocosto_id = :centrocostoId        
         AND tipoinventario = 'cerrado'
         OR tipoinventario = 'inicial' ",
            [
                'centrocostoId' => $v_centrocostoId,

            ]
        );

        return response()->json([
            'status' => 1,
            'message' => 'Todas las categorias cargadas al inventario exitosamente',

        ]);
    }

    public function indexhistorico()
    {
        $startDate = '2023-05-01';
        $endDate = '2023-05-08';

        /* $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get(); */

        $category = Category::orderBy('name', 'asc')->get();
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
                'ccp.notacredito as notacredito',
                'ccp.notadebito as notadebito',
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

            $ventas = ($item->venta - $item->notacredito) + $item->notadebito;
            $item->ventas = round($ventas, 2);

            $salidas =  $item->trasladosal + (($item->venta - $item->notacredito) + $item->notadebito);
            $item->salidas = round($salidas, 2);
            $totalSalidas += $salidas;

            $totalInvInicial += $item->invinicial;
            $totalCompraLote += $item->compraLote;
            $totalAlistamiento += $item->alistamiento;
            $totalCompensados += $item->compensados;
            $totalTrasladoIng += $item->trasladoing;
            $totalVenta += $item->ventas;
            $totalVenta = $salidas;
            $totalTrasladoSal += $item->trasladosal;

            $totalConteoFisico += $item->fisico;
            $diferenciaKilos = $totalConteoFisico - $totalStock;
        }

        if ($totalIngresos <= 0) {
            $totalIngresos = 1;
        }

        $porcMerma = $diferenciaKilos / $totalIngresos;

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
                'porcMerma' => number_format($porcMerma * 100, 2),
                'porcMermaPermitida' => number_format($porcMermaPermitida * 100, 2),
                'difKilos' => number_format($difKilos, 2),
                'difPorcentajeMerma' => number_format($difPorcentajeMerma * 100, 2),

            ]
        );
    }
}
