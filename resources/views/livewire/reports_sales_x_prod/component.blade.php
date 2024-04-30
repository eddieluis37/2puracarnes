<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>

            <div class="widget-content">
                <div class="">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas del día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div>
                            <!--      <div class="col-sm-6 col-md-3">
                                <h6>Elige Id inicial</h6>
                                <div class="form-group">
                                    <select wire:model="IdInicial" class="form-control">
                                        <option value="0">Elige_1</option>
                                        @foreach($inicio as $user)
                                        <option value="{{$user->id}}">{{$user->id}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h6>Elige Id final</h6>
                                <div class="form-group">
                                    <select wire:model="IdFinal" class="form-control">
                                        <option value="0">Elige</option>
                                        @foreach($final as $user)
                                        <option value="{{$user->id}}">{{$user->id}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-2">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button>
                            </div> -->


                            <div class="col-sm-6 col-md-3">
                                <h6>Fecha y hora inicial</h6>
                                <div class="form-group">
                                    <input type="datetime-local" wire:model="dateFrom" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h6>Fecha y hora final</h6>
                                <div class="form-group">
                                    <input type="datetime-local" wire:model="dateTo" class="form-control">
                                </div>
                            </div>
                            <!--   <div class="col-sm-6 col-md-2">
                                <button wire:click="SalesByDate" class="btn btn-dark btn-block">
                                    Consultar por fecha
                                </button>
                            </div> -->

                            <div class="col-sm-6 col-md-1 mt-2">
                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : '' }}" href="{{ url('report/pdf' . '/' . $IdInicial. '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">
                                    <i class="far fa-file-pdf"></i>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-2 mt-2">
                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : '' }}" href="{{ url('report_sales_x_sc/excel' . '/' . $IdInicial. '/' . $IdFinal) }}" target="_blank">
                                    <i class="far fa-file-excel"></i> Excel
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <!--TABLAE-->
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-success table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">CODE</th>
                                        <th class="table-th text-white text-center" title="Nombre del producto">PRODUCTO</th>
                                        <th class="table-th text-white text-center" title="Nombre de la categoria">CAT</th>
                                        <th class="table-th text-white text-center" title="cantidad_venta">C_VE</th>
                                        <th class="table-th text-white text-center" title="Cantidad nota credito">C_NC</th>
                                        <th class="table-th text-white text-center" title="Cantidad nota debito">C_ND</th>
                                        <th class="table-th text-white text-center" title="cantidad_venta_real">C_REAL</th>
                                        <th class="table-th text-white text-center" title="Dinero_venta_real">$_REAL</th>
                                        <th class="table-th text-white text-center" title="Descuento por producto">D_PROD</th>
                                        <th class="table-th text-white text-center" title="Descuento por cliente">D_CLI</th>
                                        <th class="table-th text-white text-center" title="Valor venta real - descuentos">SUBTOTAL</th>
                                        <th class="table-th text-white text-center" title="Impuesto Saludable">IMP_SALUD</th>
                                        <th class="table-th text-white text-center" title="Impuesto IVA">IVA</th>
                                        <th class="table-th text-white text-center" title="Impuesto RETEICA">RETEICA</th>
                                        <th class="table-th text-white text-center" title="">TOTAL</th>

                                        <th class="table-th text-white text-center">ACCIONES</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) <1) <tr>
                                        <td colspan="7">
                                            <h5>Sin Resultados</h5>
                                        </td>
                                        </tr>
                                        @endif
                                        @foreach($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6>{{$d->product_code}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->product_name}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>{{$d->category_name}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>{{number_format($d->cantidad_venta)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>{{$d->notacredito_quantity}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>{{$d->notadebito_quantity}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>{{$d->cantidad_venta_real}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->dinero_venta_real)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->descuento_producto)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->descuento_cliente)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->sub_total)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->impuesto_salud)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->iva)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>$0</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->total)}}</h6>
                                            </td>

                                            <td class="text-center">
                                                <button type="button" onclick="rePrint({{$d->id}})" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-print"></i>
                                                </button>

                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1"><strong>Total:</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right"><strong>{{ number_format( $this->totals['cantidad_venta'],2) }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format( $this->totals['notacredito_quantity'],2) }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format( $this->totals['notadebito_quantity'],2) }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format( $this->totals['cantidad_venta_real'],2) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['dinero_venta_real']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['descuento_producto']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['descuento_cliente']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['sub_total']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['impuesto_salud']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['iva']) }}</strong></td>
                                        <td class="text-right"><strong>$0</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['total']) }}</strong></td>

                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.sales-detail')
</div>

@section('script')

<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "paging": true, // Habilita la paginación
            "ordering": true, // Habilita la reordenación de columnas
            "searching": true, // Habilita la búsqueda
            "info": true, // Muestra información de la tabla
            "lengthChange": true, // Permite cambiar el número de filas por página
            "dom": 'Bfrtip', // Agrega los botones de exportación
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print' // Agrega los botones de exportación a Excel, CSV, PDF, etc.
            ]
        });
    });
</script>

<script src="{{asset('resources/views/theme/styles.blade.php')}}"></script>
<script src="{{asset('resources/views/theme/scripts.blade.php')}}"></script>
@endsection