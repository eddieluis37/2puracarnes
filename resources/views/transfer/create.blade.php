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
			<div class="row">
				<div class="col-sm-5">
					<h4 class="">
						<b> Traslado | Categoria </b>
					</h4>
				</div>
			</div>

			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Fecha de traslado</label>
										<p>{{$dataTransfer[0]->created_at}}</p>
									</div>
								</div>
							</div>
						
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Centro de origen</label>
										<input type="hidden" id="centrocostoOrigen" name="centrocostoOrigen" value="{{$dataTransfer[0]->centrocostoOrigen_id}}">
										<p>{{$dataTransfer[0]->namecentrocostoOrigen}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Centro de destino</label>
										<input type="hidden" id="centrocostoDestino" name="centrocostoDestino" value="{{$dataTransfer[0]->centrocostoDestino_id}}">
										<p>{{$dataTransfer[0]->namecentrocostoDestino}}</p>
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
							<input type="hidden" id="transferId" name="transferId" value="{{$dataTransfer[0]->id}}">
							<div class="row g-3"> <!-- Añadido justify-content-center para centrar los campos horizontalmente -->
								<div class="col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Buscar producto</label>
											<input type="hidden" id="centrocostoOrigen" name="centrocostoOrigen" value="{{$dataTransfer[0]->centrocostoOrigen_id}}" data-id="{{$dataTransfer[0]->centrocostoOrigen_id}}">
											<select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
												<option value="">Seleccione el producto</option>
												@foreach ($arrayProductsOrigin as $p)
												<option value="{{$p->id}}">{{$p->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label">KG a trasladar</label>
									<div class="input-group flex-nowrap">
										<input type="text" id="kgrequeridos" name="kgrequeridos" class="form-control input" placeholder="EJ: 10,00 Acepta Coma">
										<span class="input-group-text" id="addon-wrapping">KG</span>
									</div>
								</div>
								<div class="col-md-2 text-center">
									<div class="" style="margin-top:30px;">
										<div class="d-grid gap-2">
											<button id="btnAddTransfer" class="btn btn-primary">Añadir</button>
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
							<div class="col-sm-3">
								<label for="pesoKgOrigen" class="form-label">Tangible origen</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="pesoKgOrigen" name="pesoKgOrigen" value="{{$arrayProductsOrigin[0]->fisico_origen}}" class="form-control-sm form-control" placeholder="180.40 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>
							<div class="col-sm-3">
								<label for="stockOrigen" class="form-label">Stock actual origen</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="stockOrigen" name="stockOrigen" value="{{$arrayProductsOrigin[0]->stock_origen}}" class="form-control-sm form-control" placeholder="10.00 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>
							<div class="col-sm-3">
								<label for="pesoKgDestino" class="form-label">Tangible destino</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="pesoKgDestino" name="pesoKgDestino" value="{{$arrayProductsDestination[0]->fisico_destino}}" class="form-control-sm form-control" placeholder="180.40 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>
							<div class="col-sm-3">
								<label for="stockDestino" class="form-label">Stock actual destino</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="stockDestino" name="stockDestino" value="{{$arrayProductsDestination[0]->stock_destino}}" class="form-control-sm form-control" placeholder="10.00 kg" readonly>
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
							<table id="tableTransfer" class="table table-sm table-striped mt-1 table-bordered"> <!-- http://2puracarnes.test:8080/transfer/create/1  code-create.js showData -->
								<thead class="text-white" style="background: #3B3F5C">
									<tr>
										<!--th class="table-th text-white">Item</th>-->
										<!-- <th class="table-th text-white">#</th> -->
										<th class="table-th text-white">Cod</th>
										<th class="table-th text-white">Producto</th>
										<th class="table-th text-white">Stk act origen</th>
										<th class="table-th text-white">kg a trasladar</th>
										<th class="table-th text-white">New stk origen</th>
										<th class="table-th text-white">Stk act destino</th>
										<th class="table-th text-white">New stk destino</th>
										<th class="table-th text-white text-center">Acciones</th>
									</tr>
								</thead>
								<tbody id="tbodyDetail">
									@foreach($transfers as $proddetail)
									<tr>
										<!-- <td>{{$proddetail->id}}</td> -->
										<td>{{$proddetail->code}}</td>
										<td>{{$proddetail->nameprod}}</td>
										<td>{{ number_format($proddetail->stock, 2, ',', '.')}} KG</td>
										<td>
											@if($status == 'true' && $statusInventory == 'false')
											<input type="text" class="form-control-sm" data-id="{{$proddetail->products_id}}" id="{{$proddetail->id}}" value="{{$proddetail->kgrequeridos}}" placeholder="Ingresar" size="10">
											@else
											<p>{{number_format($proddetail->kgrequeridos, 2, ',', '.')}} KG</p>
											@endif
										</td>

										<td>{{ number_format($proddetail->nuevo_stock_origen, 2, ',', '.')}} KG</td>

										<td>{{ number_format($proddetail->actual_stock_destino, 2, ',', '.')}} KG</td>

										<td>{{ number_format($proddetail->nuevo_stock_destino, 2, ',', '.')}} KG</td>
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
										<th> {{number_format($arrayTotales['kgTotalRequeridos'], 2, ',', '.')}} KG</th>
										<th> {{number_format($arrayTotales['newTotalStock'], 2, ',', '.')}} KG</th>
										<th></th>
										<th></th>										
										<th class="text-center">
											@if($dataTransfer[0]->inventario == 'pending')
											<button class="btn btn-success btn-sm" id="addShopping">Afectar inventario</button>
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
<script src="{{asset('code/js/transfer/code-create.js')}}" type="module"></script>
@endsection