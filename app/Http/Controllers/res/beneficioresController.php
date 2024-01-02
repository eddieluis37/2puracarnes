<?php

namespace App\Http\Controllers\res;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Third;
use App\Models\Sacrificio;
use App\Models\Beneficiore;
use App\Models\centros\Centrocosto;
use NumberFormatter;
use DateTime;

class beneficioresController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$thirds = Third::orderBy('name', 'asc')->get();
		$sacrificios = Sacrificio::orderBy('name', 'asc')->get();
		$centros = Centrocosto::Where('status', 1)->get();
		return view('categorias.res.beneficiores.index', compact('thirds', 'sacrificios', 'centros'));
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
			$reg = Beneficiore::select()->first();
			if ($reg === null) {
				$newLote = "RES" . $year . $month . $day . "1";
			} else {
				$regUltimo = Beneficiore::select()->latest()->first()->toArray();
				$consecutivo = $regUltimo['id'] + 1;
				$newLote = "RES" . $year . $month . $day . $consecutivo;
			}

			/******************************************************** */
			$getReg = Beneficiore::firstWhere('id', $request->idbeneficio);
			if ($getReg == null) {
				//$start_date = $request->fecha_beneficio; // Replace with your start date
				//$current_date = new DateTime($start_date);
				//$current_date->modify('next monday'); // Move to the next Monday
				//$dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
				$currentDateTime = Carbon::now();
				$currentDateFormat = Carbon::parse($currentDateTime->format('Y-m-d'));
				$current_date = Carbon::parse($currentDateTime->format('Y-m-d'));
				$current_date->modify('next monday'); // Move to the next Monday
				$dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
				$newBeneficiore = new Beneficiore();
				$newBeneficiore->centrocosto_id = $request->centrocosto_id;
				$newBeneficiore->thirds_id = $request->thirds_id;
				$newBeneficiore->plantasacrificio_id  = $request->plantasacrificio_id;
				$newBeneficiore->cantidadmacho = $this->MoneyToNumber($request->cantidadMacho);
				$newBeneficiore->valorunitariomacho = $this->MoneyToNumber($request->valorUnitarioMacho);
				$newBeneficiore->valortotalmacho = $this->MoneyToNumber($request->valorTotalMacho);
				$newBeneficiore->cantidadhembra = $this->MoneyToNumber($request->cantidadHembra);
				$newBeneficiore->valorunitariohembra = $this->MoneyToNumber($request->valorUnitarioHembra);
				$newBeneficiore->valortotalhembra = $this->MoneyToNumber($request->valorTotalHembra);
				$newBeneficiore->cantidad = $request->cantidadMacho + $request->cantidadHembra;
				$newBeneficiore->fecha_beneficio = $currentDateFormat;
				$newBeneficiore->fecha_cierre = $dateNextMonday;
				$newBeneficiore->factura = $request->factura;
				$newBeneficiore->clientpieles_id = $request->clientpieles_id;
				$newBeneficiore->clientvisceras_id = $request->clientvisceras_id;
				$newBeneficiore->lote = $newLote; //$request->lote;
				$newBeneficiore->finca = $request->finca;
				$newBeneficiore->sacrificio = $this->MoneyToNumber($request->sacrificio);
				$newBeneficiore->fomento = $this->MoneyToNumber($request->fomento);
				$newBeneficiore->deguello = $this->MoneyToNumber($request->deguello);
				$newBeneficiore->bascula = $this->MoneyToNumber($request->bascula);
				$newBeneficiore->transporte = $this->MoneyToNumber($request->transporte);
				$newBeneficiore->pesopie1 = $this->MoneyToNumber($request->pesopie1);
				$newBeneficiore->pesopie2 = $this->MoneyToNumber($request->pesopie2);
				$newBeneficiore->pesopie3 = $this->MoneyToNumber($request->pesopie3);
				$newBeneficiore->costoanimal1 = $this->MoneyToNumber($request->costoanimal1);
				$newBeneficiore->costoanimal2 = $this->MoneyToNumber($request->costoanimal2);
				$newBeneficiore->costoanimal3 = $this->MoneyToNumber($request->costoanimal3);
				$newBeneficiore->canalcaliente = $this->MoneyToNumber($request->canalcaliente);
				$newBeneficiore->canalfria = $this->MoneyToNumber($request->canalfria);
				$newBeneficiore->canalplanta = $this->MoneyToNumber($request->canalplanta);
				$newBeneficiore->pieleskg = $this->MoneyToNumber($request->pieleskg);
				$newBeneficiore->pielescosto = $this->MoneyToNumber($request->pielescosto);
				$newBeneficiore->visceras = $this->MoneyToNumber($request->visceras);
				$newBeneficiore->costopie1 = $this->MoneyToNumber($request->costopie1);
				$newBeneficiore->costopie2 = $this->MoneyToNumber($request->costopie2);
				$newBeneficiore->costopie3 = $this->MoneyToNumber($request->costopie3);
				$newBeneficiore->tsacrificio = $this->MoneyToNumber($request->tsacrificio);
				$newBeneficiore->tfomento = $this->MoneyToNumber($request->tfomento);
				$newBeneficiore->tdeguello = $this->MoneyToNumber($request->tdeguello);
				$newBeneficiore->tbascula = $this->MoneyToNumber($request->tbascula);
				$newBeneficiore->ttransporte = $this->MoneyToNumber($request->ttransporte);
				$newBeneficiore->tpieles = $this->MoneyToNumber($request->tpieles);
				$newBeneficiore->tvisceras = $this->MoneyToNumber($request->tvisceras);
				$newBeneficiore->tcanalfria = $this->MoneyToNumber($request->tcanalfria);
				$newBeneficiore->valorfactura = $this->MoneyToNumber($request->valorfactura);
				$newBeneficiore->costokilo = $this->MoneyToNumber($request->costokilo);
				$newBeneficiore->costo = $this->MoneyToNumber($request->costo);
				$newBeneficiore->totalcostos = $this->MoneyToNumber($request->totalcostos);
				$newBeneficiore->pesopie = $this->MoneyToNumber($request->pesopie);
				$newBeneficiore->rtcanalcaliente = $this->MoneyToNumber($request->rtcanalcaliente);
				$newBeneficiore->rtcanalplanta = $this->MoneyToNumber($request->rtcanalplanta);
				$newBeneficiore->rtcanalfria = $this->MoneyToNumber($request->rtcanalfria);
				$newBeneficiore->rendcaliente = $this->MoneyToNumber($request->rendcaliente);
				$newBeneficiore->rendplanta = $this->MoneyToNumber($request->rendplanta);
				$newBeneficiore->rendfrio = $this->MoneyToNumber($request->rendfrio);

				$newBeneficiore->save();

				return response()->json([
					"status" => 1,
					"message" => "Guardado correctamente",
					"registroId" => $newBeneficiore->id
				]);
			} else {

				$updateBeneficiore = Beneficiore::firstWhere('id', $request->idbeneficio);
				$updateBeneficiore->centrocosto_id = $request->centrocosto_id;
				$updateBeneficiore->thirds_id = $request->thirds_id;
				$updateBeneficiore->plantasacrificio_id  = $request->plantasacrificio_id;
				$updateBeneficiore->cantidadmacho = $this->MoneyToNumber($request->cantidadMacho);
				$updateBeneficiore->valorunitariomacho = $this->MoneyToNumber($request->valorUnitarioMacho);
				$updateBeneficiore->valortotalmacho = $this->MoneyToNumber($request->valorTotalMacho);
				$updateBeneficiore->cantidadhembra = $this->MoneyToNumber($request->cantidadHembra);
				$updateBeneficiore->valorunitariohembra = $this->MoneyToNumber($request->valorUnitarioHembra);
				$updateBeneficiore->valortotalhembra = $this->MoneyToNumber($request->valorTotalHembra);
				$updateBeneficiore->cantidad = $request->cantidadMacho + $request->cantidadHembra;
				//$updateBeneficiore->fecha_beneficio = $request->fecha_beneficio;
				$updateBeneficiore->factura = $request->factura;
				$updateBeneficiore->clientpieles_id = $request->clientpieles_id;
				$updateBeneficiore->clientvisceras_id = $request->clientvisceras_id;
				//$updateBeneficiore->lote = $request->lote;
				$updateBeneficiore->finca = $request->finca;
				$updateBeneficiore->sacrificio = $this->MoneyToNumber($request->sacrificio);
				$updateBeneficiore->fomento = $this->MoneyToNumber($request->fomento);
				$updateBeneficiore->deguello = $this->MoneyToNumber($request->deguello);
				$updateBeneficiore->bascula = $this->MoneyToNumber($request->bascula);
				$updateBeneficiore->transporte = $this->MoneyToNumber($request->transporte);
				$updateBeneficiore->pesopie1 = $this->MoneyToNumber($request->pesopie1);
				$updateBeneficiore->pesopie2 = $this->MoneyToNumber($request->pesopie2);
				$updateBeneficiore->pesopie3 = $this->MoneyToNumber($request->pesopie3);
				$updateBeneficiore->costoanimal1 = $this->MoneyToNumber($request->costoanimal1);
				$updateBeneficiore->costoanimal2 = $this->MoneyToNumber($request->costoanimal2);
				$updateBeneficiore->costoanimal3 = $this->MoneyToNumber($request->costoanimal3);
				$updateBeneficiore->canalcaliente = $this->MoneyToNumber($request->canalcaliente);
				$updateBeneficiore->canalfria = $this->MoneyToNumber($request->canalfria);
				$updateBeneficiore->canalplanta = $this->MoneyToNumber($request->canalplanta);
				$updateBeneficiore->pieleskg = $this->MoneyToNumber($request->pieleskg);
				$updateBeneficiore->pielescosto = $this->MoneyToNumber($request->pielescosto);
				$updateBeneficiore->visceras = $this->MoneyToNumber($request->visceras);
				$updateBeneficiore->costopie1 = $this->MoneyToNumber($request->costopie1);
				$updateBeneficiore->costopie2 = $this->MoneyToNumber($request->costopie2);
				$updateBeneficiore->costopie3 = $this->MoneyToNumber($request->costopie3);
				$updateBeneficiore->tsacrificio = $this->MoneyToNumber($request->tsacrificio);
				$updateBeneficiore->tfomento = $this->MoneyToNumber($request->tfomento);
				$updateBeneficiore->tdeguello = $this->MoneyToNumber($request->tdeguello);
				$updateBeneficiore->tbascula = $this->MoneyToNumber($request->tbascula);
				$updateBeneficiore->ttransporte = $this->MoneyToNumber($request->ttransporte);
				$updateBeneficiore->tpieles = $this->MoneyToNumber($request->tpieles);
				$updateBeneficiore->tvisceras = $this->MoneyToNumber($request->tvisceras);
				$updateBeneficiore->tcanalfria = $this->MoneyToNumber($request->tcanalfria);
				$updateBeneficiore->valorfactura = $this->MoneyToNumber($request->valorfactura);
				$updateBeneficiore->costokilo = $this->MoneyToNumber($request->costokilo);
				$updateBeneficiore->costo = $this->MoneyToNumber($request->costo);
				$updateBeneficiore->totalcostos = $this->MoneyToNumber($request->totalcostos);
				$updateBeneficiore->pesopie = $this->MoneyToNumber($request->pesopie);
				$updateBeneficiore->rtcanalcaliente = $this->MoneyToNumber($request->rtcanalcaliente);
				$updateBeneficiore->rtcanalplanta = $this->MoneyToNumber($request->rtcanalplanta);
				$updateBeneficiore->rtcanalfria = $this->MoneyToNumber($request->rtcanalfria);
				$updateBeneficiore->rendcaliente = $this->MoneyToNumber($request->rendcaliente);
				$updateBeneficiore->rendplanta = $this->MoneyToNumber($request->rendplanta);
				$updateBeneficiore->rendfrio = $this->MoneyToNumber($request->rendfrio);

				$updateBeneficiore->save();

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
		$data = DB::table('beneficiores as be')
			->join('thirds as tird', 'be.thirds_id', '=', 'tird.id')
			->join('centro_costo as cc', 'be.centrocosto_id', '=', 'cc.id')
			->select('be.*', 'cc.name as namecentrocosto', 'tird.name as namethird')
			->where('be.status', '=', true)
			->orderBy('be.id', 'desc')
			->get();
		//$data = Compensadores::orderBy('id','desc');
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
					    <a href="desposteres/' . $data->id . '" class="btn btn-dark" title="DesposteCerradoPorFecha" target="_blank">
							<i class="fas fa-check-circle"></i>
					    </a>
					    <button class="btn btn-dark" title="Editar Beneficio" onclick="showDataForm(' . $data->id . ')">
						    <i class="fas fa-eye"></i>
					    </button>
					  
						<a href="beneficiores/pdfLote/' . $data->id . '" class="btn btn-dark" title="VerCompraVencidaPorFecha" target="_blank">
                       		 <i class="far fa-file-pdf"></i>
					    </a>
                        </div>
                        ';
				} elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
					$btn = '
                        <div class="text-center">
					    <a href="desposteres/' . $data->id . '" class="btn btn-dark" title="Despostar" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Editar Beneficio" onclick="edit(' . $data->id . ');">
						    <i class="fas fa-edit"></i>
					    </button>
					   
						<a href="beneficiores/pdfLote/' . $data->id . '" class="btn btn-dark" title="VerCompraPendiente" target="_blank">
                        	<i class="far fa-file-pdf"></i>
					    </a>
                        </div>
                        ';
				} else {
					$btn = '
                        <div class="text-center">
					    <a href="desposteres/' . $data->id . '" class="btn btn-dark" title="DesposteCerrado" target="_blank">
							<i class="fas fa-check-circle"></i>
					    </a>
					    <button class="btn btn-dark" title="VerBeneficio" onclick="showDataForm(' . $data->id . ')">
						    <i class="fas fa-eye"></i>
					    </button>
						<a href="beneficiores/pdfLote/' . $data->id . '" class="btn btn-dark" title="VerCompraCerrada" target="_blank">
                        	<i class="far fa-file-pdf"></i>
					    </a>
                        </div>
                        ';
				}
				return $btn;
			})
			->rawColumns(['date', 'action'])
			->make(true);
	}





	public function get_plantasacrificio_by_id(Request $request)
	{
		$data1 = Sacrificio::where('id', $request->plantasacrificio_id)->firstOrFail();

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
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		$benefi = Beneficiore::where('id', $id)->first();
		return response()->json([
			"id" => $id,
			"beneficiores" => $benefi,
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
		try {
			$updateBeneficiore = Beneficiore::firstWhere('id', $id);
			$updateBeneficiore->status = false;
			$updateBeneficiore->save();
			return response()->json([
				"status" => 201,
				"message" => "El registro se dio de baja con exito",
			]);
		} catch (\Throwable $th) {
			return response()->json([
				"status" => 500,
				"message" => (array) $th
			]);
		}
	}
}
