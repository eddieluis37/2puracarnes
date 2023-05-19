<?php

namespace App\Http\Controllers\compensado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Third;
use App\Models\centros\Centrocosto;

class compensadorogercodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::WhereIn('id',[1,2,3])->get();
        $providers = Third::Where('status',1)->get();
        $centros = Centrocosto::Where('status',1)->get();

        return view('compensado.res.index', compact('category','providers','centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $category = Category::WhereIn('id',[1,2,3])->get();
        $providers = Third::Where('status',1)->get();
        $centros = Centrocosto::Where('status',1)->get();

        return view('compensado.create', compact('category','providers','centros'));
    }

    public function getproducts(Request $request)
    {
        $prod = Product::Where([
            ['category_id',$request->categoriaId],
            ['status',1]
        ])->get();
        return response()->json(['products' => $prod]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json([
            'products' => 'success',
            'provider' => $request->provider, 
            'categoria' => $request->categoria, 
            'centrocosto' => $request->centrocosto, 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
