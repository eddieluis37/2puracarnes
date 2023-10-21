<?php

namespace App\Http\Livewire;


use App\Http\Livewire\Scaner;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Traits\CartTrait;
use App\Models\Products\Meatcut;

class ProductsController extends Component
{

	use WithPagination;
	use WithFileUploads;
	use CartTrait;


	public function ScanCode($code)
	{
		$this->ScanearCode($code);
		$this->emit('global-msg', "SE AGREGÓ EL PRODUCTO AL CARRITO");
	}

	public $name, $code, $barcode, $cost, $price_fama, $price_insti, $price_horeca, $price_hogar, $stock, $alerts, $categoryid, $meatcutid, $search, $image, $selected_id, $pageTitle, $componentName;

	private $pagination = 10;


	public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}


	public function mount()
	{
		$this->pageTitle = 'Listado';
		$this->componentName = 'Productos';
		$this->categoryid = 'Elegir';
		$this->meatcutid = 'Elegir';

		$this->dispatchBrowserEvent('refreshSelect2');
	}



	public function render()
	{
		if (strlen($this->search) > 0) {
			$products = Product::join('categories as c', 'c.id', 'products.category_id')
				->select('products.*', 'c.name as category')
				->where('products.name', 'like', '%' . $this->search . '%')
				->orWhere('products.code', 'like', '%' . $this->search . '%')
				->orWhere('products.barcode', 'like', '%' . $this->search . '%')
				->orWhere('c.name', 'like', '%' . $this->search . '%')
				->orderBy('products.name', 'asc')
				->paginate($this->pagination);
		} else {
			$products = Product::join('categories as c', 'c.id', 'products.category_id')
				->leftJoin('precio_agreements as pa', 'pa.id', 'products.id')
				->select('products.*', 'c.name as category', 'products.price_fama as price_fama')
				->where('products.price_fama', '>', 0)
				->orderBy('products.id', 'asc')
				->paginate($this->pagination);
		}

		return view('livewire.products.component', [
			'data' => $products,
			'categories' => Category::orderBy('name', 'asc')->get(),
			'cortes' => Meatcut::where('status', 1)->orderBy('name', 'asc')->get()
		])
			->extends('layouts.theme.app')
			->section('content');
	}

	public function Store()
	{
		$rules  = [
			'name' => 'required|unique:products|min:3',
			'cost' => 'required',
			'price_fama' => 'required',
			'stock' => 'required',
			'alerts' => 'required',
			'categoryid' => 'required|not_in:Elegir',
			'meatcutid' => 'required|not_in:Elegir'
		];

		$messages = [
			'name.required' => 'Nombre del producto requerido',
			'name.unique' => 'Ya existe el nombre del producto',
			'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
			'cost.required' => 'El costo es requerido',
			'price_fama.required' => 'El precio es requerido',
			'stock.required' => 'El stock es requerido',
			'alerts.required' => 'Ingresa el valor mínimo en existencias',
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
			'meatcutid.not_in' => 'Elige un nombre de corte de carne diferente de Elegir',
		];

		$this->validate($rules, $messages);


		$product = Product::create([
			'name' => $this->name,
			'code' => $this->code,
			'cost' => $this->cost,
			'price_fama' => $this->price_fama,
			'price_insti' => $this->price_insti,
			'price_horeca' => $this->price_horeca,
			'price_hogar' => $this->price_hogar,
			'barcode' => $this->barcode,
			'stock' => $this->stock,
			'alerts' => $this->alerts,
			'category_id' => $this->categoryid,
			'meatcut_id' => $this->meatcutid
		]);

		if ($this->image) {
			$customFileName = uniqid() . '_.' . $this->image->extension();
			$this->image->storeAs('public/products', $customFileName);
			$product->image = $customFileName;
			$product->save();
		}

		$this->resetUI();
		$this->emit('product-added', 'Producto Registrado');
	}


	public function Edit(Product $product)
	{
		$this->selected_id = $product->id;
		$this->name = $product->name;
		$this->code = $product->code;
		$this->barcode = $product->barcode;
		$this->cost = $product->cost;
		$this->price_fama = $product->price_fama;
		$this->price_insti = $product->price_insti;
		$this->price_horeca = $product->price_horeca;
		$this->price_hogar = $product->price_hogar;
		$this->stock = $product->stock;
		$this->alerts = $product->alerts;
		$this->categoryid = $product->category_id;
		$this->meatcutid = $product->meatcut_id;
		$this->image = null;

		$this->emit('modal-show', 'Show modal');
	}

	public function Update()
	{
		$rules  = [
			'name' => "required|min:3|unique:products,name,{$this->selected_id}",
			'cost' => 'required',
			'price_fama' => 'required',
			'stock' => 'required',
			'alerts' => 'required',
			'categoryid' => 'required|not_in:Elegir',
			'meatcutid' => 'required|not_in:Elegir'
		];

		$messages = [
			'name.required' => 'Nombre del producto requerido',
			'name.unique' => 'Ya existe el nombre del producto',
			'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
			'cost.required' => 'El costo es requerido',
			'price_fama.required' => 'El precio es requerido',
			'stock.required' => 'El stock es requerido',
			'alerts.required' => 'Ingresa el valor mínimo en existencias',
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
			'meatcutid.not_in' => 'Elige un nombre de corte de carne diferente de Elegir',
		];

		$this->validate($rules, $messages);

		$product = Product::find($this->selected_id);

		$product->update([
			'name' => $this->name,
			'code' => $this->code,
			'cost' => $this->cost,
			'price_fama' => $this->price_fama,
			'price_insti' => $this->price_insti,
			'price_horeca' => $this->price_horeca,
			'price_hogar' => $this->price_hogar,
			'barcode' => $this->barcode,
			'stock' => $this->stock,
			'alerts' => $this->alerts,
			'category_id' => $this->categoryid,
			'meatcut_id' => $this->meatcutid
		]);

		if ($this->image) {
			$customFileName = uniqid() . '_.' . $this->image->extension();
			$this->image->storeAs('public/products', $customFileName);
			$imageTemp = $product->image; // imagen temporal
			$product->image = $customFileName;
			$product->save();

			if ($imageTemp != null) {
				if (file_exists('storage/products/' . $imageTemp)) {
					unlink('storage/products/' . $imageTemp);
				}
			}
		}

		$this->resetUI();
		$this->emit('product-updated', 'Producto Actualizado');
	}


	public function resetUI()
	{
		$this->name = '';
		$this->code = '';
		$this->barcode = '';
		$this->cost = '';
		$this->price_fama = '';
		$this->price_insti = '';
		$this->price_horeca = '';
		$this->price_hogar = '';
		$this->stock = '';
		$this->alerts = '';
		$this->search = '';
		$this->categoryid = 'Elegir';
		$this->meatcutid = 'Elegir';
		$this->image = null;
		$this->selected_id = 0;
		$this->resetValidation();
	}

	protected $listeners = [
		'refreshSelect2',
		'deleteRow' => 'Destroy'
	];

	public function refreshSelect2()
	{
		$this->dispatchBrowserEvent('refreshSelect2');
	}

	public function updatedMeatcutid()
	{
		$this->emit('refreshSelect2');
	}

	public function Destroy(Product $product)
	{
		$imageTemp = $product->image;
		$product->delete();

		if ($imageTemp != null) {
			if (file_exists('storage/products/' . $imageTemp)) {
				unlink('storage/products/' . $imageTemp);
			}
		}

		$this->resetUI();
		$this->emit('product-deleted', 'Producto Eliminado');
	}
}
