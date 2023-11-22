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
            <div class="widget-content mt-3">
                <div class="card">
                    <div class="card-body">
                        <form id="form-detail">
                            <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                            <div class="col-md-8">
                                <label for="" class="form-label">Valor a pagar en efectivo</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input class="form-control form-control-sm" type="text" name="valor_pagado" id="valor_pagado" required="">
                                </div>
                                <div><br></div>
                                <div>
                                    <label for="" class="form-label">Valores sugeridos</label>
                                    <div><br></div>
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
        <div class="widget-content mt-3">
            <div class="card">
                <div class="card-body">
                    <form id="form-detail">
                        <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Tarjetas</label>
                                <select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
                                    <option value="">Seleccione</option>
                                    <option value="credito">CREDITO</option>
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

        <div class="widget-content mt-3">
            <div class="card">
                <div class="card-body">
                    <form id="form-detail">
                        <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Otros</label>
                                <select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
                                    <option value="">Seleccione</option>
                                    <option value="WOMPI">WOMPI</option>
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

        <div class="widget-content mt-3">
            <div class="card">
                <div class="card-body">
                    <form id="form-detail">
                        <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Credito</label>
                                <select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
                                    <option value="">Seleccione</option>
                                    <option value="0">0</option>
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


        <div class="widget widget-chart-one">

            <div class="widget-content mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table id="tableVentasDet" class="table table-sm table-striped table-bordered">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <!--th class="table-th text-white">Item</th>-->
                                        <th class="table-th text-white">1</th>
                                        <th class="table-th text-white">2</th>
                                        <th class="table-th text-white">3</th>
                                        <th class="table-th text-white">4</th>
                                        <th class="table-th text-white">5</th>
                                        <th class="table-th text-white">6</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyDetail">
                                    @foreach($ventasdetalle as $proddetail)
                                    <tr>
                                        <td>{{$proddetail->id}}</td>
                                        <td>{{$proddetail->nameprod}}</td>
                                        <td>{{ number_format($proddetail->quantity, 2, ',', '.')}} KG</td>
                                        <td>${{number_format($proddetail->price, 2, ',', '.')}} </td>
                                        <td>${{number_format($proddetail->iva, 2, ',', '.')}} </td>
                                        <td>${{number_format($proddetail->total, 2, ',', '.')}} </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot id="tabletfoot">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Totales</th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <div id="totalfooter"> {{number_format($arrayTotales['kgTotalventa'], 2, ',', '.')}} </div>
                                        </th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="col-sm-5">
        <div class="widget widget-chart-one">
            <div class="card text-center" style="background: #3B3F5C">
                <div class="m-2">
                    <h4 style="color:white;"><strong>Registrar </s>pagos</strong></h3>
                </div>
            </div>
            <div class="widget-content mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="task-header">
                                    <div class="form-group">
                                        <label for="" class="form-label">Fecha de venta</label>
                                        <p>{{$venta->fecha_venta}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="task-header">
                                    <div class="form-group">
                                        <label for="" class="form-label">Tercero</label>
                                        <p>{{$venta->third->name}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="task-header">
                                    <div class="form-group">
                                        <label for="" class="form-label">Centro de costo</label>
                                        <p>{{$venta->centrocosto->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <form method="GET" action="/sale/registrar_pago/">
                                @csrf
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success">Guardar e Imprimir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="row sales layout-top-spacing">


    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="card text-center" style="background: #3B3F5C">
                <div class="m-2">
                    <h4 style="color:white;"><strong>Registrar </s>pagos</strong></h3>
                </div>
            </div>
            <div class="row g-3 mt-3">

                <div class="col-md-4">
                    <div class="task-header">
                        <div class="form-group">
                            <label for="listaprecio" class="form-label">Lista precios</label>
                            <select class="form-control form-control-sm input" name="listaprecio" id="listaprecio" required>
                                <option value="">Seleccione lista precio</option>

                            </select>
                            <span class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="task-header">
                        <div class="form-group">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-control form-control-sm input" name="categoria" id="categoria" required>
                                <option value="">Seleccione la categoria</option>

                            </select>
                            <span class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="task-header">
                        <div class="form-group">
                            <label for="centrocosto" class="form-label">Centro de costo</label>
                            <select class="form-control form-control-sm input" name="centrocosto" id="centrocosto" required>
                                <option value="">Seleccione el centro de costo</option>

                            </select>
                            <span class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="table-responsive mt-3">
                <form method="POST" action="/updateCcpSwitch">
                    @csrf
                    <table id="tableInventory" class="table table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white text-center">CAT</th>
                                <th class="table-th text-white text-center">ID</th>
                                <th class="table-th text-white text-center">PRODUCTO</th>
                                <th class="table-th text-white text-center">COSTO</th>
                                <th class="table-th text-white text-center">%.U.P</th>
                                <th class="table-th text-white text-center">$.PROYE</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">%IVA</th>
                                <th class="table-th text-white text-center">UTILIDAD</th>
                                <th class="table-th text-white text-center">%.UT</th>
                                <th class="table-th text-white text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/sale/code-app-index.js')}}"></script>

@endsection