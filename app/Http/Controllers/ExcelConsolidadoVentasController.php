<?php

namespace App\Http\Controllers;

use App\Exports\ConsolidadoVentasExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelConsolidadoVentasController extends Controller
{
    public function downloadExcel()
    {
        $dateTime = now()->format('Y-m-d_H-i-s'); // Formato de fecha y hora actual
        $fileName = 'Consolidado_Ventas_' . $dateTime . '.xlsx'; // Nombre del archivo con fecha y hora
        return Excel::download(new ConsolidadoVentasExport, $fileName);
    }
}
