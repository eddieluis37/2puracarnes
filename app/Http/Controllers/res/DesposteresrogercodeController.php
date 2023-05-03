<?php

namespace App\Http\Controllers\res;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Beneficiore;
use App\Models\Despostere;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DesposteresrogercodeController extends Controller
{
    public $consulta;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $prod = Product::Where('category_id',1)->get();

        return view('categorias.res.index', compact('prod'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $id_user= Auth::user()->id;

        $beneficior = DB::table('beneficiores as b')
            ->join('thirds as t', 'b.thirds_id', '=', 't.id')
            ->select('t.name','b.id','b.lote','b.factura','b.canalplanta','b.cantidad','b.costokilo')
            ->where('b.id',$id)
            ->get();
        /******************/
        
        $this->consulta = Despostere::
        Where([
        ['beneficiores_id',$id],
        ['status','VALID'], 
        ])->get();
        
        //dd(count($this->consulta));

        if (count($this->consulta) === 0) {
            $prod = Product::Where([
                ['category_id',1],
                ['level_product_id',1],
            ])->get();
            foreach($prod as $key){
                $despost = new Despostere(); //Se crea una instancia del modelo
                $despost->users_id = $id_user; //Se establecen los valores para cada columna de la tabla
                $despost->beneficiores_id = $id;
                $despost->products_id = $key->id;
                $despost->peso = 0;
                $despost->porcdesposte = 0;
                $despost->costo = 0;
                $despost->costo_kilo = 0;
                $despost->precio = $key->price_fama;
                $despost->totalventa = 0;
                $despost->total = 0;
                $despost->porcventa = 0;
                $despost->porcutilidad = 0;
                $despost->status = 'VALID';
                $despost->save();
            }

            $this->consulta = Despostere::
            Where([
            ['beneficiores_id',$id],
            ['status','VALID'], 
            ])->get();
        }

        $desposters = $this->consulta;
        $TotalDesposte = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('porcdesposte');
        $TotalVenta = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('porcventa');
        $pesoTotalGlobal = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('peso');
        $costoTotalGlobal = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('costo');
        $costoKiloTotal = 0;
        if($pesoTotalGlobal != 0){
            $costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.');
        }
        //dd(count($desposters));
        //$beneficior = Beneficiore::Where('id',$id)->get();
        return view('categorias.res.index', compact('beneficior','desposters','TotalDesposte','TotalVenta','porcVentaTotal','pesoTotalGlobal','costoTotalGlobal','costoKiloTotal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function sumTotales($id)
    {

        $TotalDesposte = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('porcdesposte');
        $TotalVenta = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('porcventa');
        $pesoTotalGlobal = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('peso');
        $costoTotalGlobal = (float)Despostere::Where([['beneficiores_id',$id],['status','VALID']])->sum('costo');
        $costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.');

        $array = [
            'TotalDesposte' => $TotalDesposte,
            'TotalVenta' => $TotalVenta,
            'porcVentaTotal' => $porcVentaTotal,
            'pesoTotalGlobal' => $pesoTotalGlobal,
            'costoTotalGlobal' => $costoTotalGlobal,
            'costoKiloTotal' => $costoKiloTotal,
        ];

        return $array;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $despost = Despostere::where('id', $request->id)->first();
            $total_venta = $despost->precio * $request->peso_kilo;
            //$despost->users_id = $id_user; 
            //$despost->beneficiores_id = $request->beneficioId;
            //$despost->products_id = $request->producto;
            $despost->peso = $request->peso_kilo;
            //$despost->porcdesposte = 0;
            //$despost->costo = 0;
            //$despost->precio = $request->pventa;
            $despost->totalventa = $total_venta;
            //$despost->total = 0;
            //$despost->porcventa = 0;
            //$despost->porcutilidad = 0;
            //$despost->status = 'VALID';
            $despost->save();
            /*************************** */
            $getBeneficiores = Beneficiore::Where('id',$request->beneficioId)->get();

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
                $costoTotal = $porcentajecostoTotal * $getBeneficiores[0]->totalcostos;

                $costoKilo = 0;
                if ($key->peso != 0) {
                    $costoKilo = $costoTotal / $key->peso;
                }

                $updatedespost = Despostere::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costoTotal;
                $updatedespost->costo_kilo = $costoKilo;
                $updatedespost->save();
            }								
            /*************************** */
            /*$desposte = Despostere::
            Where([
            ['beneficiores_id',$request->beneficioId],
            ['status','VALID'], 
            ])->get();*/
            $desposte = DB::table('desposteres as d')
            ->join('products as p', 'd.products_id', '=', 'p.id')
            ->select('p.name','d.id','d.porcdesposte','d.precio','d.peso','d.totalventa','d.porcventa','d.costo','d.costo_kilo')
            ->where([
            ['d.beneficiores_id',$request->beneficioId],
            ['d.status','VALID'], 
            ])->get();
            /*************************************** */
            $arrayTotales = $this->sumTotales($request->beneficioId);

            return response()->json([
                "status" => 1,
                "id" => $request->id,
                "precio" => $despost->precio,
                "totalventa" => $total_venta,
                "benefit" => $request->beneficioId,
                "desposte" => $desposte,
                "arrayTotales" => $arrayTotales,
                "beneficiores" => $getBeneficiores,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "message" => $th,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $despost = Despostere::where('id', $request->id)->first();
            $despost->status = 'CANCELED';
            $despost->save();
            /*************************** */
            $getBeneficiores = Beneficiore::Where('id',$request->beneficioId)->get();

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
                $costoTotal = $porcentajecostoTotal * $getBeneficiores[0]->totalcostos;

                $updatedespost = Despostere::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costoTotal;
                $updatedespost->save();
            }								
            /*************************** */
            $desposte = DB::table('desposteres as d')
            ->join('products as p', 'd.products_id', '=', 'p.id')
            ->select('p.name','d.id','d.porcdesposte','d.precio','d.peso','d.totalventa','d.porcventa','d.costo')
            ->where([
            ['d.beneficiores_id',$request->beneficioId],
            ['d.status','VALID'], 
            ])->get();
            /*************************************** */
            $arrayTotales = $this->sumTotales($request->beneficioId);

            return response()->json([
                "status" => 1,
                "id" => $request->id,
                "benefit" => $request->beneficioId,
                "desposte" => $desposte,
                "arrayTotales" => $arrayTotales,
                "beneficiores" => $getBeneficiores,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => (array) $th
            ]);
        }
    }
}
