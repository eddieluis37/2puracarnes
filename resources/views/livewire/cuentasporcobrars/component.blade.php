<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el cliente</h6>
                                <div class="form-group">
                                    <select wire:model="userId" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach($terceros as $tercer)
                                        <option value="{{$tercer->id}}">{{$tercer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0"> por hora</option>
                                        <option value="0"> del día</option>
                                        <option value="1"> por fecha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button>

                                <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : '' }}" href="{{ url('reportCxc/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">Generar PDF</a>

                                <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : '' }}" href="{{ url('reportCxc/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">Exportar a Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <!--TABLAE-->
                        <div class="table-responsive">
                            <table class="table table-bordered table striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">#.C</th>
                                        <th class="table-th text-white text-center">CLIENTE</th>
                                        <th class="table-th text-white text-center">FACTURA</th>
                                        <th class="table-th text-white text-center">ESTADO</th>
                                        <th class="table-th text-white text-center">FECHA.V</th>
                                        <th class="table-th text-white text-center">DEUDA.I</th>
                                        <th class="table-th text-white text-center">NC</th>
                                        <th class="table-th text-white text-center">ND</th>
                                        <th class="table-th text-white text-center">REC.CAJA</th>
                                        <th class="table-th text-white text-center">SALDO</th>
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
                                                <h6>{{$d->id}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->identification}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->consecutivo}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    @if($d->status == 0)
                                                    <span class="badge bg-danger">PE</span>
                                                    @elseif($d->status == 1)
                                                    <span class="badge bg-success">NC</span>
                                                    @elseif($d->status == 2)
                                                    <span class="badge bg-success">ND</span>
                                                    @else
                                                    {{$d->status}}
                                                    @endif
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    {{\Carbon\Carbon::parse($d->fecha_vencimiento)->format('d-m-Y')}}
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>${{number_format($d->deuda_inicial)}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>${{number_format($d->deuda_x_cobrar)}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>${{number_format($d->deuda_x_pagar)}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{number_format($d->abono)}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>${{number_format($d->deuda_inicial - $d->abono)}}</h6>
                                            </td>

                                            <td class="text-center">
                                                <button wire:click.prevent="getDetails({{$d->id}})" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                                <button type="button" onclick="rePrint({{$d->id}})" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
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