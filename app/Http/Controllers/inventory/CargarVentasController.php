<?php

namespace App\Http\Controllers\inventory;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\Centro_costo_product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class CargarVentasController extends Controller
{
    public function index()
    {
        /* $category = Category::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('name', 'asc')->get(); */
        $category = Category::orderBy('name', 'asc')->get();
        $centros = Centrocosto::Where('status', 1)->get();
        $centroCostoProductos = Centro_costo_product::all();

        $newToken = Crypt::encrypt(csrf_token());

        return view("inventory.cargar_ventas", compact('category', 'centros', 'centroCostoProductos'));

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
                'ccp.venta as venta',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        // return response()->json(['data' => $data]);
        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function updateCVInv()
    {
        $productId = request('productId');
        $centrocostoId = request('centrocostoId');
        $venta = request('venta');

        DB::table('centro_costo_products')
            ->where('products_id', $productId)
            ->where('centrocosto_id', $centrocostoId)
            ->update(['venta' => $venta]);

        return response()->json(['success' => 'true']);
    }
}
