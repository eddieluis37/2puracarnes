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
        return Sale::select('sales.id', DB::raw('MAX(sales.consecutivo) as consecutivo'), 'products.name as producto', DB::raw('MAX(sales.total) as total'), DB::raw('MAX(sales.items) as items'), DB::raw('MAX(sales.status) as status'), DB::raw('MAX(u.name) as user'), DB::raw('MAX(sales.created_at) as created_at'))
            ->join('users as u', 'u.id', 'sales.user_id')
            ->join('sale_details as sd', 'sales.id', 'sd.sale_id')
            ->join('products', 'products.id', '=', 'sd.product_id')
            ->join('meatcuts', 'meatcuts.id', '=', 'products.meatcut_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('sales.tipo', '0')
            ->where('sales.id', '>', '1602')
            ->groupBy('sales.id', 'products.name') // Include products.name in the GROUP BY clause
            ->get();

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
    }

    public function headings(): array
    {
        return [
            'ID',
            'CONSECUTIVO',
            'PRODUCTO',
            'TOTAL',
            'ITEMS',
            'STATUS',
            'USUARIO',
            'FECHA'
        ];
    }
}
