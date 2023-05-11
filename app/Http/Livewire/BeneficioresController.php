<?php

namespace App\Http\Livewire;

use App\Models\Beneficiore;
use App\Models\Sacrificio;
use App\Models\Third;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use NumberFormatter;
use DateTime;
use Carbon\Carbon;

class BeneficioresController extends Component
{
    
    use WithPagination;

    
    public $data1, $search, $selected_id, $pageTitle, $componentName, $thirdsid, $plantasacrificioid, $plantasacrificio_id, $cantidad, $fecha_beneficio, $factura, $clientpielesid, $clientviscerasid, $finca, $lote, $status, $sacrificio, $fomento, $deguello, $bascula, $tranporte, $pesopie1, $pesopie2, $pesopie3, $costoanimal1, $costoanimal2, $costoanimal3, $canalcaliente, $canalfria, $canalplanta, $pieleskg, $pielescosto, $visceras, $costopie1, $costopie2, $costopie3, $tsacrificio, $tfomento, $tdeguello, $tbascula, $ttransporte, $tpieles, $tvisceras, $tcanalfria, $valorfactura, $costokilo, $costo, $totalcostos, $pesopie, $rtcanalcaliente, $rtcanalplanta, $rtcanalfria, $rendcaliente, $rendplanta, $rendfrio;
    public $monday;
    public $test;
    public $dateNow;
    public User $user;

    
    private $pagination = 5;

	
	/*public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}
	*/

	public function mount()
	{
		$this->data1 =[];
		$this->pageTitle = 'Listado';
		$this->componentName = 'Beneficio Res';
	//	$this->thirdsid = 'Elegir';
		$this->plantasacrificioid = 'Elegir';	
		$this->clientpielesid = 'Elegir';
		$this->clientviscerasid = 'Elegir';		
		$this->status = 1;
		//Monday
		//Saturday //test
		if (date('l', strtotime('today')) === 'Monday') {
			//$this->monday = 'Today is Monday!';
			$this->monday = false;
		} else {
			//$this->monday =	'Today is not Monday.';
			$this->monday =	false;
		}
		$date = new DateTime();
		$currentDate = $date->format('Y-m-d');
		$this->dateNow = $currentDate;
		

		//$start_date = '2023-05-08'; // Replace with your start date
		//$current_date = new DateTime($start_date);
		//$current_date->modify('next monday'); // Move to the next Monday
		//$this->test = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
		//$test = 
	}


//$data['sacrificio'] = DB::table('sacrificios')->get();
//$sacrificio = DB::table('sacrificios')->get();
//dd($data);

    public function render()
	{		

	 	// $this->plantasacrificiobyid();

	 	//$this->get_plantasacrificio_by_id();


		if (strlen($this->search) > 0)
			$thirds = Third::join('type_identifications as t', 't.id', 'thirds.type_identification_id')
						   ->join('offices as o', 'o.id', 'thirds.office_id')
						   ->join('agreements as a', 'a.id', 'thirds.agreement_id')
				->select('thirds.*', 't.name as type_identification',
						 'thirds.*', 'o.name as office',
						 'thirds.*', 'a.name as agreement')
				->where('thirds.name', 'like', '%' . $this->search . '%')
				->orWhere('thirds.identification', 'like', '%' . $this->search . '%')
				->orWhere('thirds.office_id', 'like', '%' . $this->search . '%')				
				->orderBy('thirds.name', 'asc')
				->paginate($this->pagination);
		else

			$beneficiores = Beneficiore::join('thirds as t', 't.id', 'beneficiores.thirds_id')
			->join('sacrificios as s', 's.id', 'beneficiores.plantasacrificio_id')
			->select('beneficiores.*', 't.name as third', 'beneficiores.*', 's.name as sacrificio')
			->where('beneficiores.status', '=', true)
			->orderBy('beneficiores.id', 'desc')
			->paginate($this->pagination);

			return view('livewire.beneficiores.component', ['data' => $beneficiores,
				'thirds' => Third::orderBy('name', 'asc')->get(),
				'sacrificios' => Sacrificio::orderBy('name', 'asc')->get(),				
			])
			->extends('layouts.theme.app')
			->section('content');


	}


