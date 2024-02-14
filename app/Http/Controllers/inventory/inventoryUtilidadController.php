<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use Illuminate\Support\Facades\DB;

class inventoryUtilidadController extends Controller
{
    public function index()
    {
        $startDate = '2023-05-01';
        $endDate = '2023-05-08';

        /*  $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get();
 */
        $category = Category::orderBy('name', 'asc')->get();
        $centros = Centrocosto::Where('status', 1)->get();

        // llama al metodo para calcular el stock
        //   $this->totales(request());
        $response = $this->totales(request()); // Call the totales method
        $totalStock = $response->getData()->totalStock; // Retrieve the totalStock value from the response

        return view('inventory.utilidad', compact('category', 'centros', 'startDate', 'endDate', 'totalStock'));
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
                'ccp.cto_invinicial_total as invinicial',
                'ccp.cto_compralote_total as compraLote',
                'ccp.alistamiento',
                'ccp.cto_compensados_total as compensados',
                'ccp.cto_trasladoing_total as trasladoing',
                'ccp.cto_trasladosal_total as trasladosal',                
                'ccp.cto_venta_total as venta',
                'ccp.cto_notacredito as notacredito',
                'ccp.cto_notadebito as notadebito',
                'ccp.stock as stock',
                'ccp.fisico as fisico',
                'ccp.products_id as products_id',
                DB::raw('(pro.cost * ccp.fisico) as invfinaltotal')
            )          
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where(function ($query) {
                $query->where('ccp.tipoinventario', 'cerrado')
                    ->orWhere('ccp.tipoinventario', 'inicial');
            })
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        // Calculo de la stock ideal 
        foreach ($data as $item) {
            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - (($item->venta ) + $item->trasladosal) - ($item->notacredito - $item->notadebito);
            $item->stock = round($stock, 2);
           /*  // Actualizar el stock 
            DB::table('centro_costo_products')
                ->where('centrocosto_id', $centrocostoId)
                ->where('products_id', $item->products_id)
                ->update(['stock' => $item->stock]); */
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
