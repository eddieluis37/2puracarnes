public function updatedetail(Request $request)
    {
        try {

            $prod = DB::table('products as p')
                ->join('centro_costo_products as ce', 'p.id', '=', 'ce.products_id')
                ->select('ce.stock', 'ce.fisico')
                ->where([
                    ['p.id', $request->productoId],
                    ['ce.centrocosto_id', $request->centrocosto],
                    ['p.status', 1],

                ])->get();
            //$prod = Product::firstWhere('id', $request->productoId);
            //$newStock = $prod->stock + $request->newpeso_producto_hijo;
            $newStock = $prod[0]->stock + $request->newpeso_producto_hijo;

            $updatedetails = workshop_detail::firstWhere('id', $request->id);
            $updatedetails->peso_producto_hijo = $request->newpeso_producto_hijo;
            $updatedetails->newstock = $newStock;
            $updatedetails->save();

            $arraydetail = $this->getworkshopdetail($request->tallerId, $request->centrocosto);
            $arrayTotales = $this->sumTotales($request->tallerId);

            $newStockPadre = $request->stockPadre - $arrayTotales['totalPesoProductoHijo'];
            $alist = Workshop::firstWhere('id', $request->tallerId);
            $alist->nuevo_stock_padre = $newStockPadre;
            $alist->save();

            return response()->json([
                'status' => 1,
                'message' => 'Guardado correctamente',
                'array' => $arraydetail,
                'arrayTotales' => $arrayTotales
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'array' => (array) $th
            ]);
        }
    }