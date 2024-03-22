<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\caja\Caja;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class pdfOrderController extends Controller
{
    public function showPDFOrder($id)
    {
        $fecha = Carbon::now(); // Obtenemos la fecha actual

        $order = Order::findOrFail($id)
            ->join('thirds as third', 'orders.third_id', '=', 'third.id')
            ->join('users as u', 'orders.user_id', '=', 'u.id')
            ->join('centro_costo as centro', 'orders.centrocosto_id', '=', 'centro.id')
            ->leftJoin('thirds as vendedor', 'orders.vendedor_id', '=', 'vendedor.id')
            ->leftJoin('thirds as alistador', 'orders.alistador_id', '=', 'alistador.id')
            ->leftJoin('subcentrocostos as subcentro', 'orders.subcentrocostos_id', '=', 'subcentro.id')
            ->leftJoin('formapagos as fp', 'orders.formapago_id', '=', 'fp.id')
           /*      ->leftJoin('formapagos as fp2', 'orders.forma_pago_otros_id', '=', 'fp2.id')
            ->leftJoin('formapagos as fp3', 'orders.forma_pago_credito_id', '=', 'fp3.id') */
            ->select('orders.*', 'u.name as nameuser', 'third.name as namethird', 'third.correo', 'vendedor.name as nombre_vendedor', 'fp.nombre as forma_pago', 'alistador.name as nombre_alistador', 'subcentro.name as subcentro', 'third.celular', 'third.identification', 'orders.direccion_envio as direccion', 'orders.hora_inicial_entrega', 'centro.name as namecentrocosto', 'third.porc_descuento', 'orders.total_iva', 'orders.vendedor_id')
            ->where([
                ['orders.id', $id],
                /*  ['order_details.status', 1]  */
            ])->get();

        //  dd($order);

        $orderDetails = OrderDetail::where('order_id', $id)
            ->join('products as pro', 'order_details.product_id', '=', 'pro.id')
            ->select('order_details.*', 'pro.name as nameprod', 'pro.code', 'order_details.porc_iva', 'order_details.iva', 'order_details.porc_otro_impuesto')
            ->where([
                ['order_details.order_id', $id],
                /*   ['order_details.status', 1] */
            ])->get();

        //  dd($orderDetails);

        // Configurar el idioma en español para Carbon
        Carbon::setLocale('es');

        $showFactura = PDF::loadView('order.reporte', compact('order', 'orderDetails', 'fecha'));
        return $showFactura->stream('order.pdf');
        //return $showFactura->download('order.pdf');
    }
   
}
