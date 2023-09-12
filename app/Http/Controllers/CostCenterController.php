<?php

namespace App\Http\Controllers;

use App\Models\centros\Centrocosto;
//use App\Models\CostCenter;
 
 class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = Centrocosto::all();
        return response()->json($costCenters);
    }
}