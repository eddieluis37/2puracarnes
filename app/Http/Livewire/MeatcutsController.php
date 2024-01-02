<?php

namespace App\Http\Livewire;


use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Traits\CartTrait;
use App\Models\Products\Meatcut;
use App\Models\Category;




class MeatcutsController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $categoryid, $description, $status, $search, $selected_id, $pageTitle, $componentName;

	private $pagination = 10;


   
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
	{
		$this->pageTitle = 'Listado';
		$this->componentName = 'Cortes';
		$this->categoryid = 'Elegir';		
	}

    
	public function render()
	{
		if (strlen($this->search) > 0) {
			$meatcuts = Meatcut::join('categories as c', 'c.id', 'meatcuts.category_id')
				->select('meatcuts.*', 'c.name as category')
				->where('meatcuts.name', 'like', '%' . $this->search . '%')
				->orWhere('meatcuts.description', 'like', '%' . $this->search . '%')			
				->orderBy('meatcuts.name', 'asc')
				->paginate($this->pagination);
		} else {
			$meatcuts = Meatcut::join('categories as c', 'c.id', 'meatcuts.category_id')				
				->select('meatcuts.*', 'c.name as category')
				->where('meatcuts.id', '>', 0)
				->orderBy('meatcuts.id', 'asc')
				->paginate($this->pagination);
		}

		return view('livewire.meatcuts.component', ['data' => $meatcuts,
			'categories' => Category::orderBy('name', 'asc')->get(),			
		])
			->extends('layouts.theme.app');
			
	}

	public function Store()
	{
		$rules  = [
			'name' => 'required|unique:meatcuts|min:3',
			
			'categoryid' => 'required|not_in:Elegir',
			
		];

		$messages = [
			'name.required' => 'Nombre del corte es requerido',			
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
			
		];

		$this->validate($rules, $messages);


		$meatcut = Meatcut::create([
			'name' => $this->name,			
			'category_id' => $this->categoryid,
			
		]);
		

		$this->resetUI();
		$this->emit('meatcut-added', 'Corte Registrado');
	}

	public function resetUI()
	{
		$this->name = '';
		
		$this->categoryid = 'Elegir';		
		$this->selected_id = 0;
		$this->resetValidation();
	}

	protected $listeners = [
		'deleteRow' => 'Destroy'
	];

	public function Edit(Meatcut $meatcut)
	{
		$this->selected_id = $meatcut->id;
		$this->name = $meatcut->name;		
		$this->categoryid = $meatcut->category_id;
		

		$this->emit('modal-show', 'Show modal');
	}

	public function Update()
	{
		$rules  = [
			'name' => "required|min:3|unique:meatcuts,name,{$this->selected_id}",			
			'categoryid' => 'required|not_in:Elegir',
			
		];

		$messages = [
			'name.required' => 'Nombre del corte requerido',
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
		
		];

		$this->validate($rules, $messages);

		$meatcut = Meatcut::find($this->selected_id);

		$meatcut->update([
			'name' => $this->name,			
			'category_id' => $this->categoryid,
			
		]);		
		
		$this->resetUI();
		$this->emit('meatcut-updated', 'Corte Actualizado');
	}





}
