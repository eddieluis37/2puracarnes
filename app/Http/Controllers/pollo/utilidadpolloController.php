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

class utilidadpolloController extends Controller
{
    public function create($id)
    {
        $id_user = Auth::user()->id;

        $beneficior = DB::table('beneficiopollos as b')
            ->join('thirds as t', 'b.thirds_id', '=', 't.id')
            ->select('t.name', 'b.id', 'b.lote', 'b.factura', 'b.peso_pie_planta as peso_pie_planta', 'b.promedio_canal_fria_sala', 'b.menudencia_pollo_kg', 'b.mollejas_corazones_kg', 'b.peso_canales_pollo_planta', 'b.cantidad', 'b.subtotal', 'b.fecha_cierre')
            ->where('b.id', $id)
            ->get();
        /******************/
        $this->consulta = Utilidad_beneficiopollos::Where([
            ['beneficiopollos_id', $id],
            ['status', 'VALID'],
        ])->get();

        if (count($this->consulta) === 0) {
            $prod = Product::where('status', 1)
                ->whereIn('id', [189, 307, 308])
                ->orderBy('id', 'asc')
                ->get();
            foreach ($prod as $staticProduct) {
                $despost = new Utilidad_beneficiopollos();
                $despost->user_id = $id_user;
                $despost->beneficiopollos_id = $id;
                $despost->product_name = $staticProduct['name']; // Agregar un campo para el nombre del producto estático


                foreach ($beneficior as $beneficio) {
                    $TotalingresosTotales = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('ingresos_totales');
                    if ($staticProduct['id'] == 189) {
                        $despost->kilos = ($beneficio->peso_pie_planta * $beneficio->promedio_canal_fria_sala) / 100;
                    } elseif ($staticProduct['id'] == 307) {
                        $despost->kilos = $beneficio->menudencia_pollo_kg;
                    } elseif ($staticProduct['id'] == 308) {
                        $despost->kilos = $beneficio->mollejas_corazones_kg;
                    }
                }
                $despost->products_id = $staticProduct->id;
                $despost->totales_kilos = $despost->kilos_pollo_entero + $despost->kilos_menudencias + $despost->kilos_mollejas_corazones;
                $despost->costo_unitario = 0;
                $despost->costo_real = $staticProduct['price_fama'];
                $despost->precio_kg_venta = $staticProduct['price_fama'];
                $despost->ingresos_totales = $staticProduct['price_fama'] * $despost->kilos;
                $despost->participacion_venta = ($staticProduct['price_fama'] * $despost->kilos);
                $despost->utilidad_dinero = 0;
                $despost->porcentaje_utilidad = 0;
                $despost->dinero_kilo = 0;
                $despost->status = 'VALID';
                $despost->save();
            }

            $this->consulta = Utilidad_beneficiopollos::Where([
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
        $TotalKilos = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('kilos');
        $TotalingresosTotales = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('ingresos_totales');
        $TotalPorcPart = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcentaje_participacion');
        $TotalCostoReal = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo_real');
        $porcVentaTotal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcventa');
        $pesoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('peso');
        $costoTotalGlobal = (float)Despostepollo::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo');
        $costoKiloTotal = 0;
        if ($pesoTotalGlobal != 0) {
            $costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.');
        }
        return view('categorias.aves.utilidadaves.index', compact(
            'beneficior',
            'desposters',
            'TotalKilos',
            'TotalPorcPart',
            'TotalingresosTotales',
            'TotalCostoReal',
            'porcVentaTotal',
            'pesoTotalGlobal',
            'costoTotalGlobal',
            'costoKiloTotal',
            'status'
        ));
    }

    /*   // Arreglo estático con los registros deseados
     $staticProducts = [
        ['id' => 1, 'name' => 'POLLO_ENTERO', 'price_fama' => 10],
        ['id' => 2, 'name' => 'MENUDENCIAS', 'price_fama' => 5],
        ['id' => 3, 'name' => 'MOLLEJAS_CORAZONES', 'price_fama' => 3],
    ]; */


    public function sumTotales($id)
    {

        $TotalKilos = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('kilos');


        $TotalPorcPart = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('porcentaje_participacion');
        $TotalCostoReal = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('costo_real');
        $TotalCostoUnit = $TotalCostoReal / $TotalKilos;

        $TotalingresosTotales = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $id], ['status', 'VALID']])->sum('ingresos_totales');
        $PorcVenta = $TotalingresosTotales / $TotalingresosTotales;
        $UtilidadDinero = $TotalingresosTotales - $TotalCostoReal;
        $DineroKilo = $UtilidadDinero / $TotalKilos;

        /*    
       
        $costoKiloTotal = number_format($costoTotalGlobal / $pesoTotalGlobal, 2, ',', '.'); */

        $array = [
            'TotalKilos' => $TotalKilos,

            'TotalPorcPart' => $TotalPorcPart,
            'TotalCostoUnit' => $TotalCostoUnit,
            'TotalCostoReal' => $TotalCostoReal,

            'TotalingresosTotales' => $TotalingresosTotales,
            'PorcVenta' => $PorcVenta,
            'UtilidadDinero' => $UtilidadDinero,

            'DineroKilo' => $DineroKilo,
            /* 
         
            'costoKiloTotal' => $costoKiloTotal, */
        ];

        return $array;
    }

