<?php

namespace App\Http\Controllers\compensado;

use App\Http\Controllers\Controller;
use App\Models\caja\Caja;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class pdfCompensadoController extends Controller
{
    public function pdfCompensado($id)
    {
        $sale = Sale::findOrFail($id)
            ->join('thirds as third', 'sales.third_id', '=', 'third.id')
            ->join('users as u', 'sales.user_id', '=', 'u.id')
            ->join('centro_costo as centro', 'sales.centrocosto_id', '=', 'centro.id')
            ->select('sales.*', 'u.name as nameuser', 'third.name as namethird', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento', 'sales.total_iva', 'sales.vendedor_id')
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

        $pdfCompensado = PDF::loadView('compensado.pdf', compact('sale', 'saleDetails'));
        return $pdfCompensado->stream('compensado.pdf');
        //return $pdfCompensado->download('sale.pdf');
    }
}
