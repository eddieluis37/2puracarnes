@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b> Utilidad | Pollo</b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../beneficioaves'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
					
						<a href="{{ url('desposteaves/' . $beneficior[0]->id) }}" class="btn btn-dark" title="Despresar">Despresar</a>
					</a>
					</li>
				</ul>
			</div>

			<div class="widget-content mt-3">
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
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Peso pie planta</label>
										<p>{{number_format($beneficior[0]->peso_pie_planta, 0, ',', '.')}} KG</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Promedio canal fria</label>
										<p>{{number_format($beneficior[0]->promedio_canal_fria_sala, 3, ',', '.')}} KG</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Kilos menudencias</label>
										<p>{{number_format($beneficior[0]->menudencia_pollo_kg, 3, ',', '.')}} KG</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Mollejas/Corazonez</label>
										<p>{{number_format($beneficior[0]->mollejas_corazones_kg, 3, ',', '.')}} KG</p>
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
										<th class="table-th text-white" title="Productos">Productos</th>
										<th class="table-th text-white" title="kilos">KILOS</th>
										<th class="table-th text-white" title="porcentaje_participacion">%PAR</th>
										<th class="table-th text-white" title="costo_unitario">C.UNIT</th>
										<th class="table-th text-white" title="costo_real">C.REAL</th>
										<th class="table-th text-white" title="precio_kg_venta">P.KG.V</th>
										<th class="table-th text-white" title="ingresos_totales">IN.T</th>
										<th class="table-th text-white" title="participacion_venta">PAR.V</th>
										<th class="table-th text-white" title="utilidad_dinero">$.UT</th>
										<th class="table-th text-white" title="porcentaje_utilidad">%.UT</th>
										<th class="table-th text-white" title="dinero_kilo">$.KILO</th>
										<th class="table-th text-white text-center">Acción</th>
									</tr>
								</thead>
								<tbody id="tbody">
									@foreach($desposters as $item)
									<tr>
										<td> {{ $item->product_name }}</td>
										<td> {{ $item->kilos }}</td>
										<td> {{ $item->porcentaje_participacion }}%</td>
										<td>${{ number_format($item->costo_unitario, 0, ',', '.')}}</td>
										<td>${{ number_format($item->costo_real, 0, ',', '.')}}</td>
										<td>
											@if($status == 'true')
											<input type="text" class="form-control-sm" id="{{$item->id}}" value="{{$item->precio_kg_venta}}" placeholder="00" size="5">
											@else
											<p>{{$item->precio_kg_venta}}</p>
											@endif
										</td>
										<td>${{ number_format($item->ingresos_totales, 0, ',', '.')}}</td>
										<td> {{ number_format($item->participacion_venta, 2, ',', '.')}}%</td>
										<td>${{ number_format($item->utilidad_dinero, 0, ',', '.')}}</td>
										<td> {{ number_format($item->porcentaje_utilidad, 2, ',', '.')}}%</td>
										<td>${{ number_format($item->dinero_kilo, 0, ',', '.')}}</td>
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
										<td>{{number_format($TotalKilos, 2, '.', '.')}}</td>
										<td>{{number_format($TotalPorcPart, 2, ',', '.')}}%</td>
										<td>${{ number_format($TotalCostoReal / $TotalKilos, 0, ',', '.')}}</td>
										<td>${{ number_format($TotalCostoReal, 0, ',', '.')}}</td>
										<td>--</td>
										<td>${{ number_format($TotalingresosTotales, 0, ',', '.')}}</td>
										<td> {{ number_format($TotalingresosTotales / $TotalingresosTotales, 2, ',', '.')}}%</td>
										<td>${{ number_format($TotalingresosTotales - $TotalCostoReal, 0, ',', '.')}}</td>
										<td>--</td>
										<td>${{ number_format(($TotalingresosTotales - $TotalCostoReal)/$TotalKilos, 0, ',', '.')}}</td>
										<td class="text-center">
											<button type="hidden" id="cargarInventarioBtn"></button>
										</td>
									</tr>
								</tfoot>
							</table>
							<div class="widget-heading">
				<h4 class="card-title">
					<b></b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
					
					
						<a href="{{ url('desposteaves/' . $beneficior[0]->id) }}" class="btn btn-dark" title="Despresar">Despresar</a>
					</a>
					</li>
				</ul>
			</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>
@endsection
@section('script')
<script src="{{asset('code/js/aves/utilidadaves/code-utilidadaves-index.js')}}" type="module"></script>
@endsection