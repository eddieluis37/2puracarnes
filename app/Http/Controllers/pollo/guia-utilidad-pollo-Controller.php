$key->save();

/* $costoReal = $key->precio_kg_venta * $getBeneficioaves[0]->total_factura; */

$participacionVenta = ($key->ingresos_totales / $TotalingresosTotales) * 100;
$costoReal = $getBeneficioaves[0]->total_factura * ($participacionVenta / 100);

$updatedespost = Utilidad_beneficiopollos::firstWhere('id', $key->id);

$updatedespost->costo_real = $costoReal;
$updatedespost->participacion_venta = $participacionVenta;

$updatedespost->costo_unitario = $costoReal / $key->kilos;

$updatedespost->porcentaje_participacion = ($key->kilos / $TotalKilos) * 100;

$updatedespost->utilidad_dinero = $key->ingresos_totales -  $costoReal;

$updatedespost->porcentaje_utilidad = ((($key->ingresos_totales -  $costoReal) / $key->kilos) / $precio_kg_venta) * 100;
$updatedespost->dinero_kilo = ($key->ingresos_totales -  $costoReal) / $key->kilos;

$updatedespost->save();



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

            $prod = Product::where('status', 1)
                ->whereIn('id', [189, 307, 308])
                ->orderBy('id', 'asc')
                ->get();


            foreach ($beneficior as $key) {

                foreach ($prod as $staticProduct) {
                    $kilosToUpdate = 0; // Initialize the kilos to update
                    $beneficio = Beneficiopollo::find($key->id);

                    switch ($staticProduct->id) {
                        case 189:
                            $kilosToUpdate = ($beneficio->peso_pie_planta * $beneficio->promedio_canal_fria_sala) / 50;
                            break;
                        case 307:
                            $kilosToUpdate = $beneficio->menudencia_pollo_kg;
                            break;
                        case 308:
                            $kilosToUpdate = $beneficio->mollejas_corazones_kg;
                            break;
                        default:
                            // Handle default case if needed
                            break;
                    }



                    // Update the kilos for the current Utilidad_beneficiopollos record
                    $updatedespost = Utilidad_beneficiopollos::find($key->id);
                    $updatedespost->kilos = $kilosToUpdate;
                    $updatedespost->save();
                }

                $participacionVenta = ($key->ingresos_totales / $TotalingresosTotales) * 100;
                $costoReal = $getBeneficioaves[0]->total_factura * ($participacionVenta / 100);

                $updatedespost = Utilidad_beneficiopollos::firstWhere('id', $key->id);

                $updatedespost->costo_real = $costoReal;

                $updatedespost->participacion_venta = $participacionVenta;

                $updatedespost->costo_unitario = $costoReal / $key->kilos;

                $updatedespost->porcentaje_participacion = ($key->kilos / $TotalKilos) * 100;

                $updatedespost->utilidad_dinero = $key->ingresos_totales -  $costoReal;

                $updatedespost->porcentaje_utilidad = ((($key->ingresos_totales -  $costoReal) / $key->kilos) / $precio_kg_venta) * 100;
                $updatedespost->dinero_kilo = ($key->ingresos_totales -  $costoReal) / $key->kilos;
            }
            /*************************************** */
            $desposte = DB::table('despostepollos as d')
                ->join('products as p', 'd.products_id', '=', 'p.id')
                ->select('p.name', 'd.id', 'd.porcdesposte', 'd.precio', 'd.peso', 'd.totalventa', 'd.porcventa', 'd.costo', 'd.costo_kilo')
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