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


class exportFacturaController extends Controller
{
    public function showFactura($id)
    {
        $sale = Sale::findOrFail($id);
        $saleDetails = SaleDetail::where('sale_id', $sale->id)
            ->join('products as pro', 'sale_details.product_id', '=', 'pro.id')
            ->select('sale_details.*', 'pro.name as nameprod', 'pro.code', 'sale_details.porc_iva', 'sale_details.iva', 'sale_details.porc_otro_impuesto')
            ->where([
                ['sale_details.sale_id', $id],
                /*   ['sale_details.status', 1] */
            ])->get();


    //    dd($saleDetails[0]->nameprod);

        $showFactura = PDF::loadView('sale.reporte', compact('sale', 'saleDetails'));

        return $showFactura->download('sale.pdf');
    }
}
