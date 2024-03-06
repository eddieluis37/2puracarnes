<?php

namespace App\Http\Controllers;

use App\Exports\AnalisisKGExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExcelAnalisisKGController extends Controller
{
    public function downloadExcel()
    {
        return Excel::download(new AnalisisKGExport, 'EXCEL-ANALISIS-KG.xlsx');
    }
}
