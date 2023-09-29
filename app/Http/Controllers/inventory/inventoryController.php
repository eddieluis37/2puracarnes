<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use Illuminate\Support\Facades\DB;

class inventoryController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startDate = '2023-05-01';
        $endDate = '2023-05-08';

        $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get();

        $centros = Centrocosto::Where('status', 1)->get();

        // Obtener el stock desde el objeto request
        
        // $totalStock = request()->input('totalStock');
        $totalStock = request('totalStock');

        return view('inventory.consolidado', compact('category', 'centros', 'startDate', 'endDate', 'totalStock'));
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
        $data = DB::table('centro_costo_product_hists as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'ccp.invinicial as invinicial',
                'ccp.compralote as compraLote',
                'ccp.alistamiento',
                'ccp.compensados as compensados',
                'ccp.trasladoing as trasladoing',
                'ccp.trasladosal as trasladosal',
                'ccp.venta as venta',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('ccp.tipoinventario', 'inicial')
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        // Calculo de la stock ideal
        
        $totalStock = 0;

        foreach ($data as $item) {
            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta + $item->trasladosal);
            $item->stock = round($stock, 2);

            $totalStock += $stock;
        }

            // Pasar el valor de stock al objeto request
            $request->merge(['totalStock' => $totalStock]);
       

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
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
