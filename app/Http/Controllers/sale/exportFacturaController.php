<?php

namespace App\Http\Controllers\sale;

use App\Http\Controllers\Controller;
use App\Models\caja\Caja;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/* $sale = Sale::with('third')->findOrFail($id);
            $sale = Sale::with('third')->whereHas('third', function ($query) {
                $query->where('status', 1);
            })->findOrFail($id); */

class exportFacturaController extends Controller
{
    public function showFactura($id)
    {
        $sale = Sale::findOrFail($id)
            ->join('thirds as third', 'sales.third_id', '=', 'third.id')
            ->join('users as u', 'sales.user_id', '=', 'u.id')
            ->join('centro_costo as centro', 'sales.centrocosto_id', '=', 'centro.id')
            ->leftJoin('formapagos as fp', 'sales.forma_pago_tarjeta_id', '=', 'fp.id')
            ->leftJoin('formapagos as fp2', 'sales.forma_pago_otros_id', '=', 'fp2.id')
            ->leftJoin('formapagos as fp3', 'sales.forma_pago_credito_id', '=', 'fp3.id')
            ->select('sales.*', 'u.name as nameuser', 'third.name as namethird', 'fp.nombre as formapago1', 'fp2.nombre as formapago2', 'fp3.nombre as formapago3', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento', 'sales.total_iva', 'sales.vendedor_id')
            ->where([
                ['sales.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        //  dd($sale);

        $saleDetails = SaleDetail::where('sale_id', $id)
            ->join('products as pro', 'sale_details.product_id', '=', 'pro.id')
            ->select('sale_details.*', 'pro.name as nameprod', 'pro.code', 'sale_details.porc_iva', 'sale_details.iva', 'sale_details.porc_otro_impuesto')
            ->where([
                ['sale_details.sale_id', $id],
                /*   ['sale_details.status', 1] */
            ])->get();

        //  dd($saleDetails);

        $showFactura = PDF::loadView('sale.reporte', compact('sale', 'saleDetails'));
        return $showFactura->stream('sale.pdf');
        //return $showFactura->download('sale.pdf');
    }
}
