<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\Centro_costo_product;
use App\Models\Listaprecio;
use App\Models\Listapreciodetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AsignarPreciosProdController extends Controller
{
    public function index()
    {
        $category = Category::whereIn('id', [1, 2, 3, 4])->orderBy('id', 'asc')->get();
        /* $category = Category::orderBy('name', 'asc')->get(); */
        $centros = Centrocosto::Where('status', 1)->get();
        $listaPrecioDetalles = Listapreciodetalle::all();
        $listaPrecio = Listaprecio::all();


        $newToken = Crypt::encrypt(csrf_token());

        return view("asignarPreciosProd.asignar_precios_prod", compact('category', 'centros', 'listaPrecioDetalles', 'listaPrecio'));

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
                'pro.id as productId' ,             
                'pro.price_fama as price_fama',
                'pro.status as status'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('pro.category_id', $categoriaId)
      /*       ->where('pro.status', 1) */
            ->where('pro.level_product_id', 1)
            ->get();

       // return response()->json(['data' => $data]);
       return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
