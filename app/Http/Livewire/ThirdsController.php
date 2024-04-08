<?php

namespace App\Http\Livewire;

use App\Models\Agreement;
use App\Models\Listaprecio;
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
   

	public $name, $type_identificationid, $identification, $digito_verificacion, $officeid, $porc_descuento, $type_regimen_ivaid, $direccion, $direccion1, $direccion2, $direccion3, $direccion4, $direccion5, $direccion6, $direccion7, $direccion8, $direccion9, $search, $provinceid, $celular, $nombre_contacto, $status, $is_client, $is_provider, $is_seller, $is_courier, $is_alistador, $correo, $selected_id, $listaprecio_genericId, $listaprecio_nichoId, $pageTitle, $componentName;
	
	private $pagination = 15;

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
		$this->porc_descuento = 0;
		$this->type_regimen_ivaid = 'Elegir';
		$this->provinceid = 'Elegir';
		$this->listaprecio_genericId = 1;
		$this->status = 1;
	}


	public function render()
	{
		if (strlen($this->search) > 0)
			$thirds = Third::join('type_identifications as t', 't.id', 'thirds.type_identification_id')
						   ->join('offices as o', 'o.id', 'thirds.office_id')				
				->select('thirds.*', 't.name as type_identification',
						 'thirds.*', 'o.name as office')
				->where('thirds.name', 'like', '%' . $this->search . '%')
				->orWhere('thirds.identification', 'like', '%' . $this->search . '%')
				->orWhere('thirds.office_id', 'like', '%' . $this->search . '%')				
				->orderBy('thirds.name', 'asc')
				->paginate($this->pagination);
		else

			$thirds = Third::join('type_identifications as t', 't.id', 'thirds.type_identification_id')
					 		->join('offices as o', 'o.id', 'thirds.office_id')						
				->select('thirds.*', 't.name as type_identification',
						 'thirds.*', 'o.name as office')
				->orderBy('thirds.name', 'asc')
				->paginate($this->pagination);



	    return view('livewire.thirds.component', ['data' => $thirds,
				'type_identifications' => Type_identification::orderBy('name', 'asc')->get(),
				'offices' => Office::orderBy('name', 'asc')->get(),
				'agreements' => Agreement::orderBy('id', 'asc')->get(),
				'type_regimen_ivas' => Type_regimen_iva::orderBy('name', 'asc')->get(),
				'provinces' => Province::orderBy('name', 'asc')->get(),
				'listapreciosG' => Listaprecio::orderBy('tipo', 'asc')->get(),
				'listapreciosN' => Listaprecio::where('tipo', 'NICHO')->orderBy('nombre', 'asc')->get(),


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
			'porc_descuento.not_in' => 'Selecciona acuerdo distinto a Elegir',
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
			'type_regimen_iva_id' => $this->type_regimen_ivaid,
			'direccion' => $this->direccion,
			'direccion1' => $this->direccion1,
			'direccion2' => $this->direccion2,			
			'direccion3' => $this->direccion3,
			'direccion4' => $this->direccion4,
			'direccion5' => $this->direccion5,
			'direccion6' => $this->direccion6,
			'direccion7' => $this->direccion7,
			'direccion8' => $this->direccion8,
			'direccion9' => $this->direccion9,		
			'province_id' => $this->provinceid,
			'celular' => $this->celular,
			'nombre_contacto' => $this->nombre_contacto,
			'correo' => $this->correo,
			'cliente' => $this->is_client,
			'porc_descuento' => $this->porc_descuento,
			'proveedor' => $this->is_provider,
			'vendedor' => $this->is_seller,
			'domiciliario' => $this->is_courier,
			'alistador' => $this->is_alistador,
			'listaprecio_nichoid' => $this->listaprecio_nichoId,			
			'listaprecio_genericid' => $this->listaprecio_genericId
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
		$this->type_regimen_ivaid = $third->type_regimen_iva_id;
		$this->direccion = $third->direccion;
		$this->direccion1 = $third->direccion1;
		$this->direccion2 = $third->direccion2;
		$this->direccion3 = $third->direccion3;
		$this->direccion4 = $third->direccion4;
		$this->direccion5 = $third->direccion5;
		$this->direccion6 = $third->direccion6;
		$this->direccion7 = $third->direccion7;
		$this->direccion8 = $third->direccion8;
		$this->direccion9 = $third->direccion9;
		$this->provinceid = $third->province_id;
		$this->celular = $third->celular;
		$this->nombre_contacto = $third->nombre_contacto;
		$this->correo = $third->correo;
		$this->porc_descuento = $third->porc_descuento;
		$this->is_client = $third->cliente;
		$this->is_provider = $third->proveedor;
		$this->is_seller = $third->vendedor;
		$this->is_courier = $third->domiciliario;
		$this->is_alistador = $third->alistador;
		$this->listaprecio_nichoId = $third->listaprecio_nichoid;
		$this->listaprecio_genericId = $third->listaprecio_genericid;
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
			'porc_descuento.not_in' => 'Selecciona acuerdo distinto a Elegir',
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
			'type_regimen_iva_id' => $this->type_regimen_ivaid,
			'direccion' => $this->direccion,
			'direccion1' => $this->direccion1,
			'direccion2' => $this->direccion2,
			'direccion3' => $this->direccion3,
			'direccion4' => $this->direccion4,
			'direccion5' => $this->direccion5,
			'direccion6' => $this->direccion6,
			'direccion7' => $this->direccion7,
			'direccion8' => $this->direccion8,
			'direccion9' => $this->direccion9,			
			'province_id' => $this->provinceid,
			'celular' => $this->celular,
			'nombre_contacto' => $this->nombre_contacto,
			'correo' => $this->correo,
			'porc_descuento' => $this->porc_descuento,
			'cliente' => $this->is_client,
			'proveedor' => $this->is_provider,
			'vendedor' => $this->is_seller,
			'domiciliario' => $this->is_courier,
			'alistador' => $this->is_alistador,
			'listaprecio_nichoid' => $this->listaprecio_nichoId,
			'listaprecio_genericid' => $this->listaprecio_genericId			
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
		$this->type_regimen_ivaid = 'Elegir';
		$this->direccion = '';
		$this->direccion1 = '';
		$this->direccion2 = '';
		$this->direccion3 = '';
		$this->direccion4 = '';
		$this->direccion5 = '';
		$this->direccion6 = '';
		$this->direccion7 = '';
		$this->direccion8 = '';
		$this->direccion9 = '';
		$this->provinceid = 'Elegir';
		$this->celular = '';
		$this->nombre_contacto = '';
		$this->correo = '';
		$this->porc_descuento = '';
		$this->search = '';		
		$this->selected_id = 0;
		$this->is_client = '';
		$this->is_provider = '';
		$this->is_seller = '';
		$this->is_courier = '';
		$this->is_alistador = '';
		$this->listaprecio_nichoId = 'Elegir';
		$this->listaprecio_genericId = 'Elegir';
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
