@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>Lista de precios | Listado </b>
					<table id="example" class="table table-striped mt-1"></table>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-lista_de_precio" title="Nueva Forma de Pago">Agregar</a>
					</li>
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">

					<table id="tableLPrecio" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">col1</th>
								<th class="table-th text-white">col1</th>
								<th class="table-th text-white ">col1</th>
								<th class="table-th text-white ">col1</th>
								<th class="table-th text-white text-center">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($listaprecios as $lp)
							<tr>
								<td>{{ $lp->id }}</td>
								<td>
									@if($lp->centrocosto)
									{{ $lp->centrocosto->name }}
									@endif
								</td>
								<td>{{ $lp->nombre }}</td>
								<td>{{ $lp->tipo }}</td>
								<td>
									<div class="text-center">
										<a href="" id="editlista_de_precio" data-toggle="modal" class="btn btn-dark " data-target='#editlp_modal' data-id="{{$lp->id}}">
											<i class="fas fa-edit"></i>
										</a>

										<a href="{{route('lista_de_precio.delete', $lp->id)}}" class="btn btn-dark " onclick="return confirm('Desea eliminar el registro?')">
											<i class="fas fa-trash"></i>
										</a>

									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@include('listadeprecio.modal_update')
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="modal-create-lista_de_precio" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
					<form action="{{ route('lista_de_precio.save') }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="modal-header">
							<h4 class="modal-title">Crear lista de precio</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							@include('listadeprecio.modal_create')
						</div>
						<div class="modal-footer">
							<button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" id="btnAddFaster" class="btn btn-primary">Aceptar</button>
						</div>
					</form>
				</fieldset>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script>
	$(document).ready(function() {
		$('body').on('click', '#editlista_de_precio', function(event) {
			event.preventDefault();
			var id = $(this).data('id');

			$.get('lista_de_precio' + id + '/edit', function(data) {

				$('#lista_de_preciodata').attr("action", data.dataurl);
				$('#lista_de_preciodata').attr("method", "POST");
				$('#lista_de_preciodata').attr("enctype", "multipart/form-data");
				$('#editlp_modal').modal('show');
				$('#centro').val(data.data.centrocosto_id);
				$('#nombre').val(data.data.nombre);
				$('#tipo').val(data.data.tipo);
			})
		});
	});
</script>


<script>
	$(document).ready(initializeDataTable);

	function initializeDataTable() {
		new DataTable('#tableLPrecio', {
			columns: [{
					title: '#'
				},
				{
					title: 'Centro'
				},
				{
					title: 'Nombre'
				},
				{
					title: 'Tipo'
				},
				{
					title: 'Acciones'
				}
			],

		});
	}
</script>