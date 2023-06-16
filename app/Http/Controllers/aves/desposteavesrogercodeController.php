<?php

namespace App\Http\Controllers\aves;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\Despostepollo;
use App\Models\Product;

class desposteavesrogercodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $id_user= Auth::user()->id;

        $beneficior = DB::table('beneficiopollos as b')
            ->join('thirds as t', 'b.thirds_id', '=', 't.id')
            ->select('t.name','b.id','b.lote','b.factura','b.canalplanta','b.cantidad','b.costokilo','b.fecha_cierre')
            ->where('b.id',$id)
            ->get();
        /******************/
        $this->consulta = Despostepollo::
        Where([
        ['beneficiopollos_id',$id],
        ['status','VALID'], 
        ])->get();

        if (count($this->consulta) === 0) {
            $prod = Product::Where([
                ['category_id',3],
                ['level_product_id',1],
            ])->get();
                
            foreach($prod as $key){
                $despost = new Despostepollo(); //Se crea una instancia del modelo
                $despost->users_id = $id_user; //Se establecen los valores para cada columna de la tabla
                $despost->beneficiopollos_id = $id;
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
            $this->consulta = Despostepollo::
            Where([
            ['beneficiopollos_id',$id],
            ['status','VALID'], 
            ])->get();
        }
        $desposters = $this->consulta;
        return view('categorias.aves.desposteaves.index', compact('beneficior','desposters'));

        //return view('categorias.aves.desposteaves.index', compact(
            //'beneficior',
            //'desposters',
            //'TotalDesposte',
            //'TotalVenta',
            //'porcVentaTotal',
            //'pesoTotalGlobal',
            //'costoTotalGlobal',
            //'costoKiloTotal',
            //'status'
        //));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
