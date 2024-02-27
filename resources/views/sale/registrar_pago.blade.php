@extends('layouts.theme.app')
@section('content')
<style>
    .table-totales {
        /*border: 2px solid red;*/
    }

    .table-totales,
    th,
    td {
        border: 1px solid #DCDCDC;
    }

    .table-inventario,
    th,
    td {
        border: 1px solid #DCDCDC;
        text-align: center;
    }

    .input {
        height: 38px;
    }

    td {
        text-align: right;
        font-weight: bold;
        color: black;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row sales layout-top-spacing">
    <div class="col-sm-7">

        <div class="widget widget-chart-one">
            <div class="card text-center" style="background: #3B3F5C">
                <div class="m-2">
                    <h4 style="color:white;"><strong>Registrar </s>pagos</strong></h3>
                </div>
            </div>
            <div class="widget-content mt-1">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <fieldset name="personal">
                                <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                                <div class="col-md-8">
                                    <label for="" class="form-label">Valor a pagar en efectivo</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping">$</span>
                                        <input class="form-control form-control-sm" type="text" name="valor_a_pagar_efectivo" id="valor_a_pagar_efectivo" value="0">
                                    </div>
<!-- 
                                    <div class="widget-content mt-3">
                                        <label for="" class="form-label">Valores sugeridos</label>
                                        <div></div>
                                        <button type="bFutton" class="btn btn-primary" onclick="sugerirValor(10000)">10.000</button>
                                        <button type="button" class="btn btn-primary" onclick="sugerirValor(20000)">20.000</button>
                                        <button type="button" class="btn btn-primary" onclick="sugerirValor(50000)">50.000</button>
                                        <button type="button" class="btn btn-primary" onclick="sugerirValor(100000)">100.000</button>
                                    </div> -->
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content mt-1">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label">Tarjetas</label>
                            <select class="form-control form-control-sm input" name="forma_pago_tarjeta_id" id="forma_pago_tarjeta_id">
                                <option value="">Seleccione medio de pago</option>
                                @foreach($forma_pago_tarjeta as $formaPagoTarjeta)
                                <option value="{{$formaPagoTarjeta->id}}" {{ $formaPagoTarjeta->id == 0 ? 'selected' : '' }}>{{$formaPagoTarjeta->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Código de Verificación</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">N°</span>
                                <input type="text" id="codigo_pago_tarjeta" name="codigo_pago_tarjeta" class="form-control input" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Valor</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">$</span>
                                <input class="form-control form-control-sm" type="text" name="valor_a_pagar_tarjeta" id="valor_a_pagar_tarjeta" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content mt-1">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label">Otros</label>
                            <select class="form-control form-control-sm input" name="forma_pago_otros_id" id="forma_pago_otros_id">
                                <option value="">Seleccione la forma de pago</option>
                                @foreach($forma_pago_otros as $formaPagoOtros)
                                <option value="{{$formaPagoOtros->id}}" {{ $formaPagoOtros->id == 0 ? 'selected' : '' }}>{{$formaPagoOtros->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Código de transacción</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">N°</span>
                                <input type="text" id="codigo_pago_otros" name="codigo_pago_otros" class="form-control input" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Valor</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">$</span>
                                <input class="form-control form-control-sm" type="text" name="valor_a_pagar_otros" id="valor_a_pagar_otros" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content mt-1">
            <div class="card">
                <div class="card-body">

                    <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                    <input type="hidden" id="name_cliente" name="name_cliente" value="{{$venta->third->name}}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label">Credito</label>
                            <select class="form-control form-control-sm input" name="forma_pago_credito_id" id="forma_pago_credito_id">
                                <option value="">Seleccione forma de pago</option>
                                @foreach($forma_pago_credito as $formaPagoCredito)
                                <option value="{{$formaPagoCredito->id}}" {{ $formaPagoCredito->id == 0 ? 'selected' : '' }}>{{$formaPagoCredito->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Código de credito</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">N°</span>
                                <input type="text" id="codigo_pago_credito" name="codigo_pago_credito" class="form-control input" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Valor</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">$</span>
                                <input class="form-control form-control-sm" type="text" name="valor_a_pagar_credito" id="valor_a_pagar_credito" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
        <div class="widget widget-chart-one">
            <div class="widget-content mt-0">
                <div class="card-body">

                    <input type="hidden" id="porc_descuento" name="porc_descuento" value="{{$dataVenta[0]->vendedor_name}}" data-id="">

                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: left; vertical-align: middle;">Cliente</th>
                                <th scope="col" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{Str::limit($venta->third->name, 28)}}</th>
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

                                <td style="text-align: left">{{Str::limit($dataVenta[0]->vendedor_name, 26)}}</td>

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
                                <th scope="row" style="text-align: left">ImpSaludable</th>
                                <td colspan="2">$ {{number_format($arrayTotales['TotalOtroImpuesto'], 0, ',', '.')}}</td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Valor_a_Pagar</th>
                                <td colspan="2">
                                    <input type="text" id="valor_a_pagar" name="valor_a_pagar" value="$ {{number_format($arrayTotales['TotalValorAPagar'], 0, ',', '.')}}" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <th scope="row" style="text-align: left">Valor_Pagado</th>
                                    <td colspan="2" style="text-align: right">$ <input type="text" name="valor_pagado" id="valor_pagado" value="valorPagado" style="text-align: right; font-weight: bold; color: black" readonly></td>

                                </div>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Cambio</th>
                                <td colspan="2" style="text-align: right">$ <input type="text" name="cambio" id="cambio" value="valorCambio" style="text-align: right; font-weight: bold; color: black" readonly></td>

                            </tr>

                            </fieldset>
                        </tbody>
                        <tfoot>
                            <tr>
                                <!--   <th class="text-center">
                                   <form method="GET" action="">
                                        @csrf
                                        <div class="text-center mt-1">
                                            <button type="submit" class="btn btn-success">Pagar</button>
                                        </div>
                                    </form> 
                                </th>-->
                                <th colspan="2">
                                    <div class="form-group">
                                   
                                        <button type="submit" class="btn btn-success" id="btnGuardar" disabled target="_blank">Guardar e imprimir</button>
                                        <button type="button" class="btn btn-primary" onclick="history.back()">Volver</button>
                                    </div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  <td colspan="2">$ {{number_format($dataVenta[0]->total_valor_a_pagar, 0, ',', '.')}}</td> -->
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/sale/code-app-index.js')}}"></script>
<script src="{{asset('rogercode/js/sale/code-formulas.js')}}"></script>
@endsection