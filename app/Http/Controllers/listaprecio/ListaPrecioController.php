<?php

namespace App\Http\Controllers\listaprecio;

use App\Models\Listaprecio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\centros\Centrocosto;


class ListaPrecioController extends Controller
{

    public function index()
    {
        $listaprecios = Listaprecio::with('centrocosto')->get();
        $centros = Centrocosto::Where('status', 1)->get();

       // dd($listaprecios);

        return view('listadeprecio.index', compact('listaprecios', 'centros'));
    }

   
    public function create()
    {
    }

    
    public function store(Request $request)
    {
    }

   
    public function show(Listaprecio $listaprecio)
    {
        //
    }

    
    public function edit( $lpId)
    {
        $lp = Listaprecio::find($lpId);
        $centrocostos = Centrocosto::all();

        return request()->expectsJson()
            ? response()->json([
                'data' => $lp,
                'dataurl' => "/lista_de_precio/$lpId"
            ])
            : view('listadeprecio.modal_update', compact('lp', 'centrocostos'));
    }

    
    public function update(Request $request, $lpId)
    {
        $lp = Listaprecio::find($lpId);


        $lp->centrocosto_id = $request->centrocosto_id;
        $lp->nombre = $request->nombre;
        $lp->tipo = $request->tipo;

        $lp->save();

        return redirect()->back();
    }


    public function destroy(Listaprecio $listaprecio)
    {
        //
    }
}
