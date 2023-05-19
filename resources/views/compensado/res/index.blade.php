@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>Compensado | Listado </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="showModalcreate()" class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-beneficiore" title="Nuevo Beneficio">Agregar</a>
					</li>
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">
					<table id="beneficiores" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">Item</th>
								<th class="table-th text-white">Fecha</th>
								<th class="table-th text-white">Categoria</th>
								<th class="table-th text-white">Proveedor</th>
								<th class="table-th text-white ">Centro de costo</th>
								<th class="table-th text-white text-center">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>2</td>
								<td>5/18/2023</td>
								<td>Res</td>
								<td>rogercode</td>
								<td>centro de costo</td>
								<td class="text-center">
										<a href="compensado/create/1" class="btn btn-dark" title="Despostar" >
											<i class="fas fa-search"></i>
										</a>
										<button class="btn btn-dark" title="Borrar Beneficio" >
											<i class="fas fa-trash"></i>
										</button>
								</td>
							</tr>
							<tr>
								<td>1</td>
								<td>5/18/2023</td>
								<td>Res</td>
								<td>rogercode</td>
								<td>centro de costo</td>
								<td class="text-center">
										<a href="compensado/create/1" class="btn btn-dark" title="Despostar" >
											<i class="fas fa-search"></i>
										</a>
										<button class="btn btn-dark" title="Borrar Beneficio" >
											<i class="fas fa-trash"></i>
										</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="modal-create-beneficiore" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content bg-default">
				<div class="modal-header">
					<h4 class="modal-title">Crear Compensado</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
				</div>
				 <div class="modal-body">
					<form action="" id="form-compensado-res">
						@include('compensado.modal_create')
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnAddCompensadoRes" class="btn btn-primary">Aceptar</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/inventory/rogercode-res-index.js')}}"></script>
@endsection