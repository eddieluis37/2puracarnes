<?php

namespace App\Http\Livewire;

use App\Models\Beneficiore;
use App\Models\Sacrificio;
use App\Models\Third;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;



class BeneficioresController extends Component
{
    
    use WithPagination;

    
    public $search, $selected_id, $pageTitle, $componentName, $thirdsid, $plantasacrificio_id, $cantidad, $fecha_beneficio, $factura, $clientpielesid, $clientviscerasid, $lote, $status, $sacrificio, $fomento, $deguello, $bascula, $tranporte, $pesopie1, $pesopie2, $pesopie3, $costoanimal1, $costoanimal2, $costoanimal3, $canalcaliente, $canalfria, $canalplanta, $pieleskg, $pielescostos, $visceras, $costopie1, $costopie2, $costopie3, $tsacrificio, $tfomento, $tdeguello, $tbascula, $ttransporte, $tpieles, $tvisceras, $tcanalfria, $valorfactura, $costokilo, $costo, $totalcostos, $pesopie, $rtcanalcaliente, $rtcanalplanta, $rtcanalfria, $rendcaliente, $rendplanta, $rendfrio;

    
    private $pagination = 5;

	
	public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}


	public function mount()
	{
		$this->pageTitle = 'Listado';
		$this->componentName = 'Beneficio Res';
		$this->thirdsid = 'Elegir';
		$this->plantasacrificioid = 'Elegir';
		$this->clientpielesid = 'Elegir';
		$this->clientviscerasid = 'Elegir';		
		$this->status = 1;
	}


    public function render()
	{
		

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

				->orderBy('Beneficiores.fecha_beneficio', 'asc')
				->paginate($this->pagination);



	    return view('livewire.Beneficiores.component', ['data' => $Beneficiores,
				'thirds' => Third::orderBy('name', 'asc')->get(),
				'sacrificios' => Sacrificio::orderBy('name', 'asc')->get(),				
				

			])
				->extends('layouts.theme.app')
				->section('content');



	}


	public function get_plantasacrificio_by_id(Request $request){  

			$data['sacrificio'] = DB::table('sacrificios')->get();
			//$sacrificio = DB::table('sacrificios')->get();

			dd($data);
            
			if ($request->ajax()) {           
				$sacrificios = Sacrificio::where('id',$request->plantasacrificio_id)
				->firstOrFail();
	
				return response()->json(
					[
						'sacrificio' => $sacrificios->sacrificio,
						'fomento' => $sacrificios->fomento,
						'deguello' => $sacrificios->deguello,  
						'bascula'  => $sacrificios->bascula,
						'transporte'  => $sacrificios->transporte,                    
					]);
	
			   
			  //   return response()->json($sacrificios);
			}
		}

		




}
