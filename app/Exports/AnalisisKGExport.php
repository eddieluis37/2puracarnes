<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnalisisKGExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $resultados = DB::table('zjgifbmb_puracarnes.centro_costo_products as ccp')
            ->join('zjgifbmb_puracarnes.products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('zjgifbmb_puracarnes.meatcuts as me', 'me.id', '=', 'pro.meatcut_id')
            ->join('zjgifbmb_puracarnes.categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                DB::raw("IF(cat.name IS NULL, 'Total', cat.name) as CAT"),
                DB::raw("IF(me.name IS NULL, 'Total', me.name) as BASICO"),
                DB::raw("IF(pro.name IS NULL, 'Total', pro.name) as PRODUCTO"),
                DB::raw("SUM(ccp.invinicial) as INI"),
                DB::raw("SUM(ccp.compralote) as CL"),
                DB::raw("SUM(ccp.alistamiento) AS TF"),
                DB::raw("SUM(ccp.compensados) as CP"),
                DB::raw("SUM(ccp.trasladoing) as TI"),
                DB::raw("SUM(ccp.trasladosal) as TS"),
                DB::raw("SUM(ccp.venta) as VE"),
                DB::raw("SUM(ccp.notacredito) as NC"),
                DB::raw("SUM(ccp.notadebito) as ND"),
                DB::raw("SUM(ccp.stock) as SI"),
                DB::raw("SUM(ccp.fisico) as INF")
            )
            ->where('ccp.centrocosto_id', '1')
            ->where(function ($query) {
                $query->where('ccp.tipoinventario', 'cerrado')
                      ->orWhere('ccp.tipoinventario', 'inicial');
            })
            ->where('pro.status', 1)
            ->groupBy('CAT', 'BASICO', 'PRODUCTO')
            ->get();

        $subtotales = [];
        $total = 0;

        foreach ($resultados as $resultado) {
            $subtotal = $resultado->VE - ($resultado->NC + $resultado->ND);
            $subtotales[$resultado->CAT][$resultado->BASICO][$resultado->PRODUCTO] = $subtotal;
            $total += $subtotal;
        }

        $subtotales['Total']['Total']['Total'] = $total;

        return collect($subtotales);
    }

    public function headings(): array
    {
        return [
            'CAT',
            'BASICO',
            'PRODUCTO',
            'INI',
            'CL',
            'TF',
            'CP',
            'TI',
            'TS',
            'VE',
            'NC',
            'ND',
            'SI',
            'INF'
        ];
    }
}