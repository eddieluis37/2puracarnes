<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Exports\analisisKGExport;
use Maatwebsite\Excel\Facades\Excel;

class excelAnalisisKGController extends Controller
{
    public function exportToExcel()
    {
        $results = DB::select("
            SELECT 
                IF(cat.name IS NULL, 'Total', cat.name) as CAT,
                IF(me.name IS NULL, 'Total', me.name) as BASICO,
                IF(pro.name IS NULL, 'Total', pro.name) as PRODUCTO,
                SUM(ccp.invinicial) as INI,
                SUM(ccp.compralote) as CL,
                SUM(ccp.alistamiento) AS TF,
                SUM(ccp.compensados) as CP,
                SUM(ccp.trasladoing) as TI,
                SUM(ccp.trasladosal) as TS,
                SUM(ccp.venta) as VE,
                SUM(ccp.notacredito) as NC,
                SUM(ccp.notadebito) as ND,
                SUM(ccp.venta) - (SUM(ccp.notacredito) + SUM(ccp.notadebito)) as TVE,
                SUM(ccp.stock) as SI,
                SUM(ccp.fisico) as INF,
                (SUM(ccp.invinicial) + SUM(ccp.compralote) + SUM(ccp.alistamiento) + SUM(ccp.compensados) + SUM(ccp.trasladoing) + SUM(ccp.trasladosal)) - (SUM(ccp.notacredito) + SUM(ccp.notadebito)) as DIS,
                (SUM(ccp.fisico) - SUM(ccp.stock)) as MER,
                ((SUM(ccp.fisico) - SUM(ccp.stock)) / ((SUM(ccp.invinicial) + SUM(ccp.compralote) + SUM(ccp.alistamiento) + SUM(ccp.compensados) + SUM(ccp.trasladoing) + SUM(ccp.trasladosal)) - (SUM(ccp.notacredito) + SUM(ccp.notadebito))) * 100 ) as PMER
            FROM centro_costo_products as ccp
            JOIN products as pro ON pro.id = ccp.products_id
            JOIN meatcuts as me ON me.id = pro.meatcut_id
            JOIN categories as cat ON pro.category_id = cat.id
            WHERE ccp.centrocosto_id = '1'
            AND (ccp.tipoinventario = 'cerrado' OR ccp.tipoinventario = 'inicial')
            AND pro.status = 1
            GROUP BY CAT, BASICO, PRODUCTO
            WITH ROLLUP;
        ");

        $collection = new Collection($results);

        return Excel::download(new analisisKGExport($collection), 'analisis_kg.xlsx');
    }
}