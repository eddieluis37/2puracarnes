<?php

namespace App\Http\Livewire;

use App\Models\Beneficiopollo;
//use App\Models\Beneficiore;
use App\Models\Sacrificio;
use App\Models\Sacrificiopollo;
use App\Models\Third;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;



class BeneficiopollosController extends Component
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
		$this->componentName = 'Beneficio Pollos';
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

			$beneficiopollos = Beneficiopollo::join('thirds as t', 't.id', 'beneficiopollos.thirds_id')
									   ->join('sacrificiopollos as s', 's.id', 'beneficiopollos.plantasacrificio_id')
									 
				->select('beneficiopollos.*', 't.name as third',
						 'beneficiopollos.*', 's.name as sacrificio',
																		)

				->orderBy('beneficiopollos.id', 'desc')
				->paginate($this->pagination);



	    return view('livewire.beneficiopollos.component', ['data' => $beneficiopollos,
				'thirds' => Third::orderBy('name', 'asc')->get(),
				'sacrificios' => Sacrificiopollo::orderBy('name', 'asc')->get(),				
				

			])
				->extends('layouts.theme.app')
				->section('content');


	}


		public function get_plantasacrificiopollo_by_id(Request $request)
		{
		

		if ($request->ajax()) {
			$data1 = Sacrificiopollo::where('id', $request->plantasacrificio_id)
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

	public function storepollo(Request $request)
	{
		$newBeneficiopollo = new Beneficiopollo();

		$newBeneficiopollo->thirds_id = $request->thirds_id;
		$newBeneficiopollo->plantasacrificio_id  = $request->plantasacrificio_id;
		$newBeneficiopollo->cantidad = $request->cantidad;
		$newBeneficiopollo->fecha_beneficio = $request->fecha_beneficio;
		$newBeneficiopollo->factura = $request->factura;
		$newBeneficiopollo->clientpieles_id = $request->clientpieles_id;
		$newBeneficiopollo->clientvisceras_id = $request->clientvisceras_id;
		$newBeneficiopollo->lote = $request->lote;
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
		$newBeneficiopollo->costopie1 = $request->costopie1;
		$newBeneficiopollo->costopie2 = $request->costopie2;
		$newBeneficiopollo->costopie3 = $request->costopie3;
		$newBeneficiopollo->tsacrificio = $request->tsacrificio;
		$newBeneficiopollo->tfomento = $request->tfomento;
		$newBeneficiopollo->tdeguello = $request->tdeguello;
		$newBeneficiopollo->tbascula = $request->tbascula;
		$newBeneficiopollo->ttransporte = $request->ttransporte;
		$newBeneficiopollo->tpieles = $request->tpieles;
		$newBeneficiopollo->tvisceras = $request->tvisceras;
		$newBeneficiopollo->tcanalfria = $request->tcanalfria;
		$newBeneficiopollo->valorfactura = $request->valorfactura;
		$newBeneficiopollo->costokilo = $request->costokilo;
		$newBeneficiopollo->costo = $request->costo;
		$newBeneficiopollo->totalcostos = $request->totalcostos;
		$newBeneficiopollo->pesopie = $request->pesopie;
		$newBeneficiopollo->rtcanalcaliente = $request->rtcanalcaliente;
		$newBeneficiopollo->rtcanalplanta = $request->rtcanalplanta;
		$newBeneficiopollo->rtcanalfria = $request->rtcanalfria;
		$newBeneficiopollo->rendcaliente = $request->rendcaliente;
		$newBeneficiopollo->rendplanta = $request->rendplanta;
		$newBeneficiopollo->rendfrio = $request->rendfrio;

		$newBeneficiopollo->save();

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



