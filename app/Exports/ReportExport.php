<?php

namespace App\Exports;

use App\Models\Centro_costo_product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Centro_costo_product::all();
    }

    public function headings(): array
    {
        return [
            'Columna 1',
            'Columna 2',
            // Agrega más columnas según tus necesidades
        ];
    }
}
