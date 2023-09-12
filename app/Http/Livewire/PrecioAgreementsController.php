<?php

namespace App\Http\Livewire;

use App\Models\Agreement;
use App\Models\Precio;
use App\Models\Precio_agreement;
use App\Models\Product;
use App\Models\Third;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PrecioAgreementsController extends Component
{
	use WithFileUploads;
	use WithPagination;


	public $line, $agreementid, $agreement_id, $productid, $product_id, $precio, $vendedor,  $descuento, $valorfinal, $search, $selected_id, $pageTitle, $componentName;

	private $pagination = 5;



	public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}


	public function mount()
	{

		$this->pageTitle = 'Listado';
		$this->componentName = 'Precios Acuerdos';
		$this->agreementid = 'Elegir';
		$this->productid = 'Elegir';
		$this->vendedor = 'Elegir';
		$this->descuento = '0';
		$this->valorfinal = '0';
	}


	public function render()
	{
		if (strlen($this->search) > 0)
			$precio_agreements = Precio_agreement::join('agreements as a', 'a.id', 'precio_agreements.agreement_id')

				->join('offices as o', 'o.id', 'precio_agreements.office_id')

				->select(
					'precio_agreements.*',
					't.name as type_identification',
					'precio_agreements.*',
					'o.name as office',
					'precio_agreements.*',
					'a.name as agreement'
				)
				->where('precio_agreements.name', 'like', '%' . $this->search . '%')
				->orWhere('precio_agreements.identification', 'like', '%' . $this->search . '%')
				->orWhere('precio_agreements.office_id', 'like', '%' . $this->search . '%')
				->orderBy('precio_agreements.name', 'asc')
				->paginate($this->pagination);
		else

			$precio_agreements = Precio_agreement::join('agreements as a', 'a.id', 'precio_agreements.agreement_id')

				->leftJoin('users as u', 'u.id', 'precio_agreements.user_id')
				->join('products as prod', 'prod.id', 'precio_agreements.product_id')
				->select(
					'precio_agreements.*',
					'a.name as agreement',
					'precio_agreements.*',
					'u.name as user',
					'precio_agreements.*',
					'prod.name as product'
				)

				->orderBy('precio_agreements.id', 'desc')
				->paginate($this->pagination);



		return view('livewire.precio_agreements.component', [
			'data' => $precio_agreements,
			'agreements' => Agreement::orderBy('id', 'asc')->get(),
			'users' => User::orderBy('name', 'asc')->get(),
			'products' => Product::orderBy('name', 'asc')->get()


		])
			->extends('layouts.theme.app')
			->section('content');
	}

	public function Store()
	{
		$rules  = [
			'line' => 'required|not_in:Elegir',
			'agreementid' => 'required|not_in:Elegir|unique:precio_agreements,agreement_id,' . $this->id . ',id,product_id,' . $this->productid,
			'productid' => 'required|not_in:Elegir|unique:precio_agreements,product_id,' . $this->id . ',id,agreement_id,' . $this->agreementid,
			'precio' => 'required',
			'vendedor' => 'required|not_in:Elegir',


		];

		$messages = [
			'line.not_in' => 'Selecciona la linea distinto a Elegir',
			'line.required' => 'La linea es requerida',
			'agreementid.not_in' => 'Selecciona el acuerdo distinto a Elegir',
			'agreementid.required' => 'El tipo de acuerdo es requerido',
			'agreementid.unique' => 'El acuerdo ya tiene ese producto',

			'productid.not_in' => 'Selecciona el producto distinto a Elegir',
			'productid.required' => 'El producto es requerido',
			'productid.unique' => 'El producto ya tiene ese acuerdo',

			'precio.required' => 'El precio es requerido',
			'vendedor.required' => 'El vendedor es requerido',
			'vendedor.not_in' => 'Selecciona el vendedor distinto a Elegir'

		];

		$this->validate($rules, $messages);


		$precio_agreement = Precio_agreement::create([
			'line' => $this->line,
			'agreement_id' => $this->agreementid,
			'product_id' => $this->productid,
			'precio' => $this->precio,
			'user_id' => $this->vendedor,
			'vendedor' => $this->vendedor,
			'descuento' => $this->descuento,
			'valorfinal' => $this->valorfinal

		]);


		$precio_agreement->save();


		$this->resetUI();
		$this->emit('precio_agreement-added', 'Acuerdo Registrado');
	}

	public function Edit(Precio_agreement $precio_agreement)
	{
		$this->agreement_id  = $precio_agreement->id;
		$this->line = $precio_agreement->line;
		$this->productid = $precio_agreement->product_id;
		$this->precio = $precio_agreement->precio;
		$this->vendedor = $precio_agreement->user_id;
		$this->descuento = $precio_agreement->descuento;
		$this->valorfinal = $precio_agreement->valorfinal;
		$this->emit('modal-show', 'Show modal');
	}

	public function Update()
	{
		$rules  = [
			'line' => 'required|not_in:Elegir',
			'agreement_id ' => 'required|not_in:Elegir|unique:precio_agreements,agreement_id,' . $this->agreementid . ',id,product_id,' . $this->productid,
			'productid' => 'required|not_in:Elegir|unique:precio_agreements,product_id,' . $this->productid . ',id,agreement_id,' . $this->agreementid,
			'precio' => 'required',
			'vendedor' => 'required|not_in:Elegir',
		];
		$messages = [
			'line.not_in' => 'Selecciona la línea distinta a Elegir',
			'line.required' => 'La línea es requerida',
			'agreement_id.not_in' => 'Selecciona el acuerdo distinto a Elegir',
			'agreement_id.required' => 'El tipo de acuerdo es requerido',
			'agreement_id.unique' => 'El acuerdo ya tiene ese producto',
			'productid.not_in' => 'Selecciona el producto distinto a Elegir',
			'productid.required' => 'El producto es requerido',
			'productid.unique' => 'El producto ya tiene ese acuerdo',
			'precio.required' => 'El precio es requerido',
			'vendedor.required' => 'El vendedor es requerido',
			'vendedor.not_in' => 'Selecciona el vendedor distinto a Elegir'
		];
		$this->validate($rules, $messages);
		$precio_agreement = Precio_agreement::find($this->agreement_id);
		$precio_agreement->update([
			'line' => $this->line,
			'agreement_id' => $this->agreement_id,
			'product_id' => $this->productid,
			'precio' => $this->precio,
			'user_id' => $this->vendedor,
			'vendedor' => $this->vendedor,
			'descuento' => $this->descuento,
			'valorfinal' => $this->valorfinal
		]);
		$this->resetUI();
		$this->emit('precio_agreement-updated', 'Acuerdo Actualizado');
	}


	public function resetUI()
	{
		$this->line = 'Elegir';
		$this->agreementid = 'Elegir';
		$this->productid = 'Elegir';
		$this->precio = '';
		$this->vendedor = 'Elegir';
		$this->descuento = '0';
		$this->valorfinal = '0';
		$this->search = '';
		$this->selected_id = 0;
		$this->resetValidation();
	}
}
