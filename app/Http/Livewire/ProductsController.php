<?php

namespace App\Http\Livewire;


use App\Http\Livewire\Scaner;
use App\Models\Category;
use App\Models\Centro_costo_product;
use App\Models\Levels_products;
use App\Models\Listaprecio;
use App\Models\Listapreciodetalle;
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

	public $name, $code, $barcode, $iva, $otro_impuesto, $price_fama, $levelproductid, $alerts, $categoryid, $centrocosto_id, $products_id, $meatcutid, $search, $image, $selected_id, $pageTitle, $componentName;

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
		$this->levelproductid = 'Elegir';

		$this->dispatchBrowserEvent('refreshSelect2');
	}



	public function render()
	{
		if (strlen($this->search) > 0) {
			$products = Product::join('categories as c', 'c.id', 'products.category_id')
				->join('meatcuts as m', 'm.id', 'products.meatcut_id')
				->select('products.*', 'c.name as category', 'm.name as meacuty')
				->where('products.name', 'like', '%' . $this->search . '%')
				->orWhere('products.code', 'like', '%' . $this->search . '%')
				->orWhere('products.barcode', 'like', '%' . $this->search . '%')
				->orWhere('c.name', 'like', '%' . $this->search . '%')
				->orderBy('products.name', 'asc')
				->paginate($this->pagination);
		} else {
			$products = Product::join('categories as c', 'c.id', 'products.category_id')
				->leftJoin('precio_agreements as pa', 'pa.id', 'products.id')
				->join('meatcuts as m', 'm.id', 'products.meatcut_id')
				->select('products.*', 'c.name as category', 'pa.precio as price_fama', 'm.name as meacuty')
				->where('products.price_fama', '>', 0)
				->orderBy('products.id', 'asc')
				->paginate($this->pagination);
		}

		return view('livewire.products.component', [
			'data' => $products,
			'categories' => Category::orderBy('name', 'asc')->get(),
			'cortes' => Meatcut::where('status', 1)->orderBy('name', 'asc')->get(),
			'niveles' => Levels_products::orderBy('name', 'ASC')->get(),
		])
			->extends('layouts.theme.app')
			->section('content');
	}

	public function Store()
	{
		$rules  = [
			'categoryid' => 'required|not_in:Elegir',
			'meatcutid' => 'required|not_in:Elegir',
			'name' => 'required|unique:products|min:3',
			'levelproductid' => 'required|not_in:Elegir',
			'code' => 'required',
			'price_fama' => 'required',
			'alerts' => 'required',

		];

		$messages = [
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
			'meatcutid.not_in' => 'Elige un nombre de corte de carne diferente de Elegir',
			'name.required' => 'Nombre del producto requerido',
			'levelproductid.not_in' => 'Elige nivel diferente de Elegir',
			'name.unique' => 'Ya existe el nombre del producto',
			'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
			'code.required' => 'El codigo es requerido',
			'price_fama.required' => 'El precio mínimo es requerido',
			'iva.required' => 'El I es requerido',
			'alerts.required' => 'Ingresa el valor mínimo en existencias',

		];

		$this->validate($rules, $messages);


		$product = Product::create([
			'category_id' => $this->categoryid,
			'meatcut_id' => $this->meatcutid,
			'name' => $this->name,
			'level_product_id' => $this->levelproductid,
			'code' => $this->code,
			'barcode' => $this->barcode,
			'price_fama' => $this->price_fama,
			'iva' => $this->iva,
			'otro_impuesto' => $this->otro_impuesto,
			'alerts' => $this->alerts,
		]);

		if ($this->image) {
			$customFileName = uniqid() . '_.' . $this->image->extension();
			$this->image->storeAs('public/products', $customFileName);
			$product->image = $customFileName;
			$product->save();
		}

		$this->resetUI();
		$this->emit('product-added', 'Producto Registrado');
		$this->CrearProductoEnCentroCosto();
		$this->CrearProductoEnListapreciodetalle();
	}


	public function CrearProductoEnCentroCosto()
	{
		$ultimoId = Product::latest('id')->first()->id;

		$centrocostoproduct = Centro_costo_product::create([
			'centrocosto_id' => 1,
			'products_id' => $ultimoId,
			'tipoinventario' => 'inicial',
		]);

		$centrocostoproduct->save();
	}

	public function CrearProductoEnListapreciodetalle()
	{
		$ultimoId = Product::latest('id')->first()->id;
		$listaprecios = Listaprecio::all();
		foreach ($listaprecios as $listaprecio) {
			$listapreciodetalle = Listapreciodetalle::create([
				'listaprecio_id' => $listaprecio->id,
				'product_id' => $ultimoId,
			]);
			$listapreciodetalle->save();
		}
	}

	public function Edit(Product $product)
	{
		$this->selected_id = $product->id;
		$this->name = $product->name;
		$this->levelproductid = $product->level_product_id;
		$this->code = $product->code;
		$this->barcode = $product->barcode;
		$this->iva = $product->iva;
		$this->otro_impuesto = $product->otro_impuesto;
		$this->price_fama = $product->price_fama;
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
			'levelproductid' => 'required|not_in:Elegir',
			'iva' => 'required',
			'price_fama' => 'required',
			'alerts' => 'required',
			'categoryid' => 'required|not_in:Elegir',
			'meatcutid' => 'required|not_in:Elegir'
		];

		$messages = [
			'name.required' => 'Nombre del producto requerido',
			'name.unique' => 'Ya existe el nombre del producto',
			'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
			'levelproductid.not_in' => 'Elige nivel diferente de Elegir',
			'iva.required' => 'El iva es requerido',
			'price_fama.required' => 'El precio es requerido',
			'alerts.required' => 'Ingresa el valor mínimo en existencias',
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
			'meatcutid.not_in' => 'Elige un nombre de corte de carne diferente de Elegir',
		];

		$this->validate($rules, $messages);

		$product = Product::find($this->selected_id);

		$product->update([
			'name' => $this->name,
			'level_product_id' => $this->levelproductid,
			'code' => $this->code,
			'iva' => $this->iva,
			'otro_impuesto' => $this->otro_impuesto,
			'price_fama' => $this->price_fama,
			'barcode' => $this->barcode,
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
		$this->levelproductid = 'Elegir';
		$this->code = '';
		$this->barcode = '';
		$this->iva = '';
		$this->otro_impuesto = '';
		$this->price_fama = '';
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
