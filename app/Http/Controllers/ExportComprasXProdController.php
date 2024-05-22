<?php

namespace App\Http\Controllers;

use App\Exports\ComprasXProdExport;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xls\RC4;

class ExportComprasXProdController extends Controller
{


    public function reporteExcel(Request $request)
    {
        $from = $request->input('startDateId');
        $to = $request->input('endDateId');

        /*

        $from = Carbon::parse($dateFrom)->format('Y-m-d');
        $to = Carbon::parse($dateTo)->format('Y-m-d'); */
        /* 
     */

        $from = '2024-04-01';
        $to = '2024-05-16';
        /* 
        $from = Carbon::parse($request->input('startDate'))->format('Y-m-d');
        $to = Carbon::parse($request->input('endDate'))->format('Y-m-d');  */

      //  dd($from, $to);
        $reportName = 'Reporte compras por productos_' . uniqid() . '.xlsx';

        return Excel::download(new ComprasXProdExport($from, $to), $reportName);
    }
}
