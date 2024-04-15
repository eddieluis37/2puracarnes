<?php

namespace App\Http\Controllers\pollo;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Centro_costo_product;
use App\Models\Beneficiopollo;
use App\Models\Despostepollo;
use App\Models\Utilidad_beneficiopollos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Carbon\Carbon;

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
                /*   ['category_id', 3], */
                /*    ['level_product_id', 1], */
            ])->orderBy('name', 'asc')
                ->whereIn('id', [179, 183, 175, 176, 184, 187, 185, 186, 178, 188, 189])
                ->get();

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
        $pesoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('peso');
        $TotalVenta = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcventa');

        $costoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo');
        $costoKiloTotal = 0;
        if ($pesoTotalGlobal != 0) {
            $costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.');
        }
        $TotalUtilidad = $TotalVenta - $costoTotalGlobal;
        $PorcUtilidad = 0;
        if ($TotalVenta != 0) {
            $PorcUtilidad = ($TotalUtilidad / $TotalVenta) * 100;
        }

        $PolloEnteroKg = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['products_id', 189]])->sum('kilos');
        $Merma = $pesoTotalGlobal - $PolloEnteroKg;
        $PorcMerma = 0;
        if ($PolloEnteroKg != 0) {
            $PorcMerma = ($Merma / $PolloEnteroKg) * 100;
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
            'TotalUtilidad',
            'PorcUtilidad',
            'Merma',
            'PorcMerma',
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
        $pesoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('peso');
        $TotalVenta = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('totalventa');
        $porcVentaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcventa');

        $costoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo');
        $TotalUtilidad = $TotalVenta - $costoTotalGlobal;
        $PorcUtilidad = ($TotalUtilidad / $TotalVenta) * 100;
        $PolloEnteroKg = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['products_id', 189]])->sum('kilos');
        $Merma = $pesoTotalGlobal - $PolloEnteroKg;
        $PorcMerma = ($Merma / $PolloEnteroKg) * 100;
        $array = [
            'TotalDesposte' => $TotalDesposte,
            'pesoTotalGlobal' => $pesoTotalGlobal,
            'TotalVenta' => $TotalVenta,
            'porcVentaTotal' => $porcVentaTotal,

            'costoTotalGlobal' => $costoTotalGlobal,
            'TotalUtilidad' => $TotalUtilidad,
            'PorcUtilidad' => $PorcUtilidad,
            'Merma' => $Merma,
            'PorcMerma' => $PorcMerma,

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
                $updatedespost->porcutilidad = ($key->utilidad / $key->precio) * 100;

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

    public function cargarInventarioaves(Request $request)
    {

        $beneficioId = $request->input('beneficioId');

        $currentDateTime = Carbon::now();
        $formattedDate = $currentDateTime->format('Y-m-d');

        $beneficio = Beneficiopollo::find($beneficioId);
        $beneficio->fecha_cierre = $formattedDate;
        $beneficio->save();

        $utilidadMenPollo = Utilidad_beneficiopollos::where([
            ['beneficiopollos_id', $beneficioId],
            ['products_id', 307]
        ])->first();

        $utilidadMollejaPollo = Utilidad_beneficiopollos::where([
            ['beneficiopollos_id', $beneficioId],
            ['products_id', 308]
        ])->first();


        // Afectar inventario KG y Utilidad con respectos a Menudencia POLLO
        $centro = Centro_costo_product::where('products_id', 307)->first();
        $centro->compralote = $centro->compralote + $utilidadMenPollo->kilos;
        $centro->cto_compralote_total = $centro->cto_compralote_total + $utilidadMenPollo->costo_real;
        $centro->save();

        // Afectar inventario KG y Utilidad con respectos a Molleja POLLO
        $centro = Centro_costo_product::where('products_id', 308)->first();
        $centro->compralote = $centro->compralote + $utilidadMollejaPollo->kilos;
        $centro->cto_compralote_total = $centro->cto_compralote_total + $utilidadMollejaPollo->costo_real;
        $centro->save();

        $beneficioc = Beneficiopollo::where('id', $beneficioId)->get();

        DB::update(
            "
        UPDATE centro_costo_products c
        JOIN despostepollos d ON c.products_id = d.products_id
        JOIN beneficiopollos b ON b.id = d.beneficiopollos_id
        JOIN products p ON p.id = d.products_id
        SET c.compralote = c.compralote + d.peso,
            c.cto_compralote = c.cto_compralote + d.costo_kilo,
            c.cto_compralote_total = c.cto_compralote_total + (d.costo_kilo * d.peso),
            p.cost = d.costo_kilo
        WHERE d.beneficiopollos_id = :beneficioid
        AND b.centrocosto_id = :cencosid 
        AND c.centrocosto_id = :cencosid2 ",
            [
                'beneficioid' => $beneficioId,
                'cencosid' =>  $beneficio->centrocosto_id,
                'cencosid2' =>  $beneficio->centrocosto_id
            ]
        );

        return response()->json([
            'status' => 1,
            'message' => 'Cargado al inventario exitosamente',
            'beneficioc' => $beneficioc
        ]);

        // return view('categorias.res.desposte.index', ['beneficio' => $beneficio]);
    }
}