		public function get_plantasacrificio_by_id(Request $request)
		{
		

		if ($request->ajax()) {
			$data1 = Sacrificio::where('id', $request->plantasacrificio_id)
				->firstOrFail();

			//	dd($sacrificio);

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

	public function MoneyToNumber(string $moneyValue): float {
		$formatter = new NumberFormatter('es-CL', NumberFormatter::DECIMAL);
		$number = $formatter->parse($moneyValue);
		return (float) $number;
	}

	public function store(Request $request)
	{

		$dateNow = Carbon::now();
		// Get the year, month, and day
		$year = $dateNow->year;
		$month = $dateNow->month;
		$day = $dateNow->day;
		$newLote = "";
        $reg = Beneficiore::select()->first();
        if ($reg === null) {
            $newLote = "RES".$year.$month.$day."1";
        }else {
            $regUltimo = Beneficiore::select()->latest()->first()->toArray();
            $consecutivo = $regUltimo['id']+1;
            $newLote = "RES".$year.$month.$day.$consecutivo;
        }
		/******************************************************** */
		$getReg = Beneficiore::firstWhere('id', $request->idbeneficio);
		if($getReg == null) {
			$start_date = $request->fecha_beneficio; // Replace with your start date
			$current_date = new DateTime($start_date);
			$current_date->modify('next monday'); // Move to the next Monday
			$dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
			$newBeneficiore = new Beneficiore();
			$newBeneficiore->thirds_id = $request->thirds_id;
			$newBeneficiore->plantasacrificio_id  = $request->plantasacrificio_id;
			$newBeneficiore->cantidadmacho = $this->MoneyToNumber($request->cantidadMacho);
			$newBeneficiore->valorunitariomacho = $this->MoneyToNumber($request->valorUnitarioMacho);
			$newBeneficiore->valortotalmacho = $this->MoneyToNumber($request->valorTotalMacho);
			$newBeneficiore->cantidadhembra = $this->MoneyToNumber($request->cantidadHembra);
			$newBeneficiore->valorunitariohembra = $this->MoneyToNumber($request->valorUnitarioHembra);
			$newBeneficiore->valortotalhembra = $this->MoneyToNumber($request->valorTotalHembra);
			$newBeneficiore->cantidad = $request->cantidadMacho + $request->cantidadHembra;
			$newBeneficiore->fecha_beneficio = $request->fecha_beneficio;
			$newBeneficiore->fecha_cierre = $dateNextMonday;
			$newBeneficiore->factura = $request->factura;
			$newBeneficiore->clientpieles_id = $request->clientpieles_id;
			$newBeneficiore->clientvisceras_id = $request->clientvisceras_id;
			$newBeneficiore->lote = $newLote;//$request->lote;
			//$newBeneficiore->finca = $request->finca; //falta agregar
			$newBeneficiore->sacrificio = $request->sacrificio;
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
			$newBeneficiore->tpieles =$this->MoneyToNumber($request->tpieles);
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

		}else {

			$updateBeneficiore = Beneficiore::firstWhere('id', $request->idbeneficio);
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
			//$updateBeneficiore->finca = $request->finca; //falta agregar
			$updateBeneficiore->sacrificio = $request->sacrificio;
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
			$updateBeneficiore->tpieles =$this->MoneyToNumber($request->tpieles);
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

		}

		return redirect()->back();
		
		//$this->resetUI();
		//$this->emit('beneficiore-added', 'Beneficiores Registrado');		
	}

	public function edit($id){

        $benefi = Beneficiore::where('id', $id)->first();
		return response()->json([
			"id" => $id,
			"beneficiores" => $benefi,
		]);
	}


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

	public function resetUI()
	{
		$this->name = '';	
		$this->type_identificationid = 'Elegir';
		$this->identification = '';
		$this->digito_verificacion = 'Elegir';
		$this->officeid = '';
		$this->agreementid = 'Elegir';
		$this->type_regimen_ivaid = 'Elegir';
		$this->direccion = '';
		$this->provinceid = 'Elegir';
		$this->celular = '';
		$this->nombre_contacto = '';
		$this->correo = '';
		$this->search = '';		
		$this->selected_id = 0;
		$this->resetValidation();
	}


		

}



