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

			$Beneficiores = Beneficiore::join('thirds as t', 't.id', 'Beneficiores.thirds_id')
									   ->join('sacrificios as s', 's.id', 'Beneficiores.plantasacrificio_id')
									 
				->select('Beneficiores.*', 't.name as third',
						 'Beneficiores.*', 's.name as sacrificio',
																		)

				->orderBy('Beneficiores.id', 'desc')
				->paginate($this->pagination);



	    return view('livewire.Beneficiores.component', ['data' => $Beneficiores,
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

	public function store(Request $request)
	{
		$newBeneficiore = new Beneficiore();

		$newBeneficiore->thirds_id = $request->thirds_id;
		$newBeneficiore->plantasacrificio_id  = $request->plantasacrificio_id;
		$newBeneficiore->cantidad = $request->cantidad;
		$newBeneficiore->fecha_beneficio = $request->fecha_beneficio;
		$newBeneficiore->factura = $request->factura;
		$newBeneficiore->clientpieles_id = $request->clientpieles_id;
		$newBeneficiore->clientvisceras_id = $request->clientvisceras_id;
		$newBeneficiore->lote = $request->lote;
		$newBeneficiore->sacrificio = $request->sacrificio;
		$newBeneficiore->fomento = $request->fomento;
		$newBeneficiore->deguello = $request->deguello;
		$newBeneficiore->bascula = $request->bascula;
		$newBeneficiore->transporte = $request->transporte;
		$newBeneficiore->pesopie1 = $request->pesopie1;
		$newBeneficiore->pesopie2 = $request->pesopie2;
		$newBeneficiore->pesopie3 = $request->pesopie3;
		$newBeneficiore->costoanimal1 = $request->costoanimal1;
		$newBeneficiore->costoanimal2 = $request->costoanimal2;
		$newBeneficiore->costoanimal3 = $request->costoanimal3;
		$newBeneficiore->canalcaliente = $request->canalcaliente;
		$newBeneficiore->canalfria = $request->canalfria;
		$newBeneficiore->canalplanta = $request->canalplanta;
		$newBeneficiore->pieleskg = $request->pieleskg;
		$newBeneficiore->pielescosto = $request->pielescosto;
		$newBeneficiore->visceras = $request->visceras;
		$newBeneficiore->costopie1 = $request->costopie1;
		$newBeneficiore->costopie2 = $request->costopie2;
		$newBeneficiore->costopie3 = $request->costopie3;
		$newBeneficiore->tsacrificio = $request->tsacrificio;
		$newBeneficiore->tfomento = $request->tfomento;
		$newBeneficiore->tdeguello = $request->tdeguello;
		$newBeneficiore->tbascula = $request->tbascula;
		$newBeneficiore->ttransporte = $request->ttransporte;
		$newBeneficiore->tpieles = $request->tpieles;
		$newBeneficiore->tvisceras = $request->tvisceras;
		$newBeneficiore->tcanalfria = $request->tcanalfria;
		$newBeneficiore->valorfactura = $request->valorfactura;
		$newBeneficiore->costokilo = $request->costokilo;
		$newBeneficiore->costo = $request->costo;
		$newBeneficiore->totalcostos = $request->totalcostos;
		$newBeneficiore->pesopie = $request->pesopie;
		$newBeneficiore->rtcanalcaliente = $request->rtcanalcaliente;
		$newBeneficiore->rtcanalplanta = $request->rtcanalplanta;
		$newBeneficiore->rtcanalfria = $request->rtcanalfria;
		$newBeneficiore->rendcaliente = $request->rendcaliente;
		$newBeneficiore->rendplanta = $request->rendplanta;
		$newBeneficiore->rendfrio = $request->rendfrio;



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



