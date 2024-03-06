<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Exports\analisisUtilidadExport;
use Maatwebsite\Excel\Facades\Excel;


class excelAnalisisUtilidadController extends Controller
{
    public function exportToExcel()
    {
        $results = DB::select("
        SELECT 
        IF(cat.name IS NULL, 'Total', cat.name) as CAT,
        IF(me.name IS NULL, 'Total', me.name) as BASICO,
        IF(pro.name IS NULL, 'Total', pro.name) as PRODUCTO,
        SUM(ccp.cto_invinicial_total) as INI,
        SUM(ccp.cto_compralote_total) as LOTES,
        SUM(ccp.cto_alistamiento_total) AS TRANF,
        SUM(ccp.cto_compensados_total) as COMPE,
        SUM(ccp.cto_trasladoing_total) as TI,
        SUM(ccp.cto_trasladosal_total) as TS,
        SUM(ccp.cto_invfinal_total) as INVF,
        (SUM(ccp.cto_invinicial_total) + SUM(ccp.cto_compralote_total) + SUM(ccp.cto_alistamiento_total) + SUM(ccp.cto_compensados_total) + SUM(ccp.cto_trasladoing_total) + SUM(ccp.cto_trasladosal_total)) - (SUM(ccp.cto_notacredito) + SUM(ccp.cto_notadebito)) as COSTO,    
        SUM(ccp.cto_venta_total) as VENTA,
        SUM(ccp.cto_notacredito) as NC,
        SUM(ccp.cto_notadebito) as ND,
        SUM(ccp.cto_venta_total) - (SUM(ccp.cto_notacredito) + SUM(ccp.cto_notadebito)) as TOTAL_VENTA,
        (SUM(ccp.cto_venta_total) - (SUM(ccp.cto_notacredito) + SUM(ccp.cto_notadebito)) - (SUM(ccp.cto_invinicial_total) + SUM(ccp.cto_compralote_total) + SUM(ccp.cto_alistamiento_total) + SUM(ccp.cto_compensados_total) + SUM(ccp.cto_trasladoing_total) + SUM(ccp.cto_trasladosal_total))) as UTILIDAD
    FROM centro_costo_products as ccp
    JOIN products as pro ON pro.id = ccp.products_id
    JOIN meatcuts as me ON me.id = pro.meatcut_id
    JOIN categories as cat ON pro.category_id = cat.id
    WHERE ccp.centrocosto_id = '1'
    AND (ccp.tipoinventario = 'cerrado' OR ccp.tipoinventario = 'inicial')
    -- AND pro.category_id = '1'
    AND pro.status = 1
    GROUP BY CAT, BASICO, PRODUCTO
    WITH ROLLUP;
        ");

        $collection = new Collection($results);

        $dateTime = now()->format('Y-m-d_H-i-s'); // Formato de fecha y hora actual

        $fileName = 'Analisis_Utilidad_' . $dateTime . '.xlsx'; // Nombre del archivo con fecha y hora

        return Excel::download(new analisisUtilidadExport($collection), $fileName);
    }
}
