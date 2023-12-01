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
                        <form id="form-detail">
                            <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                            <div class="col-md-8">
                                <label for="" class="form-label">Valor a pagar en efectivo</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input class="form-control form-control-sm" type="text" name="valor_a_pagar_efectivo" id="valor_a_pagar_efectivo" required="">
                                </div>

                                <div class="widget-content mt-3">
                                    <label for="" class="form-label">Valores sugeridos</label>
                                    <div></div>
                                    <button type="button" class="btn btn-primary" onclick="sugerirValor(10000)">10.000</button>
                                    <button type="button" class="btn btn-primary" onclick="sugerirValor(20000)">20.000</button>
                                    <button type="button" class="btn btn-primary" onclick="sugerirValor(50000)">50.000</button>
                                    <button type="button" class="btn btn-primary" onclick="sugerirValor(100000)">100.000</button>
                                </div>
                            </div>

                    </div>
                    <div class="row g-3">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-5">

                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-content mt-1">
            <div class="card">
                <div class="card-body">
                    <form id="form-detail">
                        <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Tarjetas</label>
                                <select class="form-control form-control-sm select2Prod" name="" id="" required="">
                                    <option value="">Seleccione</option>
                                    <option value="credito" selected>CREDITO</option>
                                    <option value="debito">DEBITO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Número de Verificación</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">N°</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Valor</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input class="form-control form-control-sm" type="text" name="valor_a_pagar_tarjeta" id="valor_a_pagar_tarjeta" required="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-content mt-1">
            <div class="card">
                <div class="card-body">
                    <form id="form-detail">
                        <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Otros</label>
                                <select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
                                    <option value="">Seleccione</option>
                                    <option value="WOMPI" selected>WOMPI</option>
                                    <option value="NEQUI">NEQUI</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Número de transacción</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">N°</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Valor</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input class="form-control form-control-sm" type="text" name="valor_a_pagar_otros" id="valor_a_pagar_otros" required="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-content mt-1">
            <div class="card">
                <div class="card-body">
                    <form id="form-detail">
                        <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Credito</label>
                                <select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
                                    <option value="">Seleccione</option>
                                    <option value="0" selected>0</option>
                                    <option value="8">8</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Número de credito</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">N°</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Valor</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input class="form-control form-control-sm" type="text" name="valor_a_pagar_credito" id="valor_a_pagar_credito" required="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
        <div class="widget widget-chart-one">
            <div class="widget-content mt-0">
                <div class="card-body">
                    <form method="GET" action="/sale/registrar_pago/">
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
                                    <td colspan="2">$ {{number_format($arrayTotales['TotalBruto'], 0, ',', '.')}}</td>

                                </tr>
                                <tr>
                                    <th scope="row" style="text-align: left">Descuentos</th>
                                    <td colspan="2">$ {{number_format($descuento, 0, ',', '.')}}</td>

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
                                    <th colspan="2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Guardar e Imprimir</button>
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