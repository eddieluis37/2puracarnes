<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;


class CuentasporcobrarController extends Controller
{
    public function downloadExcel()
    {
        return Excel::download(new ReportExport, 'REPORTE-CUENTAS-POR-COBRAR.xlsx');
    }
}
