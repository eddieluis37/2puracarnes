<?php

namespace App\Http\Controllers\compensado;

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


class pdfCompensadoController extends Controller
{
    public function pdfCompensado($id)
    {
        $comp = DB::table('compensadores as co')
            ->join('thirds as third', 'co.thirds_id', '=', 'third.id')
            ->join('users as u', 'co.users_id', '=', 'u.id')
            ->join('centro_costo as centro', 'co.centrocosto_id', '=', 'centro.id')
            ->select('co.*', 'u.name as nameuser', 'third.name as namethird', 'third.correo', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto', 'third.porc_descuento')
            ->where([
                ['co.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        //  dd($comp);
        
        $compDetails = DB::table('compensadores_details as comp_de')
            ->join('products as pro', 'comp_de.products_id', '=', 'pro.id')
            ->select('comp_de.*', 'pro.name as nameprod', 'pro.code')
            ->where('comp_de.compensadores_id', $id)
            ->where('comp_de.status', '1')
            ->get();

        $total_weight = 0; $total_precio = 0; $total_subtotal = 0;
        
        foreach ($compDetails as $item) {
            $total_weight += $item->peso;
            $total_precio += $item->pcompra;
            $total_subtotal += $item->subtotal;
        }

          // dd($total_weight);

        $pdfCompensado = PDF::loadView('compensado.pdf', compact('compDetails', 'comp', 'total_weight', 'total_precio', 'total_subtotal'));
        return $pdfCompensado->stream('compensado.pdf');
        //return $pdfCompensado->download('sale.pdf');
    }
}
