<?php

namespace App\Http\Controllers\pollo;

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

class beneficiopolloController extends Controller
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
        return view('categorias.aves.beneficioaves.index', compact('thirds', 'sacrificios'));
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


    public function MoneyToNumber(string $moneyValue): float
    {
        $formatter = new NumberFormatter('es-CL', NumberFormatter::DECIMAL);
        $number = $formatter->parse($moneyValue);
        return (float) $number;
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
                $newLote = "PO" . $year . $month . $day . "1";
            } else {
                $regUltimo = Beneficiopollo::select()->latest()->first()->toArray();
                $consecutivo = $regUltimo['id'] + 1;
                $newLote = "PO" . $year . $month . $day . $consecutivo;
            }
            /***************************************************************/
            $costopie1 = str_replace('.', '', $request->get('costopie1'));


            /*            $valor_kg_pollo = $request->input('valor_kg_pollo');
            $valor_kg_pollo = str_replace(['.', ',', '$', '#'], '', $valor_kg_pollo);

            /* $promedio_canal_fria_sala = str_replace('.', '', $request->get('promedio_canal_fria_sala')); 

            $promedio_canal_fria_sala = str_replace(',', '.', $request->get('promedio_canal_fria_sala'));
            $subtotal = str_replace(',', '.', $request->get('subtotal'));
            $despojos_mermas = str_replace(',', '.', $request->get('despojos_mermas')); */



            $getReg = Beneficiopollo::firstWhere('id', $request->idbeneficio);
            if ($getReg == null) {
                $currentDateTime = Carbon::now();
                $currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
                $current_date->modify('next monday'); // Move to the next Monday
                $dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
                /******************************************************/
                $newBeneficiopollo = new Beneficiopollo();
                $newBeneficiopollo->centrocosto_id = 1;
                $newBeneficiopollo->thirds_id = $request->thirds_id;
                $newBeneficiopollo->plantasacrificio_id  = $request->plantasacrificio_id;
                $newBeneficiopollo->cantidad = $request->cantidad;
                $newBeneficiopollo->fecha_beneficio = $currentDateFormat;
                $newBeneficiopollo->fecha_cierre = $dateNextMonday;
                $newBeneficiopollo->factura = $request->factura;
                $newBeneficiopollo->clientsubproductos_uno_id = $request->clientsubproductos_uno_id;
                $newBeneficiopollo->clientsubproductos_dos_id = $request->clientsubproductos_dos_id;
                $newBeneficiopollo->lote = $newLote;
                $newBeneficiopollo->sacrificio = $this->MoneyToNumber($request->sacrificio);
                $newBeneficiopollo->valor_kg_pollo = $this->MoneyToNumber($request->valor_kg_pollo);
                $newBeneficiopollo->total_factura = $this->MoneyToNumber($request->total_factura);

                $newBeneficiopollo->promedio_pie_kg = $this->MoneyToNumber($request->promedio_pie_kg);
                $newBeneficiopollo->peso_pie_planta = $this->MoneyToNumber($request->peso_pie_planta);
                $newBeneficiopollo->promedio_canal_fria_sala = $this->MoneyToNumber($request->promedio_canal_fria_sala);                              
                $newBeneficiopollo->peso_canales_pollo_planta = $this->MoneyToNumber($request->peso_canales_pollo_planta);

                $newBeneficiopollo->menudencia_pollo_kg = $this->MoneyToNumber($request->menudencia_pollo_kg);
                $newBeneficiopollo->mollejas_corazones_kg = $this->MoneyToNumber($request->mollejas_corazones_kg);
                $newBeneficiopollo->subtotal = $this->MoneyToNumber($request->subtotal);
                $newBeneficiopollo->promedio_canal_kg = $this->MoneyToNumber($request->promedio_canal_kg);


                $newBeneficiopollo->menudencia_pollo_porc = $this->MoneyToNumber($request->menudencia_pollo_porc);
                $newBeneficiopollo->mollejas_corazones_porc = $this->MoneyToNumber($request->mollejas_corazones_porc);
                $newBeneficiopollo->despojos_mermas = $this->MoneyToNumber($request->despojos_mermas);
                $newBeneficiopollo->porc_pollo = $this->MoneyToNumber($request->porc_pollo);

                $newBeneficiopollo->save();

                return response()->json([
                    "status" => 1,
                    "message" => "Guardado correctamente",
                    "registroId" => $newBeneficiopollo->id
                ]);
            } else {

                $updateBeneficiopollo = Beneficiopollo::firstWhere('id', $request->idbeneficio);
               
                $updateBeneficiopollo->thirds_id = $request->thirds_id;
                $updateBeneficiopollo->plantasacrificio_id  = $request->plantasacrificio_id;
          
                $updateBeneficiopollo->cantidad = $request->cantidad;            
                $updateBeneficiopollo->factura = $request->factura;
                $updateBeneficiopollo->clientsubproductos_uno_id = $request->clientsubproductos_uno_id;
                $updateBeneficiopollo->clientsubproductos_dos_id = $request->clientsubproductos_dos_id;
                $updateBeneficiopollo->lote = $newLote;
                $updateBeneficiopollo->sacrificio = $this->MoneyToNumber($request->sacrificio);
                $updateBeneficiopollo->valor_kg_pollo = $this->MoneyToNumber($request->valor_kg_pollo);
                $updateBeneficiopollo->total_factura = $this->MoneyToNumber($request->total_factura);

                $updateBeneficiopollo->promedio_pie_kg = $this->MoneyToNumber($request->promedio_pie_kg);
                $updateBeneficiopollo->peso_pie_planta = $this->MoneyToNumber($request->peso_pie_planta);                
                $updateBeneficiopollo->promedio_canal_fria_sala = $this->MoneyToNumber($request->promedio_canal_fria_sala);
                $updateBeneficiopollo->peso_canales_pollo_planta = $this->MoneyToNumber($request->peso_canales_pollo_planta);

                $updateBeneficiopollo->menudencia_pollo_kg = $this->MoneyToNumber($request->menudencia_pollo_kg);
                $updateBeneficiopollo->mollejas_corazones_kg = $this->MoneyToNumber($request->mollejas_corazones_kg);
                $updateBeneficiopollo->subtotal = $this->MoneyToNumber($request->subtotal);
                $updateBeneficiopollo->promedio_canal_kg = $this->MoneyToNumber($request->promedio_canal_kg);


                $updateBeneficiopollo->menudencia_pollo_porc = $this->MoneyToNumber($request->menudencia_pollo_porc);
                $updateBeneficiopollo->mollejas_corazones_porc = $this->MoneyToNumber($request->mollejas_corazones_porc);
                $updateBeneficiopollo->despojos_mermas = $this->MoneyToNumber($request->despojos_mermas);
                $updateBeneficiopollo->porc_pollo = $this->MoneyToNumber($request->porc_pollo);

                $updateBeneficiopollo->save();

                return response()->json([
                    "status" => 1,
                    "message" => "Guardado correctamente",
                    "registroId" => 0
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
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->fecha_beneficio);
                $onlyDate = $date->toDateString();
                return $onlyDate;
            })
            ->addColumn('action', function ($data) {
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
                    <a href="utilidadaves/' . $data->id . '" class="btn btn-dark" title="Utilidad" >
						<i class="fas fa-directions"></i>
					</a>
					<a href="desposteaves/' . $data->id . '" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Editar Beneficio1" onclick="showDataForm(' . $data->id . ')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
                    <a href="utilidadaves/' . $data->id . '" class="btn btn-dark" title="Utilidad" >
                    <i class="fas fa-directions"></i>
                     </a>
					<a href="desposteaves/' . $data->id . '" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="Editar Beneficio2" onclick="edit(' . $data->id . ');">
						<i class="fas fa-edit"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="Confirm(' . $data->id . ');">
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                } else {
                    $btn = '
                    <div class="text-center">
					<a href="desposteaves/' . $data->id . '" class="btn btn-dark" title="Despostar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="EditaBeneficio3" onclick="showDataForm(' . $data->id . ')">
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
            ->rawColumns(['date', 'action'])
            ->make(true);
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

  
    public function edit($id)
    {
        $benefi = Beneficiopollo::where('id', $id)->first();
        return response()->json([
            "id" => $id,
            "beneficiopollos" => $benefi,
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
