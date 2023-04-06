<?php

namespace App\Http\Livewire;

use App\Models\Beneficiore;
use App\Models\Despostere;
use App\Models\Sacrificio;
use App\Models\Third;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;



class DesposterController extends Component
{
    
    use WithPagination;

    public $data1, $search, $selected_id, $pageTitle, $componentName, $name;

    public User $user;

    
    private $pagination = 5;


    public function mount()
    {
        $this->data1 =[];
        $this->pageTitle = 'Listado';
        $this->componentName = 'Desposte de Res';
        $this->pageTitle = 'Listado';
        $this->componentName = 'Beneficio Res';
    //  $this->thirdsid = 'Elegir';
        $this->plantasacrificioid = 'Elegir';   
        $this->clientpielesid = 'Elegir';
        $this->clientviscerasid = 'Elegir';     
        $this->status = 1;
    }



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

            $Desposteres = Despostere::join('users as t', 't.id', 'Desposteres.users_id')
                                       ->join('beneficiores as s', 's.id', 'Desposteres.beneficiores_id')
                                     
                ->select('Desposteres.*', 't.name as user',
                         'Desposteres.*', 's.id as beneficior',
                                                                        )

                ->orderBy('Desposteres.id', 'desc')
                ->paginate($this->pagination);



        return view('livewire.Desposter.component', ['data' => $Desposteres,
                'users' => User::orderBy('name', 'asc')->get(),
                'beneficior' => Beneficiore::orderBy('fecha_beneficio', 'asc')->get(),             
                

            ])
                ->extends('layouts.theme.app')
                ->section('content');


    }



    public function storem(Request $request)
    {
      
        $beneficior = Beneficiore::Where('id',$request->id)->get();
        $ftregs = Fichatecnicad::Where('fichatecnica_id',$request->fichatecnica_id)->get(); 
        
        $dp=Desposter::Where('beneficior_id',$request->id)->delete();   

        $sumtotal = 0;
        foreach ($ftregs as $ftreg) {
            $p_user_id = Auth::user()->id;
            $p_beneficior_id = $beneficior[0]->id;           
            $p_fichatecnica_id = $ftreg->id;
            $p_product_id = $ftreg->product_id;
            //$p_peso = ($ftreg->porcdesposte * $beneficior[0]->canalplanta)/100;
            $p_peso = 0;
            //$p_porcdesposte = $ftreg->porcdesposte;
            $p_porcdesposte = 0;     
            $p_costo = 0;      
            $p_precio = $ftreg->product->sell_price;
            $p_total = $p_precio * $p_peso;
            $p_porcventa = 0;            
            $p_porcutilidad = 0;
                  
            $desposter = Desposter::create($request->all()+[
                "user_id" => $p_user_id,
                "beneficior_id" => $p_beneficior_id,
                "fichatecnica_id" => $p_fichatecnica_id,
                "product_id" => $p_product_id,
                "peso" => $p_peso,
                "porcdesposte" => $p_porcdesposte,
                "costo" => $p_costo,
                "precio" => $p_precio,
                "total" => $p_total,
                "porcventa" => $p_porcventa,
                "porcutilidad" => $p_porcutilidad,  
            ]);
            $sumtotal = $sumtotal + $p_total;   
        }
        $p_pesoinicial = $beneficior[0]->canalcaliente * ($beneficior[0]->costokilo);
        
       $desposters = Desposter::Where('beneficior_id',$request->id)->get();       
       $fichatecnicas =  Fichatecnica::get();     
       return view('admin.desposter.indexdm',compact('desposters','fichatecnicas','beneficior'));     
    }
	
	
}
