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
                'ccp.cto_invinicial_total as cto_invinicial',
                'ccp.cto_compralote_total as cto_compraLote',
                'ccp.cto_compensados_total as cto_compensados',
                'ccp.cto_trasladoing_total as trasladoing',
                'ccp.cto_trasladosal_total as trasladosal',
                'ccp.cto_venta_total as venta',
                'ccp.cto_notacredito as notacredito',
                'ccp.cto_notadebito as notadebito',
                'ccp.stock as stock',
                'ccp.fisico as fisico',
                'ccp.products_id as products_id',
                DB::raw('(pro.cost * ccp.fisico) as invfinaltotal'),
                'ccp.costos as costos',
                DB::raw('((ccp.cto_venta_total - ccp.cto_notacredito) +  ccp.cto_notadebito) as totalventa'),
                DB::raw('(ccp.total_venta - ccp.costos) as utilidad'),
                DB::raw('((ccp.utilidad / ccp.total_venta) * 100) as porc_utilidad'),
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
            $costos = ($item->cto_invinicial + $item->cto_compraLote + $item->cto_compensados + $item->trasladoing) - (($item->invfinaltotal) + $item->trasladosal);
            DB::table('centro_costo_products')
                ->where('centrocosto_id', $centrocostoId)
                ->where('products_id', $item->products_id)
                ->update(['cto_invfinal_total' => $item->invfinaltotal, 'costos' => $costos, 'total_venta' =>  $item->totalventa,  'utilidad' =>  $item->utilidad]);
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
                'ccp.cto_invinicial as cto_invinicial',
                'ccp.compralote as cto_compraLote',
                'ccp.alistamiento',
                'ccp.compensados as cto_compensados',
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

            $stock = ($item->cto_invinicial + $item->cto_compraLote + $item->alistamiento + $item->cto_compensados + $item->trasladoing) - ($item->venta + $item->trasladosal);
            $item->stock = round($stock, 2);
            $totalStock += $stock;

            $ingresos = ($item->cto_invinicial + $item->cto_compraLote + $item->alistamiento + $item->cto_compensados + $item->trasladoing);
            $item->ingresos = round($ingresos, 2);
            $totalIngresos += $ingresos;

            $salidas = ($item->venta + $item->trasladosal);
            $item->salidas = round($salidas, 2);
            $totalSalidas += $salidas;

            $totalInvInicial += $item->cto_invinicial;
            $totalCompraLote += $item->cto_compraLote;
            $totalAlistamiento += $item->alistamiento;
            $totalCompensados += $item->cto_compensados;
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
