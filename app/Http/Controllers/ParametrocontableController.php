<?php

namespace App\Http\Controllers;

use App\Models\Parametrocontable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ParametrocontableController extends Controller
{
    
    public function index()
    {
        $parametrocontables = Parametrocontable::get();      
        
        return view('parametrocontable.index',compact('parametrocontables'));
    }

    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $pc = new Parametrocontable();
     
        $pc->codigo = $request->codigo;
        $pc->nombre = $request->nombre;
        $pc->tipoparametro = $request->tipoparametro;
        $pc->cuenta = $request->cuenta;

        $validated = $request->validate([
            'codigo' => 'unique:parametrocontables',   
        ], $messages = [
            'unique' => 'El :attribute ya existe',
        ]);


        $pc->save();

        return redirect()->back();
    }

    
    public function show(Parametrocontable $parametrocontable)
    {
        //
    }

   
    public function edit($pcId)
    {
        $pc = Parametrocontable::find($pcId);
        return response()->json([
            'data' => $pc,
            'dataurl' => "/parametrocontable/$pcId"
          ]);
    }

  
    public function update(Request $request, $pcId)
    {
        $pc = ParametroContable::find($pcId);

        $pc->codigo = $request->codigo;
        $pc->nombre = $request->nombre;
        $pc->tipoparametro = $request->tipoparametro;
        $pc->cuenta = $request->cuenta;

        
        $pc->save();

       return redirect()->back();
    }

    
    public function delete(Request $request, $pcId)
    {
        $pc = ParametroContable::find($pcId);
        $pc->delete();
        return redirect()->back();
    }
}
