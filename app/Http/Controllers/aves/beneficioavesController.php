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
		        $newBeneficiopollo->clientpieles_id = $request->clientpieles_id;
		        $newBeneficiopollo->clientvisceras_id = $request->clientvisceras_id;
		        $newBeneficiopollo->lote = $newLote;
		        $newBeneficiopollo->sacrificio = $request->sacrificio;
		        $newBeneficiopollo->fomento = $request->fomento;
		        $newBeneficiopollo->deguello = $request->deguello;
		        $newBeneficiopollo->bascula = $request->bascula;
		        $newBeneficiopollo->transporte = $request->transporte;
		        $newBeneficiopollo->pesopie1 = $request->pesopie1;
		        $newBeneficiopollo->pesopie2 = $request->pesopie2;
		        $newBeneficiopollo->pesopie3 = $request->pesopie3;
		        $newBeneficiopollo->costoanimal1 = $request->costoanimal1;
		        $newBeneficiopollo->costoanimal2 = $request->costoanimal2;
		        $newBeneficiopollo->costoanimal3 = $request->costoanimal3;
		        $newBeneficiopollo->canalcaliente = $request->canalcaliente;
		        $newBeneficiopollo->canalfria = $request->canalfria;
		        $newBeneficiopollo->canalplanta = $request->canalplanta;
		        $newBeneficiopollo->pieleskg = $request->pieleskg;
		        $newBeneficiopollo->pielescosto = $request->pielescosto;
		        $newBeneficiopollo->visceras = $request->visceras;
		        $newBeneficiopollo->costopie1 = $costopie1;
		        $newBeneficiopollo->costopie2 = $request->costopie2;
		        $newBeneficiopollo->costopie3 = $request->costopie3;
		        $newBeneficiopollo->tsacrificio = $request->tsacrificio;
		        $newBeneficiopollo->tfomento = 0;//$request->tfomento;
		        $newBeneficiopollo->tdeguello = 0;//$request->tdeguello;
		        $newBeneficiopollo->tbascula = 0; //$request->tbascula;
		        $newBeneficiopollo->ttransporte = 0;//$request->ttransporte;
		        $newBeneficiopollo->tpieles = $request->tpieles;
		        $newBeneficiopollo->tvisceras = $request->tvisceras;
		        $newBeneficiopollo->tcanalfria = $request->tcanalfria;
		        $newBeneficiopollo->valorfactura = 0;//$request->valorfactura;
		        $newBeneficiopollo->costokilo = 0;//$request->costokilo;
		        $newBeneficiopollo->costo = 0;//$request->costo;
		        $newBeneficiopollo->totalcostos = 0;//$request->totalcostos;
		        $newBeneficiopollo->pesopie = $request->pesopie;
		        $newBeneficiopollo->rtcanalcaliente = 0;//$request->rtcanalcaliente;
		        $newBeneficiopollo->rtcanalplanta = 0;//$request->rtcanalplanta;
		        $newBeneficiopollo->rtcanalfria = $request->rtcanalfria;
		        $newBeneficiopollo->rendcaliente = $request->rendcaliente;
		        $newBeneficiopollo->rendplanta = $request->rendplanta;
		        $newBeneficiopollo->rendfrio = $request->rendfrio;
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
