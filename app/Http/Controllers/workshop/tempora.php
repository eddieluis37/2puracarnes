public function savedetail(Request $request)
    {
        try {
            $despost = Workshop::where('id', $request->id)->first();
            $total_venta = $despost->precio * $request->peso_kilo;
            //$despost->users_id = $id_user; 
            //$despost->beneficiores_id = $request->workshopId;
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
            $getBeneficiores = Workshop_detail::Where('id',$request->workshopId)->get();

            $beneficior = Workshop::Where([['workshop_id',$request->workshopId],['status','VALID']])->get();
            $porcentajeVenta = 0;
            $porcentajeDesposte = 0;
            foreach ($beneficior as $key) {
                $sumakilosTotal = (float)Workshop::Where([['workshop_id',$request->workshopId],['status','VALID']])->sum('peso');
                $porc = (float)number_format($key->peso / $sumakilosTotal,4);
                $porcentajeDesposte = (float)number_format($porc * 100,2);

                $sumaTotal = (float)Workshop::Where([['workshop_id',$request->workshopId],['status','VALID']])->sum('totalventa');
                $porcve = (float)number_format($key->totalventa / $sumaTotal,4);
                $porcentajeVenta = (float)number_format($porcve * 100,2);

                $porcentajecostoTotal = (float)number_format($porcentajeVenta / 100, 4);
                $costoTotal = $porcentajecostoTotal * $getBeneficiores[0]->totalcostos;

                $costoKilo = 0;
                if ($key->peso != 0) {
                    $costoKilo = $costoTotal / $key->peso;
                }

                $updatedespost = Workshop::firstWhere('id', $key->id);
                $updatedespost->porcdesposte = $porcentajeDesposte;
                $updatedespost->porcventa = $porcentajeVenta;
                $updatedespost->costo = $costoTotal;
                $updatedespost->costo_kilo = $costoKilo;
                $updatedespost->save();
            }								
            /*************************** */
            /*$desposte = Workshop::
            Where([
            ['workshop_id',$request->workshopId],
            ['status','VALID'], 
            ])->get();*/
            $desposte = DB::table('desposteres as d')
            ->join('products as p', 'd.products_id', '=', 'p.id')
            ->select('p.name','d.id','d.porcdesposte','d.precio','d.peso','d.totalventa','d.porcventa','d.costo','d.costo_kilo')
            ->where([
            ['d.workshop_id',$request->workshopId],
            ['d.status','VALID'], 
            ])->get();
            /*************************************** */
            $arrayTotales = $this->sumTotales($request->workshopId);

            return response()->json([
                "status" => 1,
                "id" => $request->id,
                "precio" => $despost->precio,
                "totalventa" => $total_venta,
                "benefit" => $request->workshopId,
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