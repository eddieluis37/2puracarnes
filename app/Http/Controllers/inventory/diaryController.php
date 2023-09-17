<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\Centro_costo_product;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class diaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::WhereIn('id', [1, 2, 3, 4, 5, 6, 7])->get();
        $costcenter = Centrocosto::Where('status', 1)->get();
        $centros = Centrocosto::Where('status', 1)->get();
        $centroCostoProductos = Centro_costo_product::all();

        return view("inventory.diary", compact('category', 'costcenter', 'centros', 'centroCostoProductos'));

        // return view('hola');
        //  return view('inventory.diary');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');
        $data = DB::table('centro_costo_products as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select('cat.name as namecategoria', 'pro.name as nameproducto', 'ccp.fisico as namefisico'
            , 'ccp.compralote as compraLote', 'ccp.alistamiento', 'ccp.compensados as compensados', 'ccp.trasladoing as trasladoing'
            , 'ccp.trasladosal as trasladosal', 'ccp.venta as venta', 'ccp.stock as stock', 'ccp.fisico as fisico')
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('ccp.tipoinventario', 'inicial')
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
           ->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

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
