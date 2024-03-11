<?php

namespace App\Http\Controllers\aves;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Third;
use App\Models\Sacrificio;
use App\Models\Sacrificiopollo;
use App\Models\Beneficiopollo;
use NumberFormatter;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class beneficioavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thirds = Third::orderBy('name', 'asc')->get();
        $sacrificios = Sacrificiopollo::orderBy('name', 'asc')->get();
        return view('categorias.aves.beneficioaves.index', compact('thirds','sacrificios'));
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
        try {
            
		    $dateNow = Carbon::now();
		    // Get the year, month, and day
		    $year = $dateNow->year;
		    $month = $dateNow->month;
		    $day = $dateNow->day;
		    $newLote = "";
            $reg = Beneficiopollo::select()->first();
            if ($reg === null) {
                $newLote = "PO".$year.$month.$day."1";
            }else {
                $regUltimo = Beneficiopollo::select()->latest()->first()->toArray();
                $consecutivo = $regUltimo['id']+1;
                $newLote = "PO".$year.$month.$day.$consecutivo;
            }
            /***************************************************************/
            $costopie1 = str_replace('.', '', $request->get('costopie1'));
            $promedio_canal_fria_sala = str_replace('.', '', $request->get('promedio_canal_fria_sala'));

		    $getReg = Beneficiopollo::firstWhere('id', $request->idbeneficio);  
		    if($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
			    $current_date->modify('next monday'); // Move to the next Monday
			    $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
                /******************************************************/
		        $newBeneficiopollo = new Beneficiopollo();
		        $newBeneficiopollo->thirds_id = $request->thirds_id;
		        $newBeneficiopollo->plantasacrificio_id  = $request->plantasacrificio_id;
		        $newBeneficiopollo->cantidad = $request->cantidad;
		        $newBeneficiopollo->fecha_beneficio = $currentDateFormat;
		        $newBeneficiopollo->fecha_cierre = $dateNextMonday;
		        $newBeneficiopollo->factura = $request->factura;
		        $newBeneficiopollo->clientsubproductos_uno_id = $request->clientsubproductos_uno_id;
		        $newBeneficiopollo->clientsubproductos_dos_id = $request->clientsubproductos_dos_id;
		        $newBeneficiopollo->lote = $newLote;
		        $newBeneficiopollo->sacrificio = $request->sacrificio;
		        $newBeneficiopollo->valor_kg_pollo = $request->valor_kg_pollo;
		        $newBeneficiopollo->total_factura = $request->total_factura;

		        $newBeneficiopollo->promedio_pie_kg = $request->promedio_pie_kg;
		        $newBeneficiopollo->mollejas_corazones_kg = $request->mollejas_corazones_kg;
		        $newBeneficiopollo->promedio_canal_fria_sala = $promedio_canal_fria_sala;
		        $newBeneficiopollo->peso_canales_pollo_planta = $request->peso_canales_pollo_planta;

		        $newBeneficiopollo->menudencia_pollo_kg = $request->menudencia_pollo_kg;
                $newBeneficiopollo->mollejas_corazones_kg = $request->mollejas_corazones_kg;
		        $newBeneficiopollo->subtotal = $request->subtotal;
		        $newBeneficiopollo->promedio_canal_kg = $request->promedio_canal_kg;


		        $newBeneficiopollo->menudencia_pollo_porc = $request->menudencia_pollo_porc;
		        $newBeneficiopollo->mollejas_corazones_porc = $request->mollejas_corazones_porc;
		        $newBeneficiopollo->despojos_mermas = $request->despojos_mermas;
		        $newBeneficiopollo->porc_pollo = $request->porc_pollo;
		        
		        $newBeneficiopollo->save();

            	return response()->json([
                	"status" => 1,
                	"message" => "Guardado correctamente",
					"registroId" => $newBeneficiopollo->id
            	]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "message" => (array) $th
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
        $data = DB::table('beneficiopollos as be')
        ->join('thirds as tird', 'be.thirds_id', '=', 'tird.id')
        ->select('be.*', 'tird.name as namethird')
		->where('be.status', '=', true)
		->orderBy('be.id', 'desc')
        ->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('date', function($data){
                $date = Carbon::parse($data->fecha_beneficio);
                    $onlyDate = $date->toDateString();
                return $onlyDate;
            })
            ->addColumn('action', function($data){
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="desposteaves/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Editar Beneficio" onclick="showDataForm('.$data->id.')">
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
					<a href="desposteaves/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Editar Beneficio" onclick="edit('.$data->id.');">
						<i class="fas fa-edit"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="Confirm('.$data->id.');">
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }else{
                    $btn = '
                    <div class="text-center">
					<a href="desposteaves/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Editar Beneficio" onclick="showDataForm('.$data->id.')">
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $benefi = Beneficiopollo::where('id', $id)->first();
		return response()->json([
			"id" => $id,
			"beneficioaves" => $benefi,
		]);
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

    public function get_plantasacrificiopollo_by_id(Request $request)
    {
		if ($request->ajax()) {
			$data1 = Sacrificiopollo::where('id', $request->plantasacrificio_id)
			->firstOrFail();

			return response()->json(
				[
					'sacrificio' => $data1->sacrificio,
					'fomento' => $data1->fomento,
					'deguello' => $data1->deguello,
					'bascula' => $data1->bascula,
					'transporte' => $data1->transporte,
				]
			);			
		}
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
