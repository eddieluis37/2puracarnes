@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b> Desposte | Pollo</b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../beneficioaves'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>

						<a href="{{ url('utilidadaves/' . $beneficior[0]->id) }}" class="btn btn-dark" title="Utilidad">Utilidad</a>
						</a>
					</li>
				</ul>
			</div>

			<div class=" widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-2">
								<div class="task-header">
									<div class="form-group">
										<label>ID Beneficio</label>
										<p>{{$beneficior[0]->id}} </p>
										<input type="hidden" id="beneficioId" value="{{$beneficior[0]->id}}">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label>Proveedor</label>
										<p>{{$beneficior[0]->name}} </p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Lote</label>
										<p>{{$beneficior[0]->lote}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Factura</label>
										<p>{{$beneficior[0]->factura}} </p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive mt-3">
							<table id="tableDesposteaves" class="table table-sm table-striped table-bordered">
								<thead class="text-white" style="background: #3B3F5C">
									<tr>
										<th class="table-th text-white">Producto</th>
										<th class="table-th text-white">%Desp</th>
										<th class="table-th text-white">PesoKG</th>
										<th class="table-th text-white">P.venta</th>
										<th class="table-th text-white">T.VENTA</th>
										<th class="table-th text-white">%VENTA</th>
										<th class="table-th text-white">C.total</th>
										<th class="table-th text-white">C.KG</th>
										<th class="table-th text-white">UTIL</th>
										<th class="table-th text-white">%.UT</th>
										<th class="table-th text-white text-center">Acciones</th>
									</tr>
								</thead>
								<tbody id="tbody">
									@foreach($desposters as $item)
									<tr>
										<td>{{ $item->products->name }}</td>
										<td>{{ $item->porcdesposte }}%</td>
										<td>
											@if($status == 'true')
											<input type="text" class="form-control-sm" id="{{$item->id}}" value="{{$item->peso}}" placeholder="00" size="4">
											@else
											<p>{{$item->peso}}</p>
											@endif
										</td>
										<td>${{ number_format($item->precio, 0, ',', '.')}}</td>
										<td>${{ number_format($item->totalventa, 0, ',', '.')}}</td>
										<td> {{ $item->porcventa}}%</td>
										<td>${{ number_format($item->costo, 0, ',', '.')}}</td>
										<td>${{ number_format($item->costo_kilo, 0, ',', '.')}}</td>
										<td>${{ number_format($item->utilidad, 0, ',', '.')}}</td>
										<td> {{ number_format($item->porcutilidad, 2, ',', '.')}}%</td>
										<td class="text-center">
											@if($status == 'true')
											<button type="button" name="btnDownReg" data-id="{{$item->id}}" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar">
											</button>
											@else
											<button type="button" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar" disabled>
											</button>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot id="tfoot">
									<tr>
										<td>Totales</td>
										<td>{{round($TotalDesposte)}}%</td>	
										<td>{{number_format($pesoTotalGlobal, 2, ',', '.')}}</td>								
										<td>--</td>										
										<td>${{ number_format($TotalVenta, 0, ',', '.')}}</td>
										<td>{{round($porcVentaTotal)}}%</td>
										<td>${{ number_format($costoTotalGlobal, 0, ',', '.')}}</td>
										<td>--</td>											
										<td>${{number_format($TotalUtilidad, 0, ',', '.')}}</td>										
										<td>{{number_format($PorcUtilidad, 2, ',', '.')}}%</td>						
										<td class="text-center">
											<button type="hidden" id="cargarInventarioBtn"></button>
										</td>
									</tr>
									<tr>
										<td>MERMA</td>
										<td></td>

										<td>{{number_format($Merma, 2, ',', '.')}}</td>
									</tr>
									<tr>
										<td>%.MERMA</td>
										<td></td>

										<td>{{number_format($PorcMerma, 2, ',', '.')}}</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>
@endsection
@section('script')
<script src="{{asset('code/js/aves/desposteaves/code-desposteaves-index.js')}}" type="module"></script>
@endsection