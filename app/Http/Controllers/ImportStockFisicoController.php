<?php

namespace App\Http\Controllers;

use App\Imports\StockFisicoImportClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportStockFisicoController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new StockFisicoImportClass, $file);
       
        return redirect()->back()->with('success', __('File imported successfully.'));
    }
}
