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
        /* $category = Category::whereIn('id', [1, 2, 3, 4])->orderBy('id', 'asc')->get(); */
        $category = Category::orderBy('name', 'asc')->get();
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
        $listaprecioId = $request->input('listaprecioId');
        $categoriaId = $request->input('categoriaId');

        $data = DB::table('listapreciodetalles as lpd')
            ->join('listaprecios as lp', 'lp.id', '=', 'lpd.listaprecio_id')
            ->join('products as pro', 'pro.id', '=', 'lpd.product_id')           
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'pro.id as productId',
                'pro.cost as costo',
                'lpd.porc_util_proyectada as porc_util_proyectada',
                'lpd.precio_proyectado as precio_proyectado',
                'lpd.precio as precio',
                'lpd.porc_iva as porc_iva',
                'lpd.utilidad as utilidad',
                'lpd.porc_utilidad as porc_utilidad',
                'lpd.status as status',
            )
            ->where('lpd.listaprecio_id', $listaprecioId)
            ->where('pro.category_id', $categoriaId)           
            /*       ->where('pro.status', 1)
          /*   ->where('pro.level_product_id', 1) */
            ->get();

        // return response()->json(['data' => $data]);
        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function updateAPPSwitch()
    {
        $listaprecioId = request('listaprecioId');
        $productId = request('productId');
        $precio = request('precio');
        $status = request('status');

        if (!is_null($precio)) {
            DB::table('listapreciodetalles')
                ->where('listaprecio_id', $listaprecioId)
                ->where('product_id', $productId)
                ->update(['precio' => $precio]);
        }

        if (!is_null($status)) {
            DB::table('listapreciodetalles')
                ->where('listaprecio_id', $listaprecioId)
                ->where('product_id', $productId)
                ->update(['status' => $status]);
        }

        return response()->json(['success' => true]);
    }
}
