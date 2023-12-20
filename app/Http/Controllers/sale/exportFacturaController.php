<?php

namespace App\Http\Controllers\sale;

use App\Http\Controllers\Controller;
use App\Models\caja\Caja;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class exportFacturaController extends Controller
{
    public function showFactura($id)
    {
        $sale = Sale::findOrFail($id);

        $showFactura = PDF::loadView('sale.reporte', compact('sale'));

        return $showFactura->download('sale.pdf');
    }
}
