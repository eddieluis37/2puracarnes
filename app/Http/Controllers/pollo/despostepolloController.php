<?php

namespace App\Http\Controllers\pollo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\Despostepollo;
use App\Models\Beneficiopollo;
use App\Models\Product;
use App\Models\Utilidad_beneficiopollos;

class despostepolloController extends Controller
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
        $id_user = Auth::user()->id;

        $beneficior = DB::table('beneficiopollos as b')
            ->join('thirds as t', 'b.thirds_id', '=', 't.id')
            ->select('t.name', 'b.id', 'b.lote', 'b.factura', 'b.peso_canales_pollo_planta', 'b.cantidad', 'b.subtotal', 'b.fecha_cierre')
            ->where('b.id', $id)
            ->get();
        /******************/
        $this->consulta = Despostepollo::Where([
            ['beneficiopollos_id', $id],
            ['status', 'VALID'],
        ])->get();

        if (count($this->consulta) === 0) {
            $prod = Product::Where([
                ['status', 1],
                ['category_id', 3],
                ['level_product_id', 1],
            ])->orderBy('name', 'asc')->get();

            foreach ($prod as $key) {
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
              /*   $despost->total = 0; */
                $despost->porcventa = 0;
                $despost->porcutilidad = 0;
                $despost->status = 'VALID';
                $despost->save();
            }
            $this->consulta = Despostepollo::Where([
                ['beneficiopollos_id', $id],
                ['status', 'VALID'],
            ])->get();
        }
        /****************************************** */
        $status = '';
        $fechaBeneficioCierre = Carbon::parse($beneficior[0]->fecha_cierre);
        $date = Carbon::now();
        $currentDate = Carbon::parse($date->format('Y-m-d'));

        if ($currentDate->gt($fechaBeneficioCierre)) {
            //'Date 1 is greater than Date 2';
            $status = 'false';
        } elseif ($currentDate->lt($fechaBeneficioCierre)) {
            //'Date 1 is less than Date 2';
            $status = 'true';
        } else {
            //'Date 1 and Date 2 are equal';
            $status = 'false';
        }
        /****************************************** */
        $desposters = $this->consulta;
        $TotalDesposte = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcdesposte');
        $TotalVenta = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcventa');
        $pesoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('peso');
        $costoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo');
        $costoKiloTotal = 0;
        if ($pesoTotalGlobal != 0) {
            $costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.');
        }
        return view('categorias.aves.desposteaves.index', compact(
            'beneficior',
            'desposters',
            'TotalDesposte',
            'TotalVenta',
            'porcVentaTotal',
            'pesoTotalGlobal',
            'costoTotalGlobal',
            'costoKiloTotal',
            'status'
        ));
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

    public function sumTotales($id)
    {

        $TotalDesposte = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcdesposte');
        $TotalVenta = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcventa');
        $pesoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('peso');
        $costoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo');
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
    public function update(Request $request)
    {
        try {
            $despost = Despostepollo::where('id', $request->id)->first();
            $total_venta = $despost->precio * $request->peso_kilo;
            $despost->peso = $request->peso_kilo;
            $despost->totalventa = $total_venta;
            $despost->save();
            /*************************** */
            /* $TotalKilos = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('kilos'); */
            $costoReal = (float)Utilidad_beneficiopollos::where([
                ['beneficiopollos_id', $request->beneficioId],
                ['products_id', 189],
                ['status', 'VALID']
            ])->pluck('costo_real')->first();

            $getBeneficioaves = Beneficiopollo::Where('id', $request->beneficioId)->get();
            $beneficior = Despostepollo::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;
            foreach ($beneficior as $key) {
                $sumakilosTotal = (float)Despostepollo::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('peso');
                $porc = (float)number_format($key->peso / $sumakilosTotal, 4);
                $porcentajeDesposte = (float)number_format($porc * 100, 2);

                $sumaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('totalventa');
                $porcve = (float)number_format($key->totalventa / $sumaTotal, 4);
                $porcentajeVenta = (float)number_format($porcve * 100, 2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);

            /*   $costoTotal = $porcentajecostoTotal * $getBeneficioaves[0]->totalcostos; */
               
                $costo = $costoReal * $porcentajecostoTotal;

                $costoKilo = 0;
                if ($key->peso != 0) {
                    $costoKilo = $costo / $key->peso;
                }

                $updatedespost = Despostepollo::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costo;
                $updatedespost->costo_kilo = $costoKilo;
                $updatedespost->utilidad = $key->precio - $costoKilo;
                $updatedespost->porcutilidad = ($key->precio - ($key->precio - $costoKilo)) / 100;

                $updatedespost->save();
            }
            /*************************************** */
            $desposte = DB::table('despostepollos as d')
                ->join('products as p', 'd.products_id', '=', 'p.id')
                ->select('p.name', 'd.id', 'd.porcdesposte', 'd.precio', 'd.peso', 'd.totalventa', 'd.porcventa', 'd.costo', 'd.costo_kilo', 'd.utilidad', 'd.porcutilidad')
                ->where([
                    ['d.beneficiopollos_id', $request->beneficioId],
                    ['d.status', 'VALID'],
                    ['p.status', 1],
                ])
                ->orderBy('p.name', 'asc')
                ->get();
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
                "beneficiores" => $getBeneficioaves,
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
            $despost = Despostepollo::where('id', $request->id)->first();
            $despost->status = 'CANCELED';
            $despost->save();
            /*************************** */
            $getBeneficioaves = Beneficiopollo::Where('id', $request->beneficioId)->get();
            $beneficior = Despostepollo::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;
            foreach ($beneficior as $key) {
                $sumakilosTotal = (float)Despostepollo::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('peso');
                $porc = (float)number_format($key->peso / $sumakilosTotal, 4);
                $porcentajeDesposte = (float)number_format($porc * 100, 2);

                $sumaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('totalventa');
                $porcve = (float)number_format($key->totalventa / $sumaTotal, 4);
                $porcentajeVenta = (float)number_format($porcve * 100, 2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);
                $costoTotal = $porcentajecostoTotal * $getBeneficioaves[0]->totalcostos;

                $costoKilo = 0;
                if ($key->peso != 0) {
                    $costoKilo = $costoTotal / $key->peso;
                }

                $updatedespost = Despostepollo::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costoTotal;
                $updatedespost->costo_kilo = $costoKilo;
                $updatedespost->save();
            }
            /*************************************** */
            $desposte = DB::table('despostepollos as d')
                ->join('products as p', 'd.products_id', '=', 'p.id')
                ->select('p.name', 'd.id', 'd.porcdesposte', 'd.precio', 'd.peso', 'd.totalventa', 'd.porcventa', 'd.costo', 'd.costo_kilo')
                ->where([
                    ['d.beneficiopollos_id', $request->beneficioId],
                    ['d.status', 'VALID'],
                ])->get();
            /*************************************** */
            $arrayTotales = $this->sumTotales($request->beneficioId);
            return response()->json([
                "status" => 1,
                "id" => $request->id,
                "benefit" => $request->beneficioId,
                "desposte" => $desposte,
                "arrayTotales" => $arrayTotales,
                "beneficiores" => $getBeneficioaves,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "message" => $th,
            ]);
        }
    }
}
