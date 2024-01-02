<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\Centro_costo_product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class CentroCostoProdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     /*    $category = Category::whereIn('id', [1, 2, 3, 4])->orderBy('id', 'asc')->get(); */
        $category = Category::orderBy('name', 'asc')->get();
        $centros = Centrocosto::Where('status', 1)->get();
        $centroCostoProductos = Centro_costo_product::all();

        $newToken = Crypt::encrypt(csrf_token());

        return view("products.centro_costo_products", compact('category', 'centros', 'centroCostoProductos'));

        // return view('hola');
        //  return view('inventory.diary');
    }

    
   
    public function show(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');

        $data = DB::table('centro_costo_products as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'pro.id as productId',
                'pro.level_product_id as level_product_id',           
                'pro.cost as costo',
                'pro.price_fama as price_fama',
                'pro.status as status'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('pro.category_id', $categoriaId)
      /*       ->where('pro.status', 1) */
         /*    ->where('pro.level_product_id', 1) */
            ->get();

       // return response()->json(['data' => $data]);
       return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function updateCcpSwitch()
    {
        $productId = request('productId');      
        $price_fama = request('price_fama');
        $status = request('status');
    
        if (!is_null($price_fama)) {
            DB::table('products')
                ->where('id', $productId)                   
                ->update(['price_fama' => $price_fama]);
        }
    
        if (!is_null($status)) {
            DB::table('products')
                ->where('id', $productId)                   
                ->update(['status' => $status]);
        }
    
        return response()->json(['success' => true]);
    }
}
