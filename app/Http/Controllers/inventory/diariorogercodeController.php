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

class diariorogercodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::WhereIn('id', [1, 2, 3])->get();
        $costcenter = Centrocosto::Where('status', 1)->get();
        $centros = Centrocosto::Where('status', 1)->get();
        $centroCostoProductos = Centro_costo_product::all();

        return view("inventory.diario", compact('category', 'costcenter', 'centros', 'centroCostoProductos'));


        // return view('inventory.diario');
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
        $centrocosto_id = $request->input('centrocosto');

      //  $centrocostoId = $request->input('centrocostoId');
           $centrocostoId = 1;

        //  var_dump($centrocostoId);
       

        //   $categoriaId = $request->input('categoriaId');
        $categoriaId = 1;
        //    var_dump($categoriaId);
        // print_r($categoriaId);


        $data = DB::table('products as pro')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->join('centro_costo_products as ccp', 'pro.id', '=', 'ccp.id')
            ->select('cat.name as namecategoria', 'pro.name as nameproducto', 'ccp.fisico as namefisico')
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where('pro.category_id', $categoriaId)
            ->get();

        //     return response()->json($data);

     //   print_r($centrocostoId);

        $getCostoKiloPadre = DB::table('desposteres')
            ->join('products as p', 'desposteres.products_id', '=', 'p.id')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.name', 'desposteres.costo_kilo', 'desposteres.peso')
            ->where([
                ['desposteres.status', 'VALID'],
                ['p.status', 1],
            ])
            ->get();

        $getCostoKiloHijo = DB::table('workshop_details')
            ->join('products as p', 'workshop_details.products_id', '=', 'p.id')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->select('p.name', 'workshop_details.costo_kilo')
            ->where([
                ['workshop_details.status', 'VALID'],
                ['p.status', 1],
            ])
            ->get();

        $getCompensados = DB::table('compensadores_details as comdet')
            ->join('products as p', 'comdet.products_id', '=', 'p.id')
            ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
            ->join('centro_costo as cc', 'ce.centrocosto_id', '=', 'cc.id')
            ->join('compensadores as comp', 'comdet.compensadores_id', '=', 'comp.id')
            ->select('p.name', 'cc.name', 'comp.centrocosto_id', DB::raw('SUM(comdet.peso) as total_weight'))
            ->where([
                ['comp.status', 'VALID'],
                ['p.status', 1],
                ['cc.id', 1],
            ])
            ->groupBy('p.name', 'cc.name', 'comp.centrocosto_id')
            ->get();

        return Datatables::of($data)
            ->addColumn('costo_kilo', function ($row) use ($getCostoKiloPadre, $getCostoKiloHijo) {
                $costo_kilo = '';
                foreach ($getCostoKiloPadre as $item) {
                    if ($item->name == $row->nameproducto) {
                        $costo_kilo = $item->costo_kilo;
                        break;
                    }
                }
                if (empty($costo_kilo)) {
                    foreach ($getCostoKiloHijo as $item) {
                        if ($item->name == $row->nameproducto) {
                            $costo_kilo = $item->costo_kilo;
                            break;
                        }
                    }
                }
                return $costo_kilo;
            })
            ->addColumn('total_inv_ini', function ($row) use ($getCostoKiloPadre, $getCostoKiloHijo) {
                $costo_kilo = '';
                foreach ($getCostoKiloPadre as $item) {
                    if ($item->name == $row->nameproducto) {
                        $costo_kilo = $item->costo_kilo;
                        break;
                    }
                }
                if (empty($costo_kilo)) {
                    foreach ($getCostoKiloHijo as $item) {
                        if ($item->name == $row->nameproducto) {
                            $costo_kilo = $item->costo_kilo;
                            break;
                        }
                    }
                }
                return $row->namefisico * $item->costo_kilo;
            })
            ->addColumn('compraLote', function ($row) use ($getCostoKiloPadre) {
                $compraLote = 0;
                foreach ($getCostoKiloPadre as $item) {
                    if ($item->name == $row->nameproducto) {
                        $compraLote += $item->peso;
                    }
                }
                return $compraLote;
            })
            ->addColumn('costo_uni_lote', function ($row) use ($getCostoKiloPadre, $getCostoKiloHijo) {
                $costo_kilo = '';
                foreach ($getCostoKiloPadre as $item) {
                    if ($item->name == $row->nameproducto) {
                        $costo_kilo = $item->costo_kilo;
                        break;
                    }
                }
                if (empty($costo_kilo)) {
                    foreach ($getCostoKiloHijo as $item) {
                        if ($item->name == $row->nameproducto) {
                            $costo_kilo = $item->costo_kilo;
                            break;
                        }
                    }
                }
                return $costo_kilo;
            })
            ->addColumn('total_weight', function ($row) use ($getCompensados) {
                $total_weight = '';
                foreach ($getCompensados as $item) {
                    if ($item->name == $row->nameproducto) {
                        $total_weight = $item->total_weight;
                        break;
                    }
                }
                return $total_weight;
            })
            ->addIndexColumn()
            //   ->rawColumns(['date'])
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
