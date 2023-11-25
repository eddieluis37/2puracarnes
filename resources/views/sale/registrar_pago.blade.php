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
                                <select class="form-control form-control-sm select2Prod" name="valor_a_pagar_tarjeta" id="valor_a_pagar_tarjeta" required="">
                                    <option value="">Seleccione</option>
                                    <option value="credito" selected>CREDITO</option>
                                    <option value="debito">DEBITO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Número de Verificación</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">N°</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="EJ: 369">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Valor</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="EJ: 20.500">
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
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="EJ: 369">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Valor</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="EJ: 20.500">
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
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="EJ: 369">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Valor</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input type="text" id="price" name="price" class="form-control input" placeholder="EJ: 20.500">
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
                <div class="card">
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

                                <td style="text-align: left">{{$venta->third->vendedor}}</td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Total_Bruto</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Descuentos</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">SubTotal</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Total_IVA</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">TotalOtrosImp</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Valor_a_Pagar</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Valor_Pagado</th>
                                <td colspan="2"></td>

                            </tr>
                            <tr>
                                <th scope="row" style="text-align: left">Cambio</th>
                                <td colspan="2"></td>

                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">
                                    <form method="GET" action="/sale/registrar_pago/">
                                        @csrf
                                        <div class="text-center mt-1">
                                            <button type="submit" class="btn btn-success">Guardar e Imprimir</button>
                                        </div>
                                    </form>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/sale/code-app-index.js')}}"></script>

@endsection