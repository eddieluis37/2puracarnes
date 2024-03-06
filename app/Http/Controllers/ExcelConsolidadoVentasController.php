<?php

namespace App\Http\Controllers;

use App\Exports\ConsolidadoVentasExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelConsolidadoVentasController extends Controller
{
    public function downloadExcel()
    {
        return Excel::download(new ConsolidadoVentasExport, 'CONSOLIDADO-VENTAS.xlsx');
    }
}
