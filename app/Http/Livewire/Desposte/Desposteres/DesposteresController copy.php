<?php

namespace App\Http\Livewire\Desposte\Desposteres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Despostere;
use App\Models\Beneficiore;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesposteresController extends Component
{
    public $beneficio_id;
    public $searchProduct;

    /************* */
    public $options = [
        ['id' => 1, 'text' => 'Option 1'],
        ['id' => 2, 'text' => 'Option 2'],
        ['id' => 3, 'text' => 'Option 3'],
        ['id' => 4, 'text' => 'Option 4'],
    ];
    public $selected = [];
    /************ */

    public function mount($id)
    {
        $this->beneficio_id = $id; 
    }

    public function render()
    {
        $desposters = Despostere::
        Where([
        ['beneficiores_id',$this->beneficio_id],
        ['status','VALID'], 
        ])->get();
        $beneficior = Beneficiore::Where('id',$this->beneficio_id)->get();
        $sumaTotal = Beneficiore::sum('pesopie');
        $findBeneficio = Beneficiore::find($this->beneficio_id);
        $pesoTotal = $findBeneficio->pesopie1 + $findBeneficio->pesopie2 + $findBeneficio->pesopie3;

        $prod = Product::all();
        //return view('livewire.desposte.desposteres.component');
        return view('livewire.desposte.desposteres.component',compact('desposters','beneficior','prod', 'sumaTotal','pesoTotal' ))
		->extends('layouts.theme.app')
		->section('content');
    }
    public function getProduct()
    {
        $searchProduct =  '%' . $this->searchProduct . '%';
        //dd($searchProduct);
        $prod = Product::where('name', 'like', $searchProduct)->ge();
        return $prod;
    }

    public function store(Request $request) {
        try {
            $rules = [
                'beneficioId' => 'required',
                'producto' => 'required',
                'pkilo' => 'required',
                'pventa' => 'required',
                'totalventa' => 'required',
                'porcventa' => 'required',
            ];
            $messages = [
                'beneficioId.required' => 'El beneficio es requerido',
                'producto.required' => 'El producto es requerido',
                'pkilo.required' => 'El peso kilo es requerido',
                'pventa.required' => 'El precio es requerido',
                'totalventa.required' => 'El total venta es requerido',
                'porcventa.required' => 'El porcentaje de venta es requerido',
            ];
                
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 500,
                    "message" => "Ocurrio un error",
                    "errores" => $validator->errors()->all(),
                ]);
            }

            $id_user= Auth::user()->id;
            //$sumaTotal = (float)Despostere::sum('totalventa');
            //$porcentajeVenta = ((float)$request->totalventa / $sumaTotal);
            //$sumakilosTotal = 0;//Despostere::sum('peso_acomulado');
            //$porcentajeDesposte = $request->pkilo / $sumakilosTotal;
            
            $beneficior = Despostere::Where('beneficiores_id',$request->beneficioId)->first();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;
            if ($beneficior === null) {
               $porcentajeVenta =  $request->totalventa / $request->totalventa;
                $porcentajeDesposte = $request->pkilo / $request->pkilo;
            }else {
                $sumaTotal = (float)Despostere::Where('beneficiores_id',$request->beneficioId)->sum('totalventa');
                $sumVentaAcoulada = $request->totalventa + $sumaTotal;
                $porcve = (float)number_format($request->totalventa / $sumVentaAcoulada,4);
                $porcentajeVenta = (float)number_format($porcve * 100,2);

                $sumakilosTotal = (float)Despostere::Where('beneficiores_id',$request->beneficioId)->sum('peso');
                $kilosAcomulados = (float)number_format($request->pkilo + $sumakilosTotal,2);
                $porc = (float)number_format($request->pkilo / $kilosAcomulados,4);
                $porcentajeDesposte = (float)number_format($porc * 100,2);

                //return response()->json([
                    //"status" => 500,
                    //"sumaTotal" => $sumaTotal,
                    //"porventa" => $porcentajeVenta,
                    //"pordespo" => $porcentajeDesposte,
                    //"message" => "Se agrego el registro correctamente"
                //]);
            }

            /*return response()->json([
                "status" => 500,
                "porventa" => $porcentajeVenta,
                "pordespo" => $porcentajeVenta,
                "message" => "Se agrego el registro correctamente"
            ]);*/

            if ($request->despostereId === "" || $request->despostereId === null) {
                $despost = new Despostere(); //Se crea una instancia del modelo
                $despost->users_id = $id_user; //Se establecen los valores para cada columna de la tabla
                $despost->beneficiores_id = $request->beneficioId;
                $despost->products_id = $request->producto;
                $despost->peso = $request->pkilo;
                $despost->porcdesposte = 0;
                $despost->costo = 0;
                $despost->precio = $request->pventa;
                $despost->totalventa = $request->totalventa;
                $despost->total = 0;
                $despost->porcventa = 0;
                $despost->porcutilidad = 0;
                $despost->status = 'VALID';
                $despost->save();
                return response()->json([
                    "status" => 201,
                    "message" => "Se agrego el registro correctamente"
                ]);
            }else{
                $despost = Despostere::firstWhere('id', $request->despostereId);
                $despost->users_id = $id_user; //Se establecen los valores para cada columna de la tabla
                $despost->beneficiores_id = $request->beneficioId;
                $despost->products_id = $request->producto;
                $despost->peso = $request->pkilo;
                //$despost->porcdesposte = $request->email;
                //$despost->costo = $request->email;
                $despost->precio = $request->pventa;
                $despost->totalventa = $request->totalventa;
                //$despost->total = $request->email;
                $despost->porcventa = $request->porcventa;
                //$despost->porcutilidad = $request->email;
                $despost->status = 'VALID';
                $despost->save();
                return response()->json([
                    "status" => 201,
                    "message" => "El registro se actulizo correctamente"
                ]);

            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => 500,
                "message" => $th
            ]);
        }
    }

    public function getdesposter($id)
    {
        $user = Despostere::where('id', $id)->first();
        return response()->json([
            "status" => 201,
            "data" => $user
        ]);
    }

    public function destroy($id)
    {
        $despost = Despostere::firstWhere('id', $id);
        $despost->status = 'CANCELED';
        $despost->save();
        return response()->json([
            "status" => 201,
            "message" => "El registro se dio de baja con exito"
        ]);

    }
}
