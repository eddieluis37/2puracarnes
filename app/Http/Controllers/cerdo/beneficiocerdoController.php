<?php

namespace App\Http\Controllers\cerdo;

use App\Http\Controllers\Controller;
use App\Models\Beneficiocerdo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Third;
use App\Models\Sacrificio;
use App\Models\Sacrificiocerdo;
use App\Models\centros\Centrocosto;
use NumberFormatter;
use DateTime;

class beneficiocerdoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$thirds = Third::orderBy('name', 'asc')->get();
		$sacrificios = Sacrificiocerdo::orderBy('name', 'asc')->get();
		$centros = Centrocosto::Where('status', 1)->get();
		//dd($sacrificios);
		return view('categorias.cerdo.beneficiocerdo.index', compact('thirds', 'sacrificios', 'centros'));
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
			$reg = Beneficiocerdo::select()->first();
			if ($reg === null) {
				$newLote = "CE" . $year . $month . $day . "1";
			} else {
				$regUltimo = Beneficiocerdo::select()->latest()->first()->toArray();
				$consecutivo = $regUltimo['id'] + 1;
				$newLote = "CE" . $year . $month . $day . $consecutivo;
			}

			/******************************************************** */
			$getReg = Beneficiocerdo::firstWhere('id', $request->idbeneficio);
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
				$newBeneficiocerdo = new Beneficiocerdo();
				$newBeneficiocerdo->centrocosto_id = $request->centrocosto_id;
				$newBeneficiocerdo->thirds_id = $request->thirds_id;
				$newBeneficiocerdo->plantasacrificiocerdo_id  = $request->plantasacrificiocerdo_id;
				$newBeneficiocerdo->cantidadmacho = $this->MoneyToNumber($request->cantidadMacho);
				$newBeneficiocerdo->valorunitariomacho = $this->MoneyToNumber($request->valorUnitarioMacho);
				$newBeneficiocerdo->valortotalmacho = $this->MoneyToNumber($request->valorTotalMacho);
				$newBeneficiocerdo->cantidad = $this->MoneyToNumber($request->cantidadMacho);

				$newBeneficiocerdo->cantidadhembra = $request->cantidadHembra;
				if ($request->cantidadHembra == 0) {
					$newBeneficiocerdo->valorunitariohembra = 0;
					$newBeneficiocerdo->valortotalhembra = 0;
				} else {
					$newBeneficiocerdo->valorunitariohembra = $this->MoneyToNumber($request->valorUnitarioHembra);
					$newBeneficiocerdo->valortotalhembra = $this->MoneyToNumber($request->valorTotalHembra);
				}				
			
				$newBeneficiocerdo->fecha_beneficio = $currentDateFormat;
				$newBeneficiocerdo->fecha_cierre = $dateNextMonday;
				$newBeneficiocerdo->factura = $request->factura;
				$newBeneficiocerdo->clientvisceras_id = $request->clientvisceras_id;
				$newBeneficiocerdo->lote = $newLote; //$request->lote;
				$newBeneficiocerdo->finca = $request->finca;
				$newBeneficiocerdo->sacrificio = $this->MoneyToNumber($request->sacrificio);
				$newBeneficiocerdo->fomento = $this->MoneyToNumber($request->fomento);
				$newBeneficiocerdo->deguello = $this->MoneyToNumber($request->deguello);
				$newBeneficiocerdo->bascula = $this->MoneyToNumber($request->bascula);
				$newBeneficiocerdo->transporte = $this->MoneyToNumber($request->transporte);
				$newBeneficiocerdo->pesopie1 = $this->MoneyToNumber($request->pesopie1);
				$newBeneficiocerdo->pesopie2 = $this->MoneyToNumber($request->pesopie2);
				$newBeneficiocerdo->pesopie3 = $this->MoneyToNumber($request->pesopie3);
				$newBeneficiocerdo->costoanimal1 = $this->MoneyToNumber($request->costoanimal1);
				$newBeneficiocerdo->costoanimal2 = $this->MoneyToNumber($request->costoanimal2);
				$newBeneficiocerdo->costoanimal3 = $this->MoneyToNumber($request->costoanimal3);
				$newBeneficiocerdo->canalcaliente = $this->MoneyToNumber($request->canalcaliente);
				$newBeneficiocerdo->canalfria = $this->MoneyToNumber($request->canalfria);
				$newBeneficiocerdo->canalplanta = $this->MoneyToNumber($request->canalplanta);
				$newBeneficiocerdo->pieleskg = $this->MoneyToNumber($request->pieleskg);
				$newBeneficiocerdo->pielescosto = $this->MoneyToNumber($request->pielescosto);
				$newBeneficiocerdo->visceras = $this->MoneyToNumber($request->visceras);
				$newBeneficiocerdo->costopie1 = $this->MoneyToNumber($request->costopie1);
				$newBeneficiocerdo->costopie2 = $this->MoneyToNumber($request->costopie2);
				$newBeneficiocerdo->costopie3 = $this->MoneyToNumber($request->costopie3);
				$newBeneficiocerdo->tsacrificio = $this->MoneyToNumber($request->tsacrificio);
				$newBeneficiocerdo->tfomento = $this->MoneyToNumber($request->tfomento);
				$newBeneficiocerdo->tdeguello = $this->MoneyToNumber($request->tdeguello);
				$newBeneficiocerdo->tbascula = $this->MoneyToNumber($request->tbascula);
				$newBeneficiocerdo->ttransporte = $this->MoneyToNumber($request->ttransporte);
				$newBeneficiocerdo->tpieles = $this->MoneyToNumber($request->tpieles);
				$newBeneficiocerdo->tvisceras = $this->MoneyToNumber($request->tvisceras);
				$newBeneficiocerdo->tcanalfria = $this->MoneyToNumber($request->tcanalfria);
				$newBeneficiocerdo->valorfactura = $this->MoneyToNumber($request->valorfactura);
				$newBeneficiocerdo->costokilo = $this->MoneyToNumber($request->costokilo);
				$newBeneficiocerdo->costo = $this->MoneyToNumber($request->costo);
				$newBeneficiocerdo->totalcostos = $this->MoneyToNumber($request->totalcostos);
				$newBeneficiocerdo->pesopie = $this->MoneyToNumber($request->pesopie);
				$newBeneficiocerdo->rtcanalcaliente = $this->MoneyToNumber($request->rtcanalcaliente);
				$newBeneficiocerdo->rtcanalplanta = $this->MoneyToNumber($request->rtcanalplanta);
				$newBeneficiocerdo->rtcanalfria = $this->MoneyToNumber($request->rtcanalfria);
				$newBeneficiocerdo->rendcaliente = $this->MoneyToNumber($request->rendcaliente);
				$newBeneficiocerdo->rendplanta = $this->MoneyToNumber($request->rendplanta);
				$newBeneficiocerdo->rendfrio = $this->MoneyToNumber($request->rendfrio);

				$newBeneficiocerdo->save();

				return response()->json([
					"status" => 1,
					"message" => "Guardado correctamente",
					"registroId" => $newBeneficiocerdo->id
				]);
			} else {

				$updateBeneficiocerdo = Beneficiocerdo::firstWhere('id', $request->idbeneficio);
				$updateBeneficiocerdo->centrocosto_id = $request->centrocosto_id;
				$updateBeneficiocerdo->thirds_id = $request->thirds_id;
				$updateBeneficiocerdo->plantasacrificiocerdo_id  = $request->plantasacrificiocerdo_id;
				$updateBeneficiocerdo->cantidadmacho = $this->MoneyToNumber($request->cantidadMacho);
				$updateBeneficiocerdo->valorunitariomacho = $this->MoneyToNumber($request->valorUnitarioMacho);
				$updateBeneficiocerdo->valortotalmacho = $this->MoneyToNumber($request->valorTotalMacho);
				$updateBeneficiocerdo->cantidadhembra = $this->MoneyToNumber($request->cantidadHembra);
				$updateBeneficiocerdo->valorunitariohembra = $this->MoneyToNumber($request->valorUnitarioHembra);
				$updateBeneficiocerdo->valortotalhembra = $this->MoneyToNumber($request->valorTotalHembra);
				$updateBeneficiocerdo->cantidad = $request->cantidadMacho + $request->cantidadHembra;
				//$updateBeneficiocerdo->fecha_beneficio = $request->fecha_beneficio;
				$updateBeneficiocerdo->factura = $request->factura;
				$updateBeneficiocerdo->clientvisceras_id = $request->clientvisceras_id;
				//$updateBeneficiocerdo->lote = $request->lote;
				$updateBeneficiocerdo->finca = $request->finca;
				$updateBeneficiocerdo->sacrificio = $this->MoneyToNumber($request->sacrificio);
				$updateBeneficiocerdo->fomento = $this->MoneyToNumber($request->fomento);
				$updateBeneficiocerdo->deguello = $this->MoneyToNumber($request->deguello);
				$updateBeneficiocerdo->bascula = $this->MoneyToNumber($request->bascula);
				$updateBeneficiocerdo->transporte = $this->MoneyToNumber($request->transporte);
				$updateBeneficiocerdo->pesopie1 = $this->MoneyToNumber($request->pesopie1);
				$updateBeneficiocerdo->pesopie2 = $this->MoneyToNumber($request->pesopie2);
				$updateBeneficiocerdo->pesopie3 = $this->MoneyToNumber($request->pesopie3);
				$updateBeneficiocerdo->costoanimal1 = $this->MoneyToNumber($request->costoanimal1);
				$updateBeneficiocerdo->costoanimal2 = $this->MoneyToNumber($request->costoanimal2);
				$updateBeneficiocerdo->costoanimal3 = $this->MoneyToNumber($request->costoanimal3);
				$updateBeneficiocerdo->canalcaliente = $this->MoneyToNumber($request->canalcaliente);
				$updateBeneficiocerdo->canalfria = $this->MoneyToNumber($request->canalfria);
				$updateBeneficiocerdo->canalplanta = $this->MoneyToNumber($request->canalplanta);
				$updateBeneficiocerdo->pieleskg = $this->MoneyToNumber($request->pieleskg);
				$updateBeneficiocerdo->pielescosto = $this->MoneyToNumber($request->pielescosto);
				$updateBeneficiocerdo->visceras = $this->MoneyToNumber($request->visceras);
				$updateBeneficiocerdo->costopie1 = $this->MoneyToNumber($request->costopie1);
				$updateBeneficiocerdo->costopie2 = $this->MoneyToNumber($request->costopie2);
				$updateBeneficiocerdo->costopie3 = $this->MoneyToNumber($request->costopie3);
				$updateBeneficiocerdo->tsacrificio = $this->MoneyToNumber($request->tsacrificio);
				$updateBeneficiocerdo->tfomento = $this->MoneyToNumber($request->tfomento);
				$updateBeneficiocerdo->tdeguello = $this->MoneyToNumber($request->tdeguello);
				$updateBeneficiocerdo->tbascula = $this->MoneyToNumber($request->tbascula);
				$updateBeneficiocerdo->ttransporte = $this->MoneyToNumber($request->ttransporte);
				$updateBeneficiocerdo->tpieles = $this->MoneyToNumber($request->tpieles);
				$updateBeneficiocerdo->tvisceras = $this->MoneyToNumber($request->tvisceras);
				$updateBeneficiocerdo->tcanalfria = $this->MoneyToNumber($request->tcanalfria);
				$updateBeneficiocerdo->valorfactura = $this->MoneyToNumber($request->valorfactura);
				$updateBeneficiocerdo->costokilo = $this->MoneyToNumber($request->costokilo);
				$updateBeneficiocerdo->costo = $this->MoneyToNumber($request->costo);
				$updateBeneficiocerdo->totalcostos = $this->MoneyToNumber($request->totalcostos);
				$updateBeneficiocerdo->pesopie = $this->MoneyToNumber($request->pesopie);
				$updateBeneficiocerdo->rtcanalcaliente = $this->MoneyToNumber($request->rtcanalcaliente);
				$updateBeneficiocerdo->rtcanalplanta = $this->MoneyToNumber($request->rtcanalplanta);
				$updateBeneficiocerdo->rtcanalfria = $this->MoneyToNumber($request->rtcanalfria);
				$updateBeneficiocerdo->rendcaliente = $this->MoneyToNumber($request->rendcaliente);
				$updateBeneficiocerdo->rendplanta = $this->MoneyToNumber($request->rendplanta);
				$updateBeneficiocerdo->rendfrio = $this->MoneyToNumber($request->rendfrio);

				$updateBeneficiocerdo->save();

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
		$data = DB::table('beneficiocerdos as be')
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
					    <a href="despostecerdo/' . $data->id . '" class="btn btn-dark" title="DesposteCerradoPorFecha" target="_blank">
							<i class="fas fa-check-circle"></i>
					    </a>
					    <button class="btn btn-dark" title="Editar Beneficio" onclick="showDataForm(' . $data->id . ')">
						    <i class="fas fa-eye"></i>
					    </button>
						<a href="beneficiocerdo/pdfLote/' . $data->id . '" class="btn btn-dark" title="VerCompraVencidaPorFecha" target="_blank">
							<i class="far fa-file-pdf"></i>
						</a>	
                        </div>
                        ';
				} elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
					$btn = '
                        <div class="text-center">
					    <a href="despostecerdo/' . $data->id . '" class="btn btn-dark" title="Despostar cerdo" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Editar Beneficio" onclick="edit(' . $data->id . ');">
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
					    <a href="despostecerdo/' . $data->id . '" class="btn btn-dark" title="DesposteCerrado" target="_blank">
							<i class="fas fa-check-circle"></i>
					    </a>
					    <button class="btn btn-dark" title="VerBeneficio" onclick="showDataForm(' . $data->id . ')">
						    <i class="fas fa-eye"></i>
					    </button>
					    <a href="beneficiocerdo/pdfLote/' . $data->id . '" class="btn btn-dark" title="VerCompraCerrada" target="_blank">
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

	public function get_plantasacrificiocerdo_by_id(Request $request)
	{
		$data1 = Sacrificiocerdo::where('id', $request->plantasacrificiocerdo_id)->firstOrFail();

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

		$benefi = Beneficiocerdo::where('id', $id)->first();
		return response()->json([
			"id" => $id,
			"beneficiocerdos" => $benefi,
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
			$updateBeneficiocerdo = Beneficiocerdo::firstWhere('id', $id);
			$updateBeneficiocerdo->status = false;
			$updateBeneficiocerdo->save();
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
