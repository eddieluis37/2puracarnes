<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    
    public function index()
    {
        $ventas = Sale::get();              
        return view('sale.index',compact('ventas'));
    }

    
    public function create()
    {
    
    }

    
    public function store(Request $request)
    {
     
    }

    
    public function show(Pago $pago)
    {
    
    }

    
    public function edit(Pago $pago)
    {
    
    }

    
    public function update(Request $request, Pago $pago)
    {
    
    }
    
    public function destroy(Pago $pago)
    {
        //
    }
}
