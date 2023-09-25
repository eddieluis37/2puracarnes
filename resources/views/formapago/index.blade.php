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
					<b>Formas de pago | Listado </b>
					<table id="example" class="table table-striped mt-1"></table>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)"  class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-formapago" title="Nueva Forma de Pago">Agregar</a>
					</li>
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">
				    
					<table id="tableFpago" class="table table-striped mt-1">
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
							@foreach ($formapagos as $fp)                        
							<tr>
							    <td>{{ $fp->id }}</td>                                                       
								<td>{{ $fp->codigo }}</td>
								<td>{{ $fp->nombre }}</td>
								<td>{{ $fp->tipoformapago }}</td>
								<td>{{ $fp->cuenta }}</td>
								<td>
								    <div class="text-center">
										<a href="" id="editformapago" data-toggle="modal"  class="btn btn-dark "
										data-target='#editfp_modal' data-id="{{$fp->id}}">
											<i class="fas fa-edit"></i>
										</a>
										
										<a href ="{{route('formapago.delete', $fp->id)}}"  class="btn btn-dark " onclick="return confirm('Desea eliminar el registro?')" >
										   <i class="fas fa-trash"></i>
										</a>	
									
									</div>
								</td>
							</tr> 						                 
							@endforeach
						</tbody>
					</table>
					@include('formapago.modal_update')			
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="modal-create-formapago" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
					<form action="{{ route('formapago.save') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
						<div class="modal-header">
							<h4 class="modal-title">Crear Forma de Pago</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
				 		<div class="modal-body">
						    @include('formapago.modal_create')									
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
$('body').on('click', '#editformapago', function (event) {
    event.preventDefault();
    var id = $(this).data('id');
	
	$.get('formapago' + id + '/edit', function (data) {  
		
		$('#formapagodata').attr("action",data.dataurl); 	
		$('#formapagodata').attr("method","POST"); 	
		$('#formapagodata').attr("enctype","multipart/form-data"); 		
         $('#editfp_modal').modal('show'); 		     
         $('#codigo').val(data.data.codigo);
		 $('#nombre').val(data.data.nombre);
		 $('#tipoformapago').val(data.data.tipoformapago);
		 $('#cuenta').val(data.data.cuenta);
     })
});
}); 
</script>


<script>


$(document).ready(initializeDataTable);
 function initializeDataTable() {
	new DataTable('#tableFpago', {
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
