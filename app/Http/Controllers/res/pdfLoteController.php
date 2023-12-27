<?php

namespace App\Http\Controllers\res;

use App\Http\Controllers\Controller;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class pdfLoteController extends Controller
{
    public function pdfLote($id)
    {
        $lote = DB::table('beneficiores as be')
            ->join('thirds as third', 'be.thirds_id', '=', 'third.id')
            ->join('sacrificios as s', 'be.plantasacrificio_id', '=', 's.id')
            ->join('centro_costo as centro', 'be.centrocosto_id', '=', 'centro.id')
            ->select('be.*', 'third.name as namethird', 's.name as nameplanta', 'third.identification', 'third.direccion', 'centro.name as namecentrocosto')
            ->where([
                ['be.id', $id],
                /*  ['sale_details.status', 1]  */
            ])->get();

        $nameclientpieles = DB::table('thirds')
            ->where('id', $lote[0]->clientpieles_id)
            ->value('name');

        $nameclientvisceras = DB::table('thirds')
            ->where('id', $lote[0]->clientvisceras_id)
            ->value('name');

        //  dd($lote);

        $desposte = DB::table('desposteres as dr')
            ->join('products as pro', 'dr.products_id', '=', 'pro.id')
            ->select('dr.*', 'pro.name as nameprod', 'pro.code')
            ->where('dr.beneficiores_id', $id)
            ->get();

         //   dd($desposte);

     /*    $total_weight = 0;
        $total_precio = 0;
        $total_subtotal = 0;

        foreach ($desposte as $item) {
            $total_weight += $item->peso;
            $total_precio += $item->pcompra;
            $total_subtotal += $item->subtotal;
        } */

        // dd($total_weight);

        $pdfLote = PDF::loadView('categorias.res.beneficiores.pdf', compact('desposte', 'lote', 'nameclientpieles', 'nameclientvisceras'));
        return $pdfLote->stream('categorias.res.beneficiores.pdf');
        //return $pdfCompensado->download('sale.pdf');
    }
}
