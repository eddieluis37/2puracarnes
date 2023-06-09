<?php

namespace App\Http\Livewire;

use App\Models\Agreement;
use App\Models\Office;
use App\Models\Province;
use App\Models\Third;
use App\Models\Type_identification;
use App\Models\Type_regimen_iva;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class ThirdsController extends Component
{

	use WithFileUploads;
	use WithPagination;
   

	public $name, $type_identificationid, $identification, $digito_verificacion, $officeid, $agreementid, $type_regimen_ivaid, $direccion, $search, $provinceid, $celular, $nombre_contacto, $status, $correo, $selected_id, $pageTitle, $componentName;
	
	private $pagination = 5;

	public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}


	public function mount()
	{
		$this->pageTitle = 'Listado';
		$this->componentName = 'Terceros';
		$this->type_identificationid = 'Elegir';
		$this->digito_verificacion = 0;
		$this->officeid = 'Elegir';
		$this->agreementid = 'Elegir';
		$this->type_regimen_ivaid = 'Elegir';
		$this->provinceid = 'Elegir';
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

			$thirds = Third::join('type_identifications as t', 't.id', 'thirds.type_identification_id')
							->join('offices as o', 'o.id', 'thirds.office_id')
							->join('agreements as a', 'a.id', 'thirds.agreement_id')
				->select('thirds.*', 't.name as type_identification',
						 'thirds.*', 'o.name as office',
						 'thirds.*', 'a.name as agreement')

				->orderBy('thirds.name', 'asc')
				->paginate($this->pagination);



	    return view('livewire.thirds.component', ['data' => $thirds,
				'type_identifications' => Type_identification::orderBy('name', 'asc')->get(),
				'offices' => Office::orderBy('name', 'asc')->get(),
				'agreements' => Agreement::orderBy('id', 'asc')->get(),
				'type_regimen_ivas' => Type_regimen_iva::orderBy('name', 'asc')->get(),
				'provinces' => Province::orderBy('name', 'asc')->get()


			])
				->extends('layouts.theme.app')
				->section('content');

	}

	public function Store()
	{
		$rules  = [
			'name' => 'required|unique:thirds|min:3',
			'type_identificationid' => 'required|not_in:Elegir',			
			'identification' => 'required|unique:thirds|min:3',
			'officeid' => 'required',
			'agreementid' => 'required|not_in:Elegir',
			'type_regimen_ivaid' => 'required|not_in:Elegir',
			'direccion' => 'required',
			'provinceid' => 'required|not_in:Elegir',
			'celular' => 'required',
			'nombre_contacto' => 'required',
			'correo' => 'required|unique:thirds|email'
		];

		$messages = [
			'name.required' => 'Nombre del cliente o proveedor requerido',
			'name.unique' => 'Ya existe el nombre del cliente o proveedor',
			'name.min' => 'El nombre debe tener al menos 3 caracteres',
			'type_identificationid.not_in' => 'Selecciona el tipo de ID distinto a Elegir',
			'type_identificationid.required' => 'El tipo de ID es requerido',
			'identification.required' => 'La ID es requerido',
			'identification.unique' => 'La ID ya existe',
			'officeid.required' => 'El centro de costo es requerido',
			'agreementid.required' => 'El acuerdo es requerido',
			'agreementid.not_in' => 'Selecciona acuerdo distinto a Elegir',
			'type_regimen_ivaid.required' => 'El tipo de regimen es requerido',
			'direccion.required' => 'La dirección es requerida',
			'correo.required' => 'Ingresa el correo ',
		    'correo.email' => 'Ingresa un correo válido',
		    'correo.unique' => 'El email ya existe en sistema'	
			
		];

		$this->validate($rules, $messages);


		$third = Third::create([
			'name' => $this->name,
			'type_identification_id' => $this->type_identificationid,			
			'identification' => $this->identification,
			'digito_verificacion' => $this->digito_verificacion,
			'office_id' => $this->officeid,
			'agreement_id' => $this->agreementid,
			'type_regimen_iva_id' => $this->type_regimen_ivaid,
			'direccion' => $this->direccion,
			'province_id' => $this->provinceid,
			'celular' => $this->celular,
			'nombre_contacto' => $this->nombre_contacto,
			'correo' => $this->correo
			
		]);


			$third->save();
		

		$this->resetUI();
		$this->emit('third-added', 'Tercero Registrado');
	}


	public function Edit(Third $third)
	{		
		$this->selected_id = $third->id;
		$this->name = $third->name;
		$this->type_identificationid = $third->type_identification_id;
		$this->identification = $third->identification;
		$this->digito_verificacion = $third->digito_verificacion;
		$this->officeid = $third->office_id;
		$this->agreementid = $third->agreement_id;
		$this->type_regimen_ivaid = $third->type_regimen_iva_id;
		$this->direccion = $third->direccion;
		$this->provinceid = $third->province_id;
		$this->celular = $third->celular;
		$this->nombre_contacto = $third->nombre_contacto;
		$this->correo = $third->correo;

		$this->emit('show-modal', 'show modal!');
	}

	public function Update()
	{
		$rules  = [
			'name' => "required|min:3|unique:thirds,name,{$this->selected_id}",
			'type_identificationid' => 'required|not_in:Elegir',						
			'identification' => "required|min:3|unique:thirds,identification,{$this->selected_id}",
			'digito_verificacion' => 'required',
			'officeid' => 'required',
			'agreementid' => 'required|not_in:Elegir',
			'type_regimen_ivaid' => 'required|not_in:Elegir',
			'direccion' => 'required',
			'provinceid' => 'required|not_in:Elegir',
			'celular' => 'required',
			'nombre_contacto' => 'required',
			'correo' => "required|email|unique:thirds,correo,{$this->selected_id}"

		];

		$messages = [
			'name.required' => 'Nombre del cliente o proveedor requerido',
			'name.unique' => 'Ya existe el nombre del cliente o proveedor',
			'name.min' => 'El nombre debe tener al menos 3 caracteres',
			'type_identificationid.not_in' => 'Selecciona el tipo de ID distinto a Elegir',
			'type_identificationid.required' => 'El tipo de ID es requerido',
			'identification.required' => 'La ID es requerido',
			'identification.unique' => 'La ID ya existe',
			'digito_verificacion.required' => 'La digito verificacion es requerido',
			'officeid.required' => 'El centro de costo es requerido',
			'agreementid.required' => 'El acuerdo es requerido',
			'agreementid.not_in' => 'Selecciona acuerdo distinto a Elegir',
			'type_regimen_ivaid.required' => 'El tipo de regimen es requerido',
			'direccion.required' => 'La dirección es requerida',
			'correo.required' => 'Ingresa el correo ',
		    'correo.email' => 'Ingresa un correo válido',
		    'correo.unique' => 'El email ya existe en sistema'	
			
		];

		$this->validate($rules, $messages);

		$third = Third::find($this->selected_id);

		$third->update([
			'name' => $this->name,
			'type_identification_id' => $this->type_identificationid,			
			'identification' => $this->identification,
			'digito_verificacion' => $this->digito_verificacion,
			'office_id' => $this->officeid,
			'agreement_id' => $this->agreementid,
			'type_regimen_iva_id' => $this->type_regimen_ivaid,
			'direccion' => $this->direccion,
			'province_id' => $this->provinceid,
			'celular' => $this->celular,
			'nombre_contacto' => $this->nombre_contacto,
			'correo' => $this->correo		

		]);

		$this->resetUI();
		$this->emit('third-updated','Tercero Actualizado');
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

	protected $listeners = [
		'deleteRow' => 'Destroy'
	];




	public function Destroy(Third $third)
	{
		
		$third->delete();

		
		$this->resetUI();
		$this->emit('third-deleted', 'Tercero Eliminado');
	}
}
