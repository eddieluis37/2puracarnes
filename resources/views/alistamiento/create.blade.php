@extends('layouts.theme.app')
@section('content')
<style>
	.input {
		height: 38px;
	}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b> Transformación | Categoria </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../alistamiento'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
					</li>
				</ul>
			</div>
			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Fecha de compra</label>
										<p>{{$dataAlistamiento[0]->created_at}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Categoria</label>
										<input type="hidden" id="categoryId" name="categoryId" value="{{$dataAlistamiento[0]->categoria_id}}">
										<p>{{$dataAlistamiento[0]->namecategoria}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Centro de costo</label>
										<p>{{$dataAlistamiento[0]->namecentrocosto}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="widget-content mt-3" style="{{$display}}">
				<div class="card">
					<div class="card-body">
						<form id="form-detail">
							<input type="hidden" id="alistamientoId" name="alistamientoId" value="{{$dataAlistamiento[0]->id}}">
							<div class="row g-3">
								<div class="col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Buscar corte padre</label>
											<input type="hidden" id="meatcutId" name="meatcutId" value="{{$dataAlistamiento[0]->meatcut_id}}">
											<input type="hidden" id="productopadreId" name="productopadreId" value="{{$cortes[0]->productopadreId}}">
											<input type="hidden" id="centrocosto" name="centrocosto" value="{{$dataAlistamiento[0]->centrocosto_id}}">
											<input type="text" id="productoCorte" name="productoCorte" value="{{$cortes[0]->name}}" class="form-control input" readonly>
											<!--select class="form-control form-control-sm select2Prod" name="productoCorte" id="productoCorte" required="">
											<option value="">Seleccione el producto</option>
											@foreach ($cortes as $p)
											<option data-stock="{{$p->stock}}" value="{{$p->id}}">{{$p->name}}</option>
											@endforeach
					                    </select>-->
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label">Seleccionar hijo </label>
									<select class="form-control form-control-sm select2ProdHijos" name="producto" id="producto" required="">
									</select>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label">KG requeridos</label>
									<div class="input-group flex-nowrap">
										<input type="text" id="kgrequeridos" name="kgrequeridos" class="form-control input" placeholder="EJ: 10,00">
										<span class="input-group-text" id="addon-wrapping">KG</span>
									</div>
								</div>
								<div class="col-md-2 text-center">
									<div class="" style="margin-top:30px;">
										<div class="d-grid gap-2">
											<button id="btnAddAlistamiento" class="btn btn-primary">Aceptar</button>
										</div>
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
						<div class="row">
							<div class="col-md-4">
								<label for="" class="form-label">Stock actual</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="stockCortePadre" name="stockCortePadre" value="{{$cortes[0]->stockPadre}}" class="form-control-sm form-control" placeholder="10,00 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>
							<div class="col-md-4">
								<label for="" class="form-label">Ultimo conteo fisico</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="pesokg" name="pesokg" value="{{$cortes[0]->fisico}}" class="form-control-sm form-control" placeholder="180.40 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>
							<div class="col-md-4">
								<label for="" class="form-label">Nuevo stock</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="newStockPadre" name="newStockPadre" value="{{$dataAlistamiento[0]->nuevo_stock_padre}}" class="form-control-sm form-control" placeholder="30,00 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
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
							<table id="tableAlistamiento" class="table table-sm table-striped table-bordered">
								<thead class="text-white" style="background: #3B3F5C">
									<tr>
										<!--th class="table-th text-white">Item</th>-->
										<th class="table-th text-white">#</th>
										<th class="table-th text-white">Codigo</th>
										<th class="table-th text-white">Producto hijo</th>
										<th class="table-th text-white">Stock actual</th>
										<th class="table-th text-white">Fisico</th>
										<th class="table-th text-white">kg requeridos</th>
										<th class="table-th text-white">Costo</th>
										<th class="table-th text-white">New stock hijo</th>
										<th class="table-th text-white text-center">Acciones</th>
									</tr>
								</thead>
								<tbody id="tbodyDetail">
									@foreach($enlistments as $proddetail)
									<tr>
										<td>{{$proddetail->id}}</td>
										<td>{{$proddetail->code}}</td>
										<td>{{$proddetail->nameprod}}</td>
										<td>{{number_format($proddetail->stockHijo, 2, ',', '.')}}KG</td>
										<td>{{number_format($proddetail->fisico, 2, ',', '.')}}KG</td>
										<td>
											@if($status == 'true' && $statusInventory == 'false')
											<input type="text" class="form-control-sm" data-id="{{$proddetail->products_id}}" id="{{$proddetail->id}}" value="{{$proddetail->kgrequeridos}}" placeholder="Ingresar" size="10">
											@else
											<p>{{number_format($proddetail->kgrequeridos, 2, ',', '.')}}KG</p>
											@endif
										</td>
										<td>${{number_format($proddetail->cost_transformation, 0, ',', '.')}}</td>
										<td>{{number_format($proddetail->newstock, 2, ',', '.')}}KG</td>
										<td class="text-center">
											@if($status == 'true' && $statusInventory == 'false')
											<button type="button" name="btnDownReg" data-id="{{$proddetail->id}}" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar">
											</button>
											@else
											<button type="button" name="" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar" disabled>
											</button>
											@endif
										</td>
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
										<th>{{number_format($arrayTotales['kgTotalRequeridos'], 2, ',', '.')}}KG</th>
										<th>${{number_format($arrayTotales['totalCostTranf'], 0, ',', '.')}}</th>
										<th>{{number_format($arrayTotales['newTotalStock'], 2, ',', '.')}}KG</th>
										<th class="text-center">
											@if($dataAlistamiento[0]->inventario == 'pending')
											<button class="btn btn-success btn-sm" id="addShopping">Cargar al inventario</button>
											@endif
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
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/alistamiento/rogercode-create.js')}}" type="module"></script>
@endsection