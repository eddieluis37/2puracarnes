@extends('layouts.theme.app')
@section('content')
<style>
	.input {
		height: 38px;
	}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<form id="form-detail" method="POST" action="registrar_notacredito/{{$id}}">
		<div class="col-sm-12">
			<div class="widget widget-chart-one">
				<div class="widget-heading">
					<h4 class="card-title">
						<b> Notacredito | Crear </b>
					</h4>
					<ul class="tabs tab-pills">
						<li>
							<a href="javascript:void(0)" onclick="window.location.href = '../../notacredito'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
						</li>
					</ul>
				</div>

				<div class="widget-content mt-3">
					<div class="card">
						<div class="card-body">
							<div class="row g-3">
								<div class="col-md-3">
									<div class="task-header">
										<div class="form-group">
											<label for="date1" class="form-label">Fecha nota credito</label>
											<input type="date" class="form-control" name="fecha" id="fecha" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Tipo notacredito</label>
											<select class="form-control selectProvider" name="tipo" id="tipo" required="">
												<option value="DEVOLUCION">DEVOLUCION</option>
												<option value="ANULACION">ANULACION</option>
												<option value="REBAJA">REBAJA</option>
												<option value="DESCUENTO">DESCUENTO</option>
												<option value="RESCISION">RESCISION</option>
												<option value="OTROS">OTROS</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Centro de costo</label>
											<p>{{$datacompensado[0]->namecentrocosto}}</p>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Cliente</label>
											<p>{{$datacompensado[0]->namethird}}</p>
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

							<input type="hidden" id="ventaId" name="ventaId" value="{{$id}}">
							<input type="hidden" id="regdetailId" name="regdetailId" value="0">
							<div class="row g-3">
								<div class="col-md-3">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Buscar producto</label>
											<input type="hidden" id="centrocosto" name="centrocosto" value="{{$datacompensado[0]->centrocosto_id}}" data-id="{{$datacompensado[0]->centrocosto_id}}">
											<input type="hidden" id="cliente" name="cliente" value="{{$datacompensado[0]->third_id}}" data-id="{{$datacompensado[0]->third_id}}">
											<input type="hidden" id="porc_descuento_cliente" name="porc_descuento_cliente" value="{{$datacompensado[0]->porc_descuento_cliente}}" data-id="{{$datacompensado[0]->porc_descuento_cliente}}">
											<select class="form-control form-control-sm select2Prod" name="producto" id="producto">
												<option value="">Seleccione el producto</option>
												@foreach ($prod as $p)
												<option value="{{$p->id}}">{{$p->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label">Precio venta</label>
									<div class="input-group flex-nowrap">
										<span class="input-group-text" id="addon-wrapping">$</span>
										<input type="text" id="price" name="price" class="form-control input" placeholder="">
									</div>
								</div>

								<div class="col-md-3">
									<label for="" class="form-label">IVA</label>
									<div class="input-group flex-nowrap">

										<input type="text" id="porc_iva" name="porc_iva" class="form-control input" placeholder="">
										<span class="input-group-text" id="addon-wrapping">%</span>
									</div>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label">I.S</label>
									<div class="input-group flex-nowrap">

										<input type="text" id="porc_otro_impuesto" name="porc_otro_impuesto" class="form-control input" placeholder="">
										<span class="input-group-text" id="addon-wrapping">%</span>
									</div>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label">Descuento</label>
									<div class="input-group flex-nowrap">
										<input type="text" id="porc_descuento" name="porc_descuento" class="form-control input" placeholder="">
										<span class="input-group-text" id="addon-wrapping">%</span>
									</div>
								</div>

								<div class="form-group row" style="margin-top:3px; margin-left:3px">

									<div class="col-md-7">
										<label for="" class="form-label">Peso KG</label>
										<div class="input-group flex-nowrap"">
										<input type=" text" id="quantity" name="quantity" class="form-control input" placeholder="EJ: 10,00">
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>

									<div class="col-md-3">
										<div class="" style="margin-top:30px;">
											<div class="d-grid gap-2">
												<button id="btnAdd" class="btn btn-primary">Añadir</button>
											</div>
										</div>
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
							<table id="tableDespostere" class="table table-sm table-striped table-bordered">
								<thead class="text-white" style="background: #3B3F5C">
									<tr>
										<th class="table-th text-white">Producto</th>
										<th class="table-th text-white">Cant</th>
										<th class="table-th text-white">Valor.U</th>
										<th class="table-th text-white">%Des</th>
										<th class="table-th text-white">Des</th>
										<th class="table-th text-white">{{$datacompensado[0]->porc_descuento_cliente}}%DCl</th>
										<th class="table-th text-white">Total.B</th>
										<th class="table-th text-white">%IVA</th>
										<th class="table-th text-white">IVA</th>
										<th class="table-th text-white">%I.S</th>
										<th class="table-th text-white">I.S</th>

										<th class="table-th text-white">Total</th>
										<th class="table-th text-white text-center">Acciones</th>
									</tr>
								</thead>
								<tbody id="tbodyDetail">
									@foreach($detalle as $proddetail)
									<tr>
										<!--td>{{$proddetail->id}}</td-->

										<td>{{$proddetail->nameprod}}</td>
										<td>{{ number_format($proddetail->quantity, 2, ',', '.')}}KG</td>
										<td>${{ number_format($proddetail->price, 0, ',', '.')}}</td>
										<td>{{$proddetail->porc_desc}}%</td>
										<td>${{ number_format($proddetail->descuento, 0, ',', '.')}}</td>
										<td>${{ number_format($proddetail->descuento_cliente, 0, ',', '.')}}</td>
										<td>${{ number_format($proddetail->total_bruto, 0, ',', '.')}}</td>
										<td>{{$proddetail->porc_iva}}%</td>
										<td>${{ number_format($proddetail->iva, 0, ',', '.')}}</td>
										<td>{{$proddetail->porc_otro_impuesto}}%</td>
										<td>${{ number_format($proddetail->otro_impuesto, 0, ',', '.')}}</td>
										<td>${{ number_format($proddetail->total, 0, ',', '.')}}</td>
										<td class="text-center">
											@if($status == true)
											<button class="btn btn-dark fas fa-edit" name="btnEdit" data-id="{{$proddetail->id}}" title="Editar">
											</button>
											<button class="btn btn-dark fas fa-trash" name="btnDown" data-id="{{$proddetail->id}}" title="Borrar">
											</button>
											@else
											<button class="btn btn-dark fas fa-edit" name="btnEdit" title="Editar" disabled>
											</button>
											<button class="btn btn-dark fas fa-trash" name="btnDown" title="Borrar" disabled>
											</button>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot id="tabletfoot">
									<tr>
										<th>Totales</th>
										<th></th>
										<th></th>
										<td></td>
										<th></th>
										<th></th>
										<th>${{number_format($arrayTotales['TotalBruto'], 0, ',', '.')}} </th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<th>${{number_format($arrayTotales['TotalValorAPagar'], 0, ',', '.')}} </th>

										</th>
									</tr>
								</tfoot>
							</table>
							<th class="text-center">
								@csrf
								<div class="text-center mt-1">
									<button type="submit" class="btn btn-success">Afectar</button>
								</div>
	</form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/notacredito/rogercode-create.js')}}" type="module"></script>
@endsection