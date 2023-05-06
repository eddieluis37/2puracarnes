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


class BeneficioresController extends Component
{
    
    use WithPagination;

    
    public $data1, $search, $selected_id, $pageTitle, $componentName, $thirdsid, $plantasacrificioid, $plantasacrificio_id, $cantidad, $fecha_beneficio, $factura, $clientpielesid, $clientviscerasid, $finca, $lote, $status, $sacrificio, $fomento, $deguello, $bascula, $tranporte, $pesopie1, $pesopie2, $pesopie3, $costoanimal1, $costoanimal2, $costoanimal3, $canalcaliente, $canalfria, $canalplanta, $pieleskg, $pielescosto, $visceras, $costopie1, $costopie2, $costopie3, $tsacrificio, $tfomento, $tdeguello, $tbascula, $ttransporte, $tpieles, $tvisceras, $tcanalfria, $valorfactura, $costokilo, $costo, $totalcostos, $pesopie, $rtcanalcaliente, $rtcanalplanta, $rtcanalfria, $rendcaliente, $rendplanta, $rendfrio;

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
									 
				->select('beneficiores.*', 't.name as third',
						 'beneficiores.*', 's.name as sacrificio',
																		)

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
		//dd($request->valorUnitarioMacho);
		//dd($this->MoneyToNumber($request->valorUnitarioMacho));
		$newBeneficiore = new Beneficiore();

		$newBeneficiore->thirds_id = $request->thirds_id;
		$newBeneficiore->plantasacrificio_id  = $request->plantasacrificio_id;
		$newBeneficiore->cantidadmacho = $this->MoneyToNumber($request->cantidadMacho);
		$newBeneficiore->valorunitariomacho = $this->MoneyToNumber($request->valorUnitarioMacho);
		$newBeneficiore->valortotalmacho = $this->MoneyToNumber($request->valorTotalMacho);
		$newBeneficiore->cantidadhembra = $this->MoneyToNumber($request->cantidadHembra);
		$newBeneficiore->valorunitariohembra = $this->MoneyToNumber($request->valorUnitarioHembra);
		$newBeneficiore->valortotalhembra = $this->MoneyToNumber($request->valorTotalHembra);
		$newBeneficiore->cantidad = $request->cantidadMacho + $request->valorunitariohembra;
		$newBeneficiore->fecha_beneficio = $request->fecha_beneficio;
		$newBeneficiore->factura = $request->factura;
		$newBeneficiore->clientpieles_id = $request->clientpieles_id;
		$newBeneficiore->clientvisceras_id = $request->clientvisceras_id;
		$newBeneficiore->lote = $request->lote;
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

		return redirect()->back();

		
		//$this->resetUI();
		//$this->emit('beneficiore-added', 'Beneficiores Registrado');		
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



