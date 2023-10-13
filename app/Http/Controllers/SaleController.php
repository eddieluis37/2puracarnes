<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Third;
use App\Models\centros\Centrocosto;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    
    public function index()
    {
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $vendedores = Third::Where('vendedor', 1)->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();

        return view('sale.index',compact('centros','clientes','vendedores','domiciliarios'));
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
