<?php

namespace App\Http\Controllers\notacredito;

use App\Http\Controllers\Controller;
use App\Models\Notacredito;
use App\Models\NotacreditoDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Sale;

class pdfNotacreditoController extends Controller
{
    public function showNotacredito($id)
    {
        $sale = Notacredito::findOrFail($id)                     
            ->leftJoin('sales as sa', 'sa.id', '=', 'notacreditos.sale_id')
            ->Join('thirds as third', 'sa.third_id', '=', 'third.id')
            ->join('users as u', 'sa.user_id', '=', 'u.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('sa.*', 'notacreditos.valor_total as nctotal', 'notacreditos.resolucion as ncresolucion', 'u.name as nameuser', 'third.name as namethird', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento', 'notacreditos.total_iva', 'sa.vendedor_id')
            ->where([
                ['notacreditos.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        //  dd($sale);

        $saleDetails = NotacreditoDetail::where('notacredito_id', $id)
            ->join('products as pro', 'notacredito_details.product_id', '=', 'pro.id')
            ->select('notacredito_details.*', 'pro.name as nameprod', 'pro.code', 'notacredito_details.porc_iva', 'notacredito_details.iva', 'notacredito_details.porc_otro_impuesto')
            ->where([
                ['notacredito_details.notacredito_id', $id],
                /*   ['sale_details.status', 1] */
            ])->get();

        //  dd($saleDetails);

        $showFactura = PDF::loadView('notacredito.reporte', compact('sale', 'saleDetails'));
        return $showFactura->stream('notacredito.pdf');
        //return $showFactura->download('sale.pdf');
    }
}
