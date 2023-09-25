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
					<b>Parametros Contables | Listado </b>
					<table id="example" class="table table-striped mt-1"></table>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)"  class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-parametrocontable" title="Nuevo Parámetro Contable">Agregar</a>
					</li>
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">
				    
					<table id="tableParametro" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">col1</th>
								<th class="table-th text-white">col1</th>
								<th class="table-th text-white ">col1</th>
								<th class="table-th text-white ">col1</th>
								<th class="table-th text-white ">col1</th>
								<th class="table-th text-white ">col1</th>								
							</tr>
						</thead>
						<tbody>							
							@foreach ($parametrocontables as $pc)                        
							<tr>
							    <td>{{ $pc->id }}</td>                                                       
								<td>{{ $pc->codigo }}</td>
								<td>{{ $pc->nombre }}</td>
								<td>{{ $pc->tipoparametro }}</td>
								<td>{{ $pc->cuenta }}</td>
								<td>
								    <div class="text-center">
										<a href="" id="editparametrocontable" data-toggle="modal"  class="btn btn-dark "
										data-target='#editpc_modal' data-id="{{$pc->id}}">
											<i class="fas fa-edit"></i>
										</a>
										
										<a href ="{{route('parametrocontable.delete', $pc->id)}}"  class="btn btn-dark " onclick="return confirm('Desea eliminar el registro?')" >
										   <i class="fas fa-trash"></i>
										</a>	
									
									</div>
								</td>
							</tr> 						                 
							@endforeach
						</tbody>
					</table>
					@include('parametrocontable.modal_update')			
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="modal-create-parametrocontable" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
					<form action="{{ route('parametrocontable.save') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
						<div class="modal-header">
							<h4 class="modal-title">Crear Parámetro Contable</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
				 		<div class="modal-body">
						    @include('parametrocontable.modal_create')									
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

$(document).ready(function () {
$('body').on('click', '#editparametrocontable', function (event) {
    event.preventDefault();
    var id = $(this).data('id');
	$.get('parametrocontable' + id + '/edit', function (data) {  
		
		$('#parametrocontabledata').attr("action",data.dataurl); 	
		$('#parametrocontabledata').attr("method","POST"); 	
		$('#parametrocontabledata').attr("enctype","multipart/form-data"); 		

         $('#editpc_modal').modal('show'); 		     
         $('#codigo').val(data.data.codigo);
		 $('#nombre').val(data.data.nombre);
		 $('#tipoparametro').val(data.data.tipoparametro);
		 $('#cuenta').val(data.data.cuenta);
     })
});
}); 
</script>


<script>


$(document).ready(initializeDataTable);
 function initializeDataTable() {
	new DataTable('#tableParametro', {
		columns: [
			{ title: '#' },
			{ title: 'Código' },
			{ title: 'Nombre' },
			{ title: 'Tipo' },
			{ title: 'Cuenta' },
			{ title: 'Acciones' }
		],
		
	});
}
</script>
