<div class="row sales layout-top-spacing">
	
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}}</b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-beneficiopollo">Agregar</a>
					</li>
				</ul>
			</div>
			@include('common.searchbox')

			<div class="widget-content">
					
				<div class="table-responsive">
					<table id="beneficiopollos" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">ID</th>
								<th class="table-th text-white">PROVEEDOR</th>
								<th class="table-th text-white text-center">FECHA BENF</th>
								<th class="table-th text-white text-center">LOTE</th>
								<th class="table-th text-white text-center">FACTURA</th>
								<th class="table-th text-white text-center">ACCIONES</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $beneficiore)
							<tr>
								<td><h6>{{number_format($beneficiore->id,0)}}</h6></td>
								<td><h6>{{$beneficiore->third}}</h6></td>

								<td ><h6 class="text-center">{{$beneficiore->fecha_beneficio}}</h6></td>
								<td><h6  class="text-center">{{$beneficiore->lote}}</h6></td>
								<td><h6  class="text-center">{{$beneficiore->factura}}</h6></td>	


								<td class="text-center">
									<a href="javascript:void(0)" 
									wire:click="Edit({{$beneficiore->id}})"
									class="btn btn-dark mtmobile" title="Edit">
										<i class="fas fa-edit"></i>
									</a>

									
									<a href="javascript:void(0)"
									onclick="Confirm('{{$beneficiore->id}}')" 
									 class="btn btn-dark" title="Delete">
										<i class="fas fa-trash"></i>
									</a>				
							

								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$data->links()}}
				</div>				
			</div>
		
		</div>

	</div>

@include('livewire.beneficiopollos.form')
	 
</div>

@include('livewire.beneficiopollos.scripts')

<script>
$(document).ready(function() {
	
    $('#beneficiopollos').DataTable( {

        "order": [[ 0, "desc" ]]
    } );

} );
</script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('beneficiore-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('beneficiore-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('beneficiore-deleted', Msg => {           
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {           
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {           
            $('#theModal').modal('show')
        })
        window.livewire.on('user-withsales', Msg => {           
            noty(Msg)
        })

    });

    function Confirm(id)
    {   

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value){
                window.livewire.emit('deleteRow', id)
                swal.close()
            }

        })
    }
</script>
