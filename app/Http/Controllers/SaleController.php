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
        $ventas = Sale::get();
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $vendedores = Third::Where('vendedor', 1)->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();

        return view('sale.index',compact('centros','clientes','vendedores','domiciliarios','ventas'));
    }

    
    public function create()
    {
    
    }

    
    public function store(Request $request)
    {
        $venta = new Sale();
     
        $venta->fecha = $request->fecha;
        $venta->centrocosto_id = $request->centrocosto;
        $venta->third_id = $request->cliente;
        $venta->vendedor_id = $request->vendedor;
        $venta->domiciliario_id = $request->domiciliario;
        $venta->user_id = $request->user()->id;
        
        $venta->total = 0;
        $venta->items = 0;
        $venta->cash = 0;
        $venta->change = 0;
        $venta->status = 0;
        
        $venta->save();

        return redirect()->back();
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
    
    public function delete(Request $request, $ventaId)
    {
        $venta = Sale::find($ventaId);
        $venta->delete();
        return redirect()->back();
    }
}
