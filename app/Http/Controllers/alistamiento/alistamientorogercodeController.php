<?php

namespace App\Http\Controllers\alistamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\centros\Centrocosto;
use App\Models\alistamiento\Alistamiento;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Products\Meatcut;

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
        $dataAlistamiento = DB::table('alistamiento as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto')
        ->where('ali.id', $id)
        ->get();

        $cortes = Meatcut::Where([
            ['category_id',$dataAlistamiento[0]->categoria_id],
            ['status',1]
        ])->get();

        return view('alistamiento.create', compact('dataAlistamiento','cortes'));
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
            ];
            $messages = [
                'alistamientoId.required' => 'El alistamiento es requerido',
                'categoria.required' => 'La categoria es requerida',
                'centrocosto.required' => 'El centro de costo es requerido',
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
                $alist->fecha_alistamiento= $currentDateFormat;
                $alist->fecha_cierre = $dateNextMonday;
                $alist->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
					"registroId" => $alist->id
                ]);
            }else{
                $getReg = Compensadores::firstWhere('id', $request->compensadoId);
                $getReg->categoria_id = $request->categoria;
                $getReg->thirds_id = $request->provider;
                $getReg->centrocosto_id = $request->centrocosto;
                $getReg->factura = $request->factura;
                $getReg->save();

                return response()->json([
                    'status' => 1,
                    'message' => 'Guardado correctamente',
					"registroId" => 0
                ]);
            }


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
        $data = DB::table('alistamiento as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        //->join('thirds as tird', 'comp.thirds_id', '=', 'tird.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto')
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
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="showDataForm('.$data->id.')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="editCompensado('.$data->id.');">
						<i class="fas fa-edit"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="downCompensado('.$data->id.');">
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }else{
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Borrar Beneficio" >
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" disabled>
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
            ['status',1]
        ])->get();
        return response()->json(['products' => $prod]);
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
