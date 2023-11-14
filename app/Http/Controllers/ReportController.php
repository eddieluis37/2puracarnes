<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
    public function downloadExcel()
    {
        return Excel::download(new ReportExport, 'REPORTE-STOCK-FISICO.xlsx');
    }
}
