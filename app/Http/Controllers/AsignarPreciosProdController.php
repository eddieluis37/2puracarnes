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

        $data = DB::table('listapreciodetalles as lpd')
            ->join('listaprecios as lp', 'lp.id', '=', 'lpd.listaprecio_id')
            ->join('products as pro', 'pro.id', '=', 'lpd.product_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'pro.id as productId',
                'lpd.costo as costo',
                'lpd.porc_util_proyectada as porc_util_proyectada',
                'lpd.precio_proyectado as precio_proyectado',
                'lpd.precio as price',
                'lpd.porc_iva as porc_iva',
                'lpd.utilidad as utilidad',
                'lpd.porc_utilidad as porc_utilidad',                
                'lpd.status as status',                
            )
            ->where('lp.centrocosto_id', $centrocostoId)
            ->where('pro.category_id', $categoriaId)
            /*       ->where('pro.status', 1) */
          /*   ->where('pro.level_product_id', 1) */
            ->get();

        // return response()->json(['data' => $data]);
        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
