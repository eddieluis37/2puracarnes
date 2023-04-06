<div class="row sales layout-top-spacing">
	
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}}</b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
					</li>
			</div>
			@include('common.searchbox')

			<div class="widget-content">
					
				<div class="table-responsive">
					<table class="table table-bordered table striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">LINEA</th>
								<th class="table-th text-white">ACUERDO</th>
								<th class="table-th text-white text-center">PRODUCTOS</th>
								<th class="table-th text-white text-center">PRECIOS</th>								
								<th class="table-th text-white text-center">VENDEDOR</th>							
								<th class="table-th text-white text-center">DESCU</th>
								<th class="table-th text-white text-center">ACTIONS</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $precio_agreement)
							<tr>
								<td><h6>{{$precio_agreement->line}}</h6></td>
								<td><h6>{{$precio_agreement->agreement}}</h6></td>
								<td><h6  class="text-center">{{$precio_agreement->product}}</h6></td>
								<td ><h6 class="text-center">${{number_format($precio_agreement->precio,0)}}</h6></td>
								<td><h6 class="text-center">{{$precio_agreement->user}}</h6></td>					
								
								<td><h6  class="text-center">{{$precio_agreement->descuento}}</h6></td>						
								

								<td class="text-center">
									<a href="javascript:void(0)" 
									wire:click="Edit({{$precio_agreement->id}})"
									class="btn btn-dark mtmobile" title="Edit">
										<i class="fas fa-edit"></i>
									</a>

									
									<a href="javascript:void(0)"
									onclick="Confirm('{{$precio_agreement->id}}')" 
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

@include('livewire.precio_agreements.form')

</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('precio_agreement-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('precio_agreement-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('precio_agreement-deleted', Msg => {           
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