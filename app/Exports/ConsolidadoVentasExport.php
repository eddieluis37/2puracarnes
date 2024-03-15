<?php

namespace App\Exports;

use App\Models\Centro_costo_product;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

// dd(Centro_costo_product::all());
class ConsolidadoVentasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::select(           
            'products.name as producto',
            'sd.quantity',
            'sd.price',
            'sd.total as total_sale_detail',                                                               
            'sales.valor_a_pagar_efectivo',
            'sales.valor_a_pagar_tarjeta',
            'sales.valor_a_pagar_otros',
            'sales.valor_a_pagar_credito',
            'sales.total_valor_a_pagar',
            'sales.valor_pagado',       
            'formapagos_tarjeta.nombre as forma_pago_tarjeta_nombre',
            'formapagos_otros.nombre as forma_pago_otros_nombre',
            DB::raw('MAX(sales.fecha_venta) as fecha_venta'),
            'sales.id',
            DB::raw('MAX(sales.consecutivo) as consecutivo'),

            DB::raw('MAX(sales.forma_pago_tarjeta_id) as forma_pago_tarjeta_id'),
            DB::raw('MAX(sales.forma_pago_otros_id) as forma_pago_otros_id'),

            DB::raw('MAX(sales.total) as total'),
            DB::raw('MAX(sales.items) as items'),
            DB::raw('MAX(sales.status) as status'),
            DB::raw('MAX(u.name) as user'),
            DB::raw('MAX(sales.valor_a_pagar_efectivo) as valor_a_pagar_efectivo'),         
            

            
          
      /*       */
            
        )
            ->join('users as u', 'u.id', 'sales.user_id')
            ->join('sale_details as sd', 'sales.id', 'sd.sale_id')
            ->join('products', 'products.id', '=', 'sd.product_id')         
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('formapagos as formapagos_tarjeta', 'formapagos_tarjeta.id', '=', 'sales.forma_pago_tarjeta_id') // Unir con formapagos para forma_pago_tarjeta
            ->leftJoin('formapagos as formapagos_otros', 'formapagos_otros.id', '=', 'sales.forma_pago_otros_id') // Unir con formapagos para forma_pago_otros */
            ->where('sales.tipo', '0')
            ->where('sales.id', '>', '1602')
           /*  ->groupBy('products.name') */
            ->groupBy('products.name', 'sd.quantity', 'sd.price', 'sd.total', 'formapagos_tarjeta.nombre', 'formapagos_otros.nombre', 'valor_a_pagar_efectivo', 'forma_pago_tarjeta_id', 'forma_pago_otros_id', 'sales.id') // Incluir todos los campos en el GROUP BY
            ->get();
    }

    public function headings(): array
    {
        return [            
            'NOMBRE PRODUCTO',
            'CANTIDAD',
            'VALOR UNITARIO',
            'VALOR TOTAL',            
            'VALOR A PAGAR EFECTIVO',
            'VALOR A PAGAR TARJETA',
            'VALOR A PAGAR OTROS',
            'VALOR A PAGAR CREDITO',
            'TOTAL VALOR A PAGAR',
            'VALOR PAGADO',
            'FORMA PAGO TARJETA NOMBRE',
            'FORMA PAGO OTROS NOMBRE',
            'FECHA VENTA',   
            'ID',
            'CONSECUTIVO',           
        ];
    }
}



         /*   
         Solo es compatible con version MySQL 5.7.33
         return Sale::select('sales.id', 'sales.consecutivo', 'products.name as producto', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at') 
            ->join('users as u', 'u.id', 'sales.user_id') 
            ->join('sale_details as sd', 'sales.id', 'sd.sale_id') 
            ->join('products', 'products.id', '=', 'sd.product_id') 
            ->join('meatcuts', 'meatcuts.id', '=', 'products.meatcut_id') 
            ->join('categories', 'categories.id', '=', 'products.category_id') 
            ->where('sales.tipo', '0') 
            ->where('sales.id', '>', '1602') 
            ->distinct('sales.id') // Filtrar ventas únicas por cada detalle de venta 
            ->groupBy('sales.id', 'products.name') // Agrupar por ID de venta y nombre de producto 
            ->get(); 
 */
        /*   // Reorganizar los datos para que cada fila represente un producto en una venta
        $formattedSales = collect();
        foreach ($sales as $sale) {
            $formattedSales->push([
                'ID' => $sale->id,
                'PRODUCTO' => $sale->producto,
                'TOTAL' => $sale->total,
                'ITEMS' => $sale->items,
                'STATUS' => $sale->status,
                'USUARIO' => $sale->user,
                'FECHA' => $sale->created_at
            ]);
        }

        return $formattedSales; */