    public function update(Request $request)
    {
        try {
            $despost = Utilidad_beneficiopollos::where('id', $request->id)->first();
            $precio_kg_venta = $despost->precio_kg_venta;

            $despost->precio_kg_venta = $precio_kg_venta;
            $despost->save();
            /*************************** */
            $getBeneficioaves = Beneficiopollo::Where('id', $request->beneficioId)->get();
            $beneficior = Utilidad_beneficiopollos::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->get();
            $TotalingresosTotales = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('ingresos_totales');
            $TotalKilos = (float)Utilidad_beneficiopollos::Where([['beneficiopollos_id', $request->beneficioId], ['status', 'VALID']])->sum('kilos');

            foreach ($beneficior as $key) {

                /* $costoReal = $key->precio_kg_venta * $getBeneficioaves[0]->total_factura; */

                $participacionVenta = ($key->ingresos_totales / $TotalingresosTotales) * 100;
                $costoReal = $getBeneficioaves[0]->total_factura * ($participacionVenta / 100);

                $updatedespost = Utilidad_beneficiopollos::firstWhere('id', $key->id);

                $updatedespost->costo_real = $costoReal;
                $updatedespost->participacion_venta = $participacionVenta;

                $updatedespost->costo_unitario = $costoReal / $key->kilos;

                $updatedespost->porcentaje_participacion = ($key->kilos / $TotalKilos) * 100;

                $updatedespost->utilidad_dinero = $key->ingresos_totales -  $costoReal;

                $updatedespost->dinero_kilo = ($key->ingresos_totales -  $costoReal) / $key->kilos;
                $updatedespost->porcentaje_utilidad = ((($key->ingresos_totales -  $costoReal) / $key->kilos)  / ($key->precio_kg_venta)) * 100;

                $updatedespost->save();
            }

            foreach ($beneficior as $key) {
                $beneficio = Beneficiopollo::find($request->beneficioId);
                foreach ($beneficior as $key) {
                    if ($key->products_id == 189) {
                        $key->kilos = ($beneficio->peso_pie_planta * $beneficio->promedio_canal_fria_sala) / 100;
                    } elseif ($key->products_id == 307) {
                        $key->kilos = $beneficio->menudencia_pollo_kg;
                    } elseif ($key->products_id == 308) {
                        $key->kilos = $beneficio->mollejas_corazones_kg;
                    }
                    $key->save();
                }
            }
            /*************************************** */
            $utilidad = DB::table('utilidad_beneficiopollos as d')
                ->join('products as p', 'd.products_id', '=', 'p.id')
                ->select('p.name', 'd.id as id', 'd.product_name', 'd.precio_kg_venta', 'd.ingresos_totales', 'd.kilos', 'd.totales_kilos', 'd.participacion_venta', 'd.utilidad_dinero', 'd.porcentaje_utilidad', 'd.dinero_kilo', 'd.porcentaje_participacion', 'd.costo_unitario', 'd.costo_real')
                ->where([
                    ['d.beneficiopollos_id', $request->beneficioId],
                    ['d.status', 'VALID'],
                    ['p.status', 1],
                ])
                /*  ->orderBy('p.name', 'asc') */
                ->orderBy('d.id', 'asc')
                ->get();
            /*************************************** */
            $arrayTotales = $this->sumTotales($request->beneficioId);
            return response()->json([
                "status" => 1,
                "id" => $request->beneficioId,
                "precio_kg_venta" => $despost->precio_kg_venta,

                "benefit" => $request->beneficioId,
                "utilidad" => $utilidad,
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
