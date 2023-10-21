<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}}</b>
				</h4>
				<ul class="tabs tab-pills">
					@can('Product_Create')
					<li>
						<a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
					</li>
					@endcan
				</ul>
			</div>
			@can('Product_Search')
			@include('common.searchbox')
			@endcan
			<div class="widget-content">

				<div class="table-responsive">
					<table class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C;">
							<tr>
								<th class="table-th text-white">CORTE</th>
								<th class="table-th text-white text-center">CATEGORÍA</th>
								<th class="table-th text-white text-center">ESTADO</th>
								<th class="table-th text-white text-center">ACCIONES</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $meatcut)
							<tr>
								<td>
									<h6 class="text-left">{{$meatcut->name}}</h6>
								</td>

								<td>
									<h6 class="text-center">{{$meatcut->category}}</h6>
								</td>

								<td>
									<h6 class="text-center">{{$meatcut->status}}</h6>
								</td>

								<td class="text-center">
									@can('Product_Update')
									<a href="javascript:void(0)" wire:click.prevent="Edit({{$meatcut->id}})" class="btn btn-dark mtmobile" title="Edit">
										<i class="fas fa-edit"></i>
									</a>

									@endcan
									@can('meatcut_Destroy')
									<a href="javascript:void(0)" onclick="Confirm('{{$meatcut->id}}')" class="btn btn-dark" title="Delete">
										<i class="fas fa-trash"></i>
									</a>
									@endcan

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

	@include('livewire.meatcuts.form')
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {

		window.livewire.on('meatcut-added', msg => {
			$('#theModal').modal('hide')
		});
		window.livewire.on('meatcut-updated', msg => {
			$('#theModal').modal('hide')
		});
		window.livewire.on('meatcut-deleted', msg => {
			// noty
		});
		window.livewire.on('modal-show', msg => {
			$('#theModal').modal('show')
		});
		window.livewire.on('modal-hide', msg => {
			$('#theModal').modal('hide')
		});
		window.livewire.on('hidden.bs.modal', msg => {
			$('.er').css('display', 'none')
		});
		$('#theModal').on('hidden.bs.modal', function(e) {
			$('.er').css('display', 'none')
		})
		$('#theModal').on('shown.bs.modal', function(e) {
			$('.meatcut-name').focus()
		})



	});

	function Confirm(id) {

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
			if (result.value) {
				window.livewire.emit('deleteRow', id)
				swal.close()
			}

		})
	}
</script>