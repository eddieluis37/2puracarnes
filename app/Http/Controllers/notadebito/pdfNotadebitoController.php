<?php

namespace App\Http\Controllers\notadebito;

use App\Http\Controllers\Controller;
use App\Models\Notacredito;
use App\Models\NotacreditoDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Sale;

class pdfNotadebitoController extends Controller
{
    public function showNotadebito($id)
    {
        $sale = Sale::findOrFail($id)
            ->join('thirds as third', 'sales.third_id', '=', 'third.id')
            ->join('users as u', 'sales.user_id', '=', 'u.id')
            ->join('centro_costo as centro', 'sales.centrocosto_id', '=', 'centro.id')
            ->leftJoin('notacreditos as nc', 'sales.id', '=', 'nc.sale_id')
            ->select('sales.*', 'nc.valor_total as nctotal', 'nc.resolucion as ncresolucion', 'u.name as nameuser', 'third.name as namethird', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento', 'sales.total_iva', 'sales.vendedor_id')
            ->where([
                ['sales.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        //  dd($sale);

        $saleDetails = NotacreditoDetail::where('sale_id', $id)
            ->join('products as pro', 'notacredito_details.product_id', '=', 'pro.id')
            ->select('notacredito_details.*', 'pro.name as nameprod', 'pro.code', 'notacredito_details.porc_iva', 'notacredito_details.iva', 'notacredito_details.porc_otro_impuesto')
            ->where([
                ['notacredito_details.sale_id', $id],
                /*   ['sale_details.status', 1] */
            ])->get();

        //  dd($saleDetails);

        $showFactura = PDF::loadView('notacredito.reporte', compact('sale', 'saleDetails'));
        return $showFactura->stream('notacredito.pdf');
        //return $showFactura->download('sale.pdf');
    }
}
