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
						<b> Listado | Precios </b>
					</h4>
				</div>
			</div>

			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Fecha de listado</label>
										<p>{{$dataListaPrecio[0]->created_at}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">

									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Centro de costo</label>
										<p>{{$dataListaPrecio[0]->namecentrocosto}}</p>
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
							<input type="hidden" id="alistamientoId" name="alistamientoId" value="{{$dataListaPrecio[0]->id}}">
							<div class="row g-3">
								<div class="col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Buscar producto</label>
											<select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
												<option value="">Seleccione el producto</option>
												
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label"> </label>
									<select class="form-control form-control-sm select2ProdHijos" name="producto" id="producto" required="">
									</select>
								</div>
								<div class="col-md-3">
									<label for="" class="form-label"></label>
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
						<div class="table-responsive mt-3">
							<table id="tableAlistamiento" class="table table-sm table-striped table-bordered">
								<thead class="text-white" style="background: #3B3F5C">
									<tr>
										<!--th class="table-th text-white">Item</th>-->
										<th class="table-th text-white">#</th>
										<th class="table-th text-white">Codigo</th>
										<th class="table-th text-white">Producto</th>
										
										<th class="table-th text-white text-center">Acciones</th>
									</tr>
								</thead>
								<tbody id="tbodyDetail">

								</tbody>
								<tfoot id="tabletfoot">
									<tr>
										<th></th>
										<th></th>
										<th>Totales</th>
										<th></th>
										<th></th>

										<th class="text-center">

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
<script src="{{asset('code/js/listadeprecio/code-create.js')}}" type="module"></script>
@endsection