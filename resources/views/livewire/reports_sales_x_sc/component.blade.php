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
                                        <th class="table-th text-white text-center">SUBCENTRO</th>
                                        <th class="table-th text-white text-center" title="Número de comprobantes, ventas">NV</th>
                                        <th class="table-th text-white text-center" title="Ventas brutas afectadas con las notas -">VENTA_REAL</th>
                                        <th class="table-th text-white text-center" title="Descuentos por productos y/o clientes">DESCUENTO</th>
                                        <th class="table-th text-white text-center" title="Ventas reales - Descuentos">SUBTOTAL</th>
                                        <th class="table-th text-white text-center" title="Impuesto iva">IMP_IVA</th>
                                        <th class="table-th text-white text-center" title="Impuesto Saludable">IMP_SALUD</th>
                                        <th class="table-th text-white text-center" title="Impuesto Saludable">RETEICA</th>
                                        <th class="table-th text-white text-center" title="Total impuestos">T_IMPUESTOS</th>
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
                                                <h6>{{$d->subcentro}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>{{$d->total_ventas}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->venta_real)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->descuentos)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->subtotal)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->impuesto_IVA)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->impuesto_SALUDABLE)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>$0</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->Total_Impuestos)}}</h6>
                                            </td>
                                            <td class="text-right">
                                                <h6>${{number_format($d->Total)}}</h6>
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
                                        <td class="text-right"><strong>{{ $this->totals['total_ventas'] }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['venta_real']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['descuentos']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['subtotal']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['impuesto_IVA']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['impuesto_SALUDABLE']) }}</strong></td>
                                        <td class="text-right"><strong>$0</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['Total_Impuestos']) }}</strong></td>
                                        <td class="text-right"><strong>${{ number_format( $this->totals['Total']) }}</strong></td>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },

            }

        })


        //eventos
        window.livewire.on('show-modal', Msg => {
            $('#modalDetails').modal('show')
        })
    })

    function rePrint(saleId) {
        window.open("print://" + saleId, '_self').close()
    }
</script>