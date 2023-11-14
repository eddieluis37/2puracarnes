<?php

namespace App\Exports;

use App\Models\Centro_costo_product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        //return Centro_costo_product::all();

        return Centro_costo_product::select('categories.name as category_name', 'centro_costo_products.id', 'meatcuts.name as meat_cut_name', 'products.name as producto','centro_costo_products.fisico')
            ->join('products', 'products.id', '=', 'centro_costo_products.products_id')
            ->join('meatcuts', 'meatcuts.id', '=', 'products.meatcut_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')

            ->get();
    }

    public function headings(): array
    {
        return [
            'CAT',
            'PROD-ID',
            'BASICO',
            'PRODUCTO',
            'S-FISICO'
        ];
    }
}
