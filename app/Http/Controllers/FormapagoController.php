<?php

namespace App\Http\Controllers;

use App\Models\Formapago;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class FormapagoController extends Controller
{
    
    public function index()
    {
        $formapagos = Formapago::get();      
        
        return view('formapago.index',compact('formapagos'));
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
         $fp = new FormaPago();
     
        $fp->codigo = $request->codigo;
        $fp->nombre = $request->nombre;
        $fp->tipoformapago = $request->tipoformapago;
        $fp->cuenta = $request->cuenta;

        $validated = $request->validate([
            'codigo' => 'unique:formapagos',   
        ], $messages = [
            'unique' => 'El :attribute ya existe',
        ]);


        $fp->save();

        return redirect()->back();
    }

    
    public function show(Formapago $formapago)
    {
        //
    }

  
    public function edit( $fpId)
    {
        $fp = Formapago::find($fpId);
        return response()->json([
            'data' => $fp,
            'dataurl' => "/formapago/$fpId"
          ]);
    }

   
    public function update(Request $request, $fpId)
    {
        $fp = Formapago::find($fpId);

        $fp->codigo = $request->codigo;
        $fp->nombre = $request->nombre;
        $fp->tipoformapago = $request->tipoformapago;
        $fp->cuenta = $request->cuenta;

        
        $fp->save();

       return redirect()->back();
    }


   
    public function delete(Request $request, $fpId)
    {
        $fp = Formapago::find($fpId);
        $fp->delete();
        return redirect()->back();
    }
}
