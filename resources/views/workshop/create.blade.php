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
					<b> Taller | Categorías </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../workshop'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
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
										<label for="" class="form-label">Fecha del taller</label>
										<p>{{$dataWorkshop[0]->created_at}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Categoria</label>
										<input type="hidden" id="categoryId" name="categoryId" value="{{$dataWorkshop[0]->categoria_id}}">
										<p>{{$dataWorkshop[0]->namecategoria}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Centro de costo</label>
										<p>{{$dataWorkshop[0]->namecentrocosto}}</p>
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
							<input type="hidden" id="tallerId" name="tallerId" value="{{$dataWorkshop[0]->id}}">
							<div class="row g-3">
								<div class="col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Buscar corte padre</label>
											<input type="hidden" id="meatcutId" name="meatcutId" value="{{$dataWorkshop[0]->meatcut_id}}">
											<input type="hidden" id="productopadreId" name="productopadreId" value="{{$cortes[0]->productopadreId}}">
											<input type="hidden" id="centrocosto" name="centrocosto" value="{{$dataWorkshop[0]->centrocosto_id}}">
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
									<label for="" class="form-label">Peso producto hijo</label>
									<div class="input-group flex-nowrap">
										<input type="hidden" id="porcventa" name="porcventa" value="">
										<input type="text" id="peso_producto_hijo" name="peso_producto_hijo" class="form-control input" placeholder="EJ: 10,00">
										<span class="input-group-text" id="addon-wrapping">KG</span>
									</div>
								</div>
								<div class="col-md-2 text-center">
									<div class="" style="margin-top:30px;">
										<div class="d-grid gap-2">
											<button id="btnAddWorkshop" class="btn btn-primary">Aceptar</button>
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

							<div class="col-md-2">
								<label for="" class="form-label">Stock actual</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="stockCortePadre" name="stockCortePadre" value="{{$cortes[0]->stock}}" class="form-control-sm form-control" placeholder="10,00 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>

							<div class="col-md-2">
								<label for="" class="form-label">Costo KG padre</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="costoKiloPadre" name="costoKiloPadre" value="{{ '$ ' . number_format($cortes[0]->cost, 0) }}" data-id="{{ $cortes[0]->cost }}" class="form-control-sm form-control" placeholder="10,00 kg" readonly>
								</div>
							</div>

							<div class="col-md-2">
								<label for="" class="form-label">Peso prod padre</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="pesoProductoPadre" name="pesoProductoPadre" value="{{$dataWorkshop[0]->peso_producto_padre}}" class="form-control-sm form-control" placeholder="30,00 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>

							<div class="col-md-2">
								<label for="" class="form-label">Costo padre</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="totalValorPadre" name="totalValorPadre" value="{{ '$ ' . number_format($dataWorkshop[0]->total_valor_padre, 0) }}" class="form-control-sm form-control" placeholder="10,00 kg" readonly>
									<!-- <input type="text" id="totalValorPadre" name="totalValorPadre" value="{{$dataWorkshop[0]->total_valor_padre}}" class="form-control-sm form-control" placeholder="30,00 kg" readonly> -->
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>

							<!-- 	<div class="col-md-2">
								<label for="" class="form-label">Merma</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="merma" name="merma" value="{{$dataWorkshop[0]->merma}}" class="form-control-sm form-control" placeholder="180.40 kg" readonly>
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div> -->

						</div>
					</div>
				</div>
			</div>
			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive mt-3">
							<table id="tableWorkshop" class="table table-sm table-striped table-bordered">
								<thead class="text-white" style="background: #3B3F5C">
									<tr>
										<!--th class="table-th text-white">Item</th>-->
										<th class="table-th text-white">Codigo</th>
										<th class="table-th text-white">Producto hijo</th>
										<th class="table-th text-white">Precio_M</th>
										<th class="table-th text-white">Peso-KG hijo</th>
										<th class="table-th text-white">Total</th>
										<th class="table-th text-white">% Venta</th>
										<th class="table-th text-white">Costo</th>
										<th class="table-th text-white">Costo Kg</th>
										<th class="table-th text-white text-center">Acciones</th>
									</tr>
								</thead>
								<tbody id="tbodyDetail">
									@foreach($workshops as $proddetail)
									<tr>
										<td>{{$proddetail->code}}</td>
										<td>{{$proddetail->nameprod}}</td>
										<td>$ {{ number_format($proddetail->precio, 0, ',', '.')}}</td>
										<td>
											@if($status == 'true' && $statusInventory == 'false')
											<input type="text" class="form-control-sm" data-id="{{$proddetail->products_id}}" id="{{$proddetail->id}}" value="{{$proddetail->peso_producto_hijo}}" placeholder="Ingresar" size="4">
											@else
											<p>{{number_format($proddetail->peso_producto_hijo, 2, ',', '.')}} KG</p>
											@endif
										</td>
										<td>$ {{ number_format($proddetail->total, 0, ',', '.')}}</td>
										<td>{{$proddetail->porcventa}} %</td>
										<td>$ {{ number_format($proddetail->costo, 0, ',', '.')}}</td>
										<td>$ {{ number_format($proddetail->costo_kilo, 0, ',', '.')}} </td>
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
										<th>Merma</th>
										<th> {{number_format($arrayTotales['totalMerma'], 2, ',', '.')}} </th>
										<th></th>
										<th> {{number_format($arrayTotales['totalPesoProductoHijo'], 2, ',', '.')}} KG</th>
										<th>$ {{number_format($arrayTotales['totalPrecioVenta'], 0, ',', '.')}} </th>
										<th>U.$ {{number_format($arrayTotales['totalUtilidad'], 0, ',', '.')}} </th>
										<th> {{number_format($arrayTotales['porcUtilidad'], 1, ',', '.')}} %.U</th>

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


@if(Session::has('refresh'))
<script>
	$(document).ready(function() {
		location.reload();
	});
</script>
@endif


<!-- @if(Session::has('refresh'))
    <script>
        if (!sessionStorage.getItem('refreshed')) {
            sessionStorage.setItem('refreshed', 'true');
            location.reload();
        }
    </script>
@endif
 -->
@endsection
@section('script')
<script src="{{asset('code/js/workshop/code-create.js')}}" type="module"></script>
@endsection