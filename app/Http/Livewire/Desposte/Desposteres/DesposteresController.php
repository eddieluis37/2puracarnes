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
        $proveedor = DB::table('beneficiores as b')
            ->join('thirds as t', 'b.thirds_id', '=', 't.id')
            ->select('t.name')
            ->where('b.id',$this->beneficio_id)
            ->get();
        //$sumaTotal = Beneficiore::sum('pesopie');
        //$findBeneficio = Beneficiore::find($this->beneficio_id);
        //$pesoTotal = $findBeneficio->pesopie1 + $findBeneficio->pesopie2 + $findBeneficio->pesopie3;

        $prod = Product::all();
        /*********************** */
        $TotalDesposte = (float)Despostere::Where([['beneficiores_id',$this->beneficio_id],['status','VALID']])->sum('porcdesposte');
        $TotalVenta = (float)Despostere::Where([['beneficiores_id',$this->beneficio_id],['status','VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostere::Where([['beneficiores_id',$this->beneficio_id],['status','VALID']])->sum('porcventa');
        $pesoTotalGlobal = (float)Despostere::Where([['beneficiores_id',$this->beneficio_id],['status','VALID']])->sum('peso');
        //return view('livewire.desposte.desposteres.component');
        return view('livewire.desposte.desposteres.component',compact(
            'desposters','beneficior','prod','TotalDesposte','TotalVenta','porcVentaTotal','pesoTotalGlobal','proveedor'
        ))
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
                //'porcventa' => 'required',
            ];
            $messages = [
                'beneficioId.required' => 'El beneficio es requerido',
                'producto.required' => 'El producto es requerido',
                'pkilo.required' => 'El peso kilo es requerido',
                'pventa.required' => 'El precio es requerido',
                'totalventa.required' => 'El total venta es requerido',
                //'porcventa.required' => 'El porcentaje de venta es requerido',
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
            DB::beginTransaction();
            /*if ($beneficior === null) {
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
            }*/

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
                /*return response()->json([
                    "status" => 201,
                    "message" => "Se agrego el registro correctamente"
                ]);*/
            }else{
                $despost = Despostere::firstWhere('id', $request->despostereId);
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
                /*return response()->json([
                    "status" => 201,
                    "message" => "El registro se actulizo correctamente"
                ]);*/
            }

            $getTotalcosto = Beneficiore::Where('id',$request->beneficioId)->get();

            $beneficior = Despostere::Where([['beneficiores_id',$request->beneficioId],['status','VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;
            foreach ($beneficior as $key) {
                $sumakilosTotal = (float)Despostere::Where([['beneficiores_id',$request->beneficioId],['status','VALID']])->sum('peso');
                $porc = (float)number_format($key->peso / $sumakilosTotal,4);
                $porcentajeDesposte = (float)number_format($porc * 100,2);

                $sumaTotal = (float)Despostere::Where([['beneficiores_id',$request->beneficioId],['status','VALID']])->sum('totalventa');
                $porcve = (float)number_format($key->totalventa / $sumaTotal,4);
                $porcentajeVenta = (float)number_format($porcve * 100,2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);
                $costoTotal = $porcentajecostoTotal * $getTotalcosto[0]->totalcostos;

                $updatedespost = Despostere::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costoTotal;
                $updatedespost->save();
            }								
            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Se agrego el registro correctamente",
                //"data" => $beneficior,
                //"totalcosto" => $getTotalcosto[0]->totalcostos,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "status" => 500,
                "message" => (array) $th
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

    public function destroy($id,$beneficioId)
    {
        try {
            
            DB::beginTransaction();
            $despost = Despostere::firstWhere('id', $id);
            $despost->status = 'CANCELED';
            $despost->save();
            /************************************ */
            $getTotalcosto = Beneficiore::Where('id',$beneficioId)->get();

            $beneficior = Despostere::Where([['beneficiores_id',$beneficioId],['status','VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;
            foreach ($beneficior as $key) {
                $sumakilosTotal = (float)Despostere::Where([['beneficiores_id',$beneficioId],['status','VALID']])->sum('peso');
                $porc = (float)number_format($key->peso / $sumakilosTotal,4);
                $porcentajeDesposte = (float)number_format($porc * 100,2);

                $sumaTotal = (float)Despostere::Where([['beneficiores_id',$beneficioId],['status','VALID']])->sum('totalventa');
                $porcve = (float)number_format($key->totalventa / $sumaTotal,4);
                $porcentajeVenta = (float)number_format($porcve * 100,2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);
                $costoTotal = $porcentajecostoTotal * $getTotalcosto[0]->totalcostos;

                $updatedespost = Despostere::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costoTotal;
                $updatedespost->save();
            }								
            /******************************************* */
            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "El registro se dio de baja con exito",
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "status" => 500,
                "message" => (array) $th
            ]);
        }

    }
}
