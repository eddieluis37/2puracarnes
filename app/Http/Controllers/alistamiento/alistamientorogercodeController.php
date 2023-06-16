<?php

namespace App\Http\Controllers\alistamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\centros\Centrocosto;
use App\Models\alistamiento\Alistamiento;
use App\Models\alistamiento\enlistment_details;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Products\Meatcut;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;

class alistamientorogercodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $category = Category::WhereIn('id',[1,2,3])->get();
        $centros = Centrocosto::Where('status',1)->get();
        return view("alistamiento.index",compact('category','centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //dd($id);
        $dataAlistamiento = DB::table('enlistments as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto')
        ->where('ali.id', $id)
        ->get();

        //$cortes = Meatcut::Where([
            //['category_id',$dataAlistamiento[0]->categoria_id],
            //['status',1]
        //])->get();
         
        $cortes = DB::table('meatcuts as me')
        ->join('products as pro', 'me.id', '=', 'pro.meatcut_id')
        ->select('me.*', 'pro.stock')
        ->where([
            ['pro.level_product_id',1],
            ['me.id',$dataAlistamiento[0]->meatcut_id],
            ['pro.category_id',$dataAlistamiento[0]->categoria_id],
            ['pro.status',1]
        ])
        ->get();

        $enlistments = $this->getalistamientodetail($id);

        $arrayTotales = $this->sumTotales($id);

        $newStock = $arrayTotales['kgTotalRequeridos'] - $cortes[0]->stock;

        return view('alistamiento.create', compact('dataAlistamiento','cortes','enlistments','arrayTotales','newStock'));
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
                'alistamientoId' => 'required',
                'categoria' => 'required',
                'centrocosto' => 'required',
                'selectCortePadre' => 'required',
            ];
            $messages = [
                'alistamientoId.required' => 'El alistamiento es requerido',
                'categoria.required' => 'La categoria es requerida',
                'centrocosto.required' => 'El centro de costo es requerido',
                'selectCortePadre.required' => 'El corte padre es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $getReg = Alistamiento::firstWhere('id', $request->compensadoId);

            if($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
			    $current_date->modify('next monday'); // Move to the next Monday
			    $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format

                $id_user= Auth::user()->id;

                $alist = new Alistamiento();
                $alist->users_id = $id_user;
                $alist->categoria_id = $request->categoria;
                $alist->centrocosto_id = $request->centrocosto;
                $alist->meatcut_id = $request->selectCortePadre;
                $alist->fecha_alistamiento= $currentDateFormat;
                $alist->fecha_cierre = $dateNextMonday;
                $alist->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
					"registroId" => $alist->id
                ]);
            }    
            //}else{
                //$getReg = Compensadores::firstWhere('id', $request->compensadoId);
                //$getReg->categoria_id = $request->categoria;
                //$getReg->thirds_id = $request->provider;
                //$getReg->centrocosto_id = $request->centrocosto;
                //$getReg->factura = $request->factura;
                //$getReg->save();

                //return response()->json([
                    //'status' => 1,
                    //'message' => 'Guardado correctamente',
					//"registroId" => 0
                //]);
            //}


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
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
        $data = DB::table('enlistments as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('meatcuts as cut', 'ali.meatcut_id', '=', 'cut.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto', 'cut.name as namecut')
        ->where('ali.status', 1)
        ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('date', function($data){
                $date = Carbon::parse($data->fecha_alistamiento);
                    $onlyDate = $date->toDateString();
                return $onlyDate;
            })
            ->addColumn('action', function($data){
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm('.$data->id.')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="downAlistamiento('.$data->id.');">
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }else{
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm('.$data->id.')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }
                return $btn;
            })
            ->rawColumns(['date','action'])
            ->make(true);
    }

    public function getproducts(Request $request)
    {
        $prod = Product::Where([
            ['meatcut_id',$request->categoriaId],
            ['status',1],
            ['level_product_id',2]
        ])->get();
        return response()->json(['products' => $prod]);
    }

    public function savedetail(Request $request)
    {
        try {

            $rules = [
                'kgrequeridos' => 'required',
                'producto' => 'required',
            ];
            $messages = [
                'kgrequeridos.required' => 'Los kg requeridos son necesarios',
                'producto.required' => 'El producto es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors()
                ], 422);
            }

            $formatCantidad = new metodosrogercodeController();
            $prod = Product::firstWhere('id', $request->producto);
            $formatkgrequeridos = $formatCantidad->MoneyToNumber($request->kgrequeridos);
            $newStock = $prod->stock + $formatkgrequeridos;
            $details = new enlistment_details();
            $details->enlistments_id = $request->alistamientoId;
            $details->products_id = $request->producto;
            $details->kgrequeridos = $formatkgrequeridos;
            $details->newstock = $newStock;
            $details->save();

            $arraydetail = $this->getalistamientodetail($request->alistamientoId);
            $arrayTotales = $this->sumTotales($request->alistamientoId);

            return response()->json([
                'status' => 1,
                'message' => "Agregado correctamente",
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getalistamientodetail($alistamientoId)
    {

        $detail = DB::table('enlistment_details as en')
        ->join('products as pro', 'en.products_id', '=', 'pro.id')
        ->select('en.*', 'pro.name as nameprod','pro.code','pro.stock')
        ->where([
            ['en.enlistments_id',$alistamientoId],
            ['en.status',1]
        ])->get();

        return $detail;
    }

    public function sumTotales($id)
    {

        $kgTotalRequeridos = (float)enlistment_details::Where([['enlistments_id',$id],['status',1]])->sum('kgrequeridos');
        $newTotalStock = (float)enlistment_details::Where([['enlistments_id',$id],['status',1]])->sum('newstock');

        $array = [
            'kgTotalRequeridos' => $kgTotalRequeridos,
            'newTotalStock' => $newTotalStock,
        ];

        return $array;
    }

    public function updatedetail(Request $request)
    {   
        try {

            $prod = Product::firstWhere('id', $request->productoId);
            $newStock = $prod->stock + $request->newkgrequeridos;

            $updatedetails = enlistment_details::firstWhere('id', $request->id);
            $updatedetails->kgrequeridos = $request->newkgrequeridos;
            $updatedetails->newstock = $newStock;
            $updatedetails->save();

            $arraydetail = $this->getalistamientodetail($request->alistamientoId);
            $arrayTotales = $this->sumTotales($request->alistamientoId);

            return response()->json([
                'status' => 1,
                'message' => 'Guardado correctamente',
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }

    }

    public function editAlistamiento(Request $request)
    {
        $reg = Alistamiento::where('id', $request->id)->first();
        return response()->json([
            'status' => 1,
            'reg' => $reg
        ]);
    }

    public function getProductsCategoryPadre(Request $request){
        $cortes = Meatcut::Where([
            ['category_id',$request->categoriaId],
            ['status',1]
        ])->get();
        return response()->json(['products' => $cortes]);
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
    public function destroy(Request $request)
    {
        try {
            $enlist = enlistment_details::where('id', $request->id)->first();
            $enlist->status = 0;
            $enlist->save();

            $arraydetail = $this->getalistamientodetail($request->alistamientoId);
            $arrayTotales = $this->sumTotales($request->alistamientoId);

            return response()->json([
                'status' => 1,
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }

    public function destroyAlistamiento(Request $request)
    {
        try {
            $alist = Alistamiento::where('id', $request->id)->first();
            $alist->status = 0;
            $alist->save();

            return response()->json([
                'status' => 1,
                'message' => 'Se realizo con exito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }
}
