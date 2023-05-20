<?php

namespace App\Http\Controllers\compensado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Third;
use App\Models\centros\Centrocosto;
use App\Models\compensado\Compensadores;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
        try {

            $rules = [
                'categoria' => 'required',
                'provider' => 'required',
                'centrocosto' => 'required',
                'factura' => 'required',
            ];
            $messages = [
                'categoria.required' => 'La categoria es requerida',
                'provider.required' => 'El proveedor es requerido',
                'centrocosto.required' => 'El centro de costo es requerido',
                'factura.required' => 'La factura es requerida',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $id_user= Auth::user()->id;

            $comp = new Compensadores();
            $comp->users_id = $id_user;
            $comp->categoria_id = $request->categoria;
            $comp->thirds_id = $request->provider;
            $comp->centrocosto_id = $request->centrocosto;
            $comp->factura = $request->factura;
            $comp->save();

            return response()->json([
                'status' => 1,
            ]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
            $data = DB::table('compensadores as comp')
            ->join('categories as cat', 'comp.categoria_id', '=', 'cat.id')
            ->join('thirds as tird', 'comp.thirds_id', '=', 'tird.id')
            ->join('centro_costo as centro', 'comp.centrocosto_id', '=', 'centro.id')
            ->select('comp.*', 'cat.name as namecategoria', 'tird.name as namethird','centro.name as namecentrocosto')
            ->get();
            //$data = Compensadores::orderBy('id','desc');
            return Datatables::of($data)->addIndexColumn()
                /*->addColumn('status', function($data){
                    if ($data->estado == 1) {
                        $status = '<span class="badge bg-success">Activo</span>';
                    }else{
                        $status= '<span class="badge bg-danger">Inactivo</span>';
                    }
                    return $status;
                })*/
                ->addColumn('date', function($data){
                    $date = Carbon::parse($data->created_at);
                     $onlyDate = $date->toDateString();
                    return $onlyDate;
                })
                ->addColumn('action', function($data){
                    $btn = '
                    <div class="text-content">
					<a href="compensado/create/1" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Borrar Beneficio" >
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                    return $btn;
                })
                ->rawColumns(['date','action'])
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
