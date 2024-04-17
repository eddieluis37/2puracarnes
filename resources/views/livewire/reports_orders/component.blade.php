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
                                <h6>Elige Id inicial</h6>
                                <div class="form-group">
                                    <select wire:model="userId1" class="form-control">
                                        <option value="0">Elige</option>
                                        @foreach($inicio as $user)
                                        <option value="{{$user->id}}">{{$user->id}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h6>Elige Id final</h6>
                                <div class="form-group">
                                    <select wire:model="userId2" class="form-control">
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
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : '' }}" href="{{ url('report/pdf' . '/' . $userId1 . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">PDF</a>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : '' }}" href="{{ url('report_order/excel' . '/' . $userId1 . '/' . $userId2) }}" target="_blank">Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <!--TABLAE-->
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-success table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">#ID</th>
                                        <th class="table-th text-white text-center">SUBCENTRO</th>
                                        <th class="table-th text-white text-center">VENDEDOR</th>
                                        <th class="table-th text-white text-center">CLIENTE</th>
                                        <th class="table-th text-white text-center">IDENTIDAD</th>
                                        <th class="table-th text-white text-center">DIR_ENTREGA</th>
                                        <th class="table-th text-white text-center">TELEFONO</th>
                                        <th class="table-th text-white text-center" title="Horario de entrega">H_ENTREGA</th>
                                        <th class="table-th text-white text-center">ALISTADOR</th>
                                        <th class="table-th text-white text-center">OBSERVACIONES</th>
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
                                                <h6>{{$d->subcentro}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->vendedor}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->cliente}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->identification}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->direccion_envio}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->celular}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>Día:{{\Carbon\Carbon::parse($d->fecha_entrega)->format('d-m')}}</h6>                                              
                                                <h6>{{$d->hora_inicial_entrega}}</h6>
                                                <h6>{{$d->hora_final_entrega}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->alistador}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->observacion}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <!--   <button wire:click.prevent="getDetails({{$d->id}})" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button> -->
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