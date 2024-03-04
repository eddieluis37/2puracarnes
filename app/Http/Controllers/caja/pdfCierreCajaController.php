<?php

namespace App\Http\Controllers\caja;

use App\Http\Controllers\Controller;
use App\Models\caja\Caja;
use App\Models\compensado\Compensadores;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class pdfCierreCajaController extends Controller
{
    public function pdfCierreCaja($id)
    {
        $sale = Caja::findOrFail($id)
            ->leftJoin('sale_caja as sc', 'cajas.cajero_id', '=', 'sc.sale_id')
            ->leftJoin('sales as sa', 'sc.sale_id', '=', 'sa.id')
            ->join('thirds as third', 'cajas.user_id', '=', 'third.id')
            ->leftJoin('users as uu', 'cajas.user_id', '=', 'uu.id')
            ->leftJoin('users as uc', 'cajas.cajero_id', '=', 'uc.id')
            ->join('centro_costo as centro', 'cajas.centrocosto_id', '=', 'centro.id')
            ->leftJoin('formapagos as fp', 'sa.forma_pago_tarjeta_id', '=', 'fp.id')
            ->leftJoin('formapagos as fp2', 'sa.forma_pago_otros_id', '=', 'fp2.id')
            ->leftJoin('formapagos as fp3', 'sa.forma_pago_credito_id', '=', 'fp3.id')
            ->select('cajas.*', 'uu.name as nameuser', 'uc.name as namecajero', 'third.name as namethird', 'fp.nombre as formapago1', 'fp2.nombre as formapago2', 'fp3.nombre as formapago3', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento', 'cajas.total', 'cajas.cajero_id')
            ->where([
                ['cajas.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        // dd($sale);

        $saleDetails = SaleDetail::where('sale_id', $id)
            ->join('products as pro', 'sale_details.product_id', '=', 'pro.id')
            ->select('sale_details.*', 'pro.name as nameprod', 'pro.code', 'sale_details.porc_iva', 'sale_details.iva', 'sale_details.porc_otro_impuesto')
            ->where([
                ['sale_details.sale_id', $id],
                /*   ['sale_details.status', 1] */
            ])->get();

        //  dd($saleDetails);

        // Configurar el idioma en español para Carbon
        Carbon::setLocale('es');

        // Obtener la fecha y hora de inicio del modelo $sale
        $fechaHoraInicio = Carbon::parse($sale[0]->fecha_hora_inicio)->format('Y-m-d H:i');



        $showFactura = PDF::loadView('caja.reporte', compact('sale', 'saleDetails', 'fechaHoraInicio'));
        return $showFactura->stream('caja.pdf');
        //return $showFactura->download('sale.pdf');
    }
}
