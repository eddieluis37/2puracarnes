<?php

namespace App\Http\Controllers\recibodecaja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notacredito;
use App\Models\NotacreditoDetail;
use App\Models\Recibodecaja;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Sale;


class pdfRecibodecajaController extends Controller
{
    public function showRecibodecaja($id)
    {
        $sale = Recibodecaja::findOrFail($id)                     
            ->leftJoin('sales as sa', 'sa.id', '=', 'recibodecajas.sale_id')
            ->Join('thirds as third', 'sa.third_id', '=', 'third.id')
            ->join('users as u', 'sa.user_id', '=', 'u.id')
            ->join('centro_costo as centro', 'sa.centrocosto_id', '=', 'centro.id')
            ->select('sa.*', 'recibodecajas.consecutivo as consecutivo_caja', 'recibodecajas.saldo as saldo', 'recibodecajas.nuevo_saldo as nuevo_saldo', 'recibodecajas.observations as observations', 'recibodecajas.consecutivo as ncresolucion', 'u.name as nameuser', 'third.name as namethird', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento', 'recibodecajas.abono', 'sa.vendedor_id')
            ->where([
                ['recibodecajas.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        //  dd($sale);

     
        

        //  dd($saleDetails);

        $showFactura = PDF::loadView('recibodecaja.reporte', compact('sale'));
        return $showFactura->stream('recibodecaja.pdf');
        //return $showFactura->download('sale.pdf');
    }
}
