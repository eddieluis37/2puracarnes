@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
 
<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>Ventas | Listado </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
					<a href="javascript:void(0)"  class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-venta" title="Nuevo Parámetro Contable">Agregar</a>
					</li>
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">
					<table id="tableVenta" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">#</th>
								<th class="table-th text-white">1</th>
								<th class="table-th text-white">2</th>
								<th class="table-th text-white ">3</th>
								<th class="table-th text-white ">4</th>
								<th class="table-th text-white ">5</th>
								<th class="table-th text-white ">6</th>								
								<th class="table-th text-white text-center">Acciones</th>
							</tr>
						</thead>
						<tbody>							
							@foreach ($ventas as $venta)                        
							<tr>
							    <td>{{ $venta->id }}</td>                                                       
								<td>{{ $venta->fecha }}</td>
								<td>{{ $venta->consecutivo }}</td>
								<td>{{ $venta->centrocosto->name }}</td>
								<td>{{ $venta->third->name }}</td>
								<td>{{ $venta->total }}</td>
								<td>{{ $venta->status }}</td>
								<td>								

								    <div class="text-center">
									
										<a href ="{{route('sale.create', $venta->id)}}"  class="btn btn-dark " >
										   <i class="fas fa-eye"></i>
										</a>	

										<a href="" id="editventa" data-toggle="modal"  class="btn btn-dark "
											data-target='#editventa_modal' data-id="{{$venta->id}}">
											<i class="fas fa-edit"></i>
										</a>
										
										<a href ="{{route('sale.delete', $venta->id)}}"  class="btn btn-dark " onclick="return confirm('Desea eliminar el registro?')" >
										   <i class="fas fa-trash"></i>
										</a>	
									
									</div>
								</td>
							</tr> 						                 
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="modal-create-venta" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
				    <form action="{{ route('sale.save') }}" method="POST" enctype="multipart/form-data">
					   {{ csrf_field() }}
						<div class="modal-header">
							<h4 class="modal-title">Crear Ventas</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
				 		<div class="modal-body">
							@include('sale.modal_create')
						</div>
						<div class="modal-footer">
							<button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" id="btnAddventa" class="btn btn-primary">Aceptar</button>
						</div>
					</form>
				</fieldset>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


	<!-- modal -->
	<div class="modal fade" id="modal-update-venta" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
					<form id="saledata">
					   {{ csrf_field() }}
						<div class="modal-header">
							<h4 class="modal-title">Editar Ventas</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
				 		<div class="modal-body">
							@include('sale.modal_update')
						</div>
						<div class="modal-footer">
							<button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" id="btnAddventa" class="btn btn-primary">Aceptar</button>
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

$(document).ready(initializeDataTable);
 function initializeDataTable() {
	new DataTable('#tableVenta', {
		columns: [
			{ title: '#' },
			{ title: 'Fecha' },
			{ title: 'Consecutivo' },
			{ title: 'Centro Costo' },
			{ title: 'Cliente' },
			{ title: 'Total' },
			{ title: 'Estado' },
			{ title: 'Acciones' }
		],
		
	});
}
</script>

<script>

$(document).ready(function () {
$('body').on('click', '#editventa', function (event) {
    event.preventDefault();
    var id = $(this).data('id');
	$.get('sale' + id + '/edit', function (data) {  
		
		$('#saledata').attr("action",data.dataurl); 	
		$('#saledata').attr("method","POST"); 	
		$('#saledata').attr("enctype","multipart/form-data"); 		

         $('#modal-update-venta').modal('show'); 		     
         $('#fecha2').val(data.data.fecha);
		 $('#centrocosto2').val(data.data.centrocosto_id);
		 $('#cliente2').val(data.data.third_id);
		 $('#vendedor2').val(data.data.vendedor_id);
		 $('#domiciliario2').val(data.data.domiciliario_id);
     })
});
}); 
</script>