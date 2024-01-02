@extends('layouts.theme.app')
@section('content')

<STYLE>
    .input {
        height: 38px;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
    <div class="col-sm-7">

        <div class="widget widget-chart-one">
            <div class="widget-content mt-3">

                <div class="card">
                    <div class="card-body">
                        <form id="form-detail">
                            <input type="hidden" id="saleId" name="saleId" value="{{$venta->id}}">
                            <div class="row">

                                <div class="col-md-6">

                                    <select class="form-control form-control-sm " name="producto" id="producto" required="">
                                        <option value="">PRODUCTO</option>
                                        @foreach($producto as $option)
                                        <option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-3">
                                    <div class="input-group flex-nowrap">
                                        <input type="text" id="codproducto" name="codproducto" class="form-control input">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group flex-nowrap">
                                        <input type="text" id="codbarras" name="codbarras" class="form-control input">
                                    </div>
                                </div>


                            </div>

                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label for="" class="form-label">Precio Venta</label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" id="precioventa" name="precioventa" class="form-control input">
                                        <span class="input-group-text" id="addon-wrapping">$</span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="" class="form-label">KG requeridos</label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" id="kgrequeridos" name="kgrequeridos" class="form-control input" placeholder="EJ: 10,00">
                                        <span class="input-group-text" id="addon-wrapping">KG</span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="" style="margin-top:30px;">
                                        <div class="d-grid gap-2">
                                            <button id="btnAdd" class="btn btn-primary">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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

            <div class="widget-content mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="task-header">
                                    <div class="form-group">
                                        <label for="" class="form-label">Fecha de venta</label>
                                        <p>{{$venta->fecha}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="task-header">
                                    <div class="form-group">
                                        <label for="" class="form-label">Tercero</label>
                                        <p>{{$venta->third->nam}}</p>
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
                            <form method="GET" action="/sale/registrar_pago/3">
                                @csrf              
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success">Facturar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">


</script>

<script>
    $(document).ready(initializeDataTable);

    function initializeDataTable() {
        const table = new DataTable('#tableVentasDet', {
            "bFilter": false,
            "bLengthChange": false,
            "order": [
                [0, 'DESC']
            ],
            columns: [{
                    title: '#'
                },
                {
                    title: 'Producto'
                },
                {
                    title: 'Cant Kg'
                },
                {
                    title: 'Precio'
                },
                {
                    title: 'Iva'
                },
                {
                    title: 'Total'
                },
            ],
        });


        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const send = async (dataform, ruta) => {

            let response = await fetch(ruta, {
                headers: {
                    'X-CSRF-TOKEN': token
                },
                method: 'POST',
                body: dataform
            });
            let data = await response.json();
            //console.log(data);
            return data;
        }

        const saveForm = async (url, form, token) => {
            try {
                const dataform = new FormData(form);
                let response = await fetch(url, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    method: 'POST',
                    body: dataform
                });
                let data = await response.json();
                return data;
            } catch (error) {
                console.log(error);
            }

        }


        /***** GUARDAR DETALLE ******** */

        const btnAdd = document.querySelector("#btnAdd");

        btnAdd.addEventListener("click", (e) => {
            e.preventDefault();
            const formDetail = document.querySelector("#form-detail");

            saveForm('/salesavedetail', formDetail, token).then((result) => {
                if (result.status === 1) {
                    const totalfooter = document.querySelector("#totalfooter");
                    table.row
                        .add([
                            result.sale_id,
                            result.product_id,
                            result.quantity.toLocaleString('co-CO') + ' KG',
                            '$' + result.price.toLocaleString('co-CO'),
                            '$' + result.iva.toLocaleString('co-CO'),
                            '$' + result.total.toLocaleString('co-CO')
                        ])
                        .draw(false);
                    totalfooter.html(result.totalsale.toLocaleString('co-CO'));

                }

                if (result.status === 0) {
                    Swal("Error!", "Tiene campos vacios!", "error");
                }
            });
        });

        var producto = $("#producto");
        producto.select2();

        producto.on("change", (e) => {
            e.preventDefault();
            const formDetail2 = document.querySelector("#form-detail");

            send(formDetail2, '/getproductosv').then((result) => {
                alert(result.id);
            });
        });



    }
</script>