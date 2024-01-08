
 /*  $merma = $peso_producto_padre - $sumakilosTotal;

//   $newStockPadre = $request->stockPadre - $arrayTotales['totalPesoProductoHijo'];
$alist = Workshop::firstWhere('id', $request->tallerId);
$alist->total_peso_producto_hijo =  $arrayTotales['totalPesoProductoHijo'];
$alist->costo_kilo_padre = $request->input('costo_kilo_padre');
$alist->merma = 99;
//$alist->nuevo_stock_padre = $newStockPadre;
$alist->save(); */
 //$details->costo = $formatCantidad->MoneyToNumber($request->porcventa * ($arrayTotales['totalPesoProductoHijo']));
  //  $total = $detail->peso_producto_hijo *  $costo_kilo_padre;

      

if ($arrayTotales['totalPesoProductoHijo'] != 0) {
    $details->porcventa = (float)number_format(($formatpeso_producto_hijo * $prod[0]->price_fama) / ($arrayTotales['totalPesoProductoHijo']) * 100, 2);
} else {
    // Manejar la división por cero aquí
    $details->porcventa = (float)number_format($formatpeso_producto_hijo * $prod[0]->price_fama / $formatpeso_producto_hijo);
    // O mostrar un mensaje de error
    // echo "Error: División por cero";
} 

