<form action="{{ route('pago.save', ['id' => $venta->id]) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="porc_descuento" name="porc_descuento" value="898989" data-id="">
    @csrf
    <table class="table">
        <thead>
            <tr>
                <th scope="col" style="text-align: left; vertical-align: middle;">Cliente</th>
                <th scope="col" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$venta->third->name}}</th>
                <!--         <th scope="col">Last</th> -->

            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" style="text-align: left">Centro_Costo</th>
                <td style="text-align: left">
                    <p>{{$venta->centrocosto->name}}</p>
                </td>
            </tr>
            <tr>
                <th scope="row" style="text-align: left">Vendedor</th>

                <td style="text-align: left">{{$dataVenta[0]->vendedor_name}}</td>

            </tr>
            <tr>
                <th scope="row" style="text-align: left">Total_Bruto</th>
                <td colspan="2">$ {{number_format($arrayTotales['TotalBrutoSinDescuento'], 0, ',', '.')}}</td>

            </tr>
            <tr>
                <th scope="row" style="text-align: left">Descuentos</th>
                <td colspan="2">$ {{number_format($arrayTotales['TotalDescuentos'], 0, ',', '.')}}</td>
            </tr>
            <tr>
                <th scope="row" style="text-align: left">SubTotal</th>
                <td colspan="2">$ {{number_format($subtotal, 0, ',', '.')}}</td>

            </tr>
            <tr>
                <th scope="row" style="text-align: left">Total_IVA</th>
                <td colspan="2">$ {{number_format($arrayTotales['TotalIva'], 0, ',', '.')}}</td>


            </tr>
            <tr>
                <th scope="row" style="text-align: left">TotalOtrosImp</th>
                <td colspan="2">$ {{number_format($arrayTotales['TotalOtroImpuesto'], 0, ',', '.')}}</td>

            </tr>
            <tr>
                <th scope="row" style="text-align: left">Valor_a_Pagar</th>
                <td colspan="2">
                    <input type="text" name="valor_a_pagar" id="valor_a_pagar" value="$ {{number_format($arrayTotales['TotalValorAPagar'], 0, ',', '.')}}" disabled style="text-align: right; font-weight: bold; color: black">
                </td>
            </tr>
            <tr>
                <th scope="row" style="text-align: left">Valor_Pagado</th>
                <td colspan="2" style="text-align: right">$ <input type="text" name="valor_pagado" id="valor_pagado" value="valorPagado" disabled style="text-align: right; font-weight: bold; color: black"></td>

            </tr>
            <tr>
                <th scope="row" style="text-align: left">Cambio</th>
                <td colspan="2" style="text-align: right">$ <input type="text" name="cambio" id="cambio" value="valorCambio" disabled style="text-align: right; font-weight: bold; color: black"></td>

            </tr>


        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">
                    <form method="GET" action="{{ route('pago.save', ['id' => $venta->id]) }}">
                        @csrf
                        <div class="text-center mt-1">
                            <button type="submit" class="btn btn-success">Pagar</button>
                        </div>
                    </form>
                </th>
                <th colspan="2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" id="btnGuardar" disabled>Guardar e imprimir</button>
                        <button type="button" class="btn btn-primary" onclick="history.back()">Volver</button>
                    </div>
                </th>
            </tr>
        </tfoot>
    </table>
</form>