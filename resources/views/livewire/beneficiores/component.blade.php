<style>





</style>
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}} </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="showModalcreate()" class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-beneficiore" title="Nuevo Beneficio">Agregar</a>
					</li>
				</ul>
			</div>

			@include('common.searchbox')
			<div class="widget-content">
				<div class="table-responsive">
					<table id="beneficiores" class="table table-striped mt-1">
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
								<td>
									<h6>{{number_format($beneficiore->id,0)}}</h6>
								</td>
								<td>
									<h6>{{$beneficiore->third}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$beneficiore->fecha_beneficio}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$beneficiore->lote}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$beneficiore->factura}}</h6>
								</td>
								<td class="text-center">
									<!--p>{{$beneficiore->fecha_cierre}}</p-->
									@if (Carbon\Carbon::parse($dateNow)->gt(Carbon\Carbon::parse($beneficiore->fecha_cierre)))
										<!--p>dateNow is greater than fecha_cierre</p>--> 
										<a href="desposteres/{{$beneficiore->id}}" class="btn btn-dark" title="Despostar" disabled>
											<i class="fas fa-search"></i>
										</a>
										<button onclick="showDataForm('{{$beneficiore->id}}')" class="btn btn-dark mtmobile" title="Editar Beneficio" >
											<i class="fas fa-eye"></i>
										</button>
										<button onclick="Confirm('{{$beneficiore->id}}')" class="btn btn-dark" title="Borrar Beneficio" disabled>
											<i class="fas fa-trash"></i>
										</button>
									@elseif (Carbon\Carbon::parse($dateNow)->lt(Carbon\Carbon::parse($beneficiore->fecha_cierre)))
										<!--p>dateNow is less than fecha_cierre</p>--> 
										<a href="desposteres/{{$beneficiore->id}}" class="btn btn-dark" title="Despostar">
											<i class="fas fa-search"></i>
										</a>
										<button onclick="edit('{{$beneficiore->id}}')" class="btn btn-dark mtmobile" title="Editar Beneficio" {{ $monday ? 'disabled' : '' }}>
											<i class="fas fa-edit"></i>
										</button>
										<button onclick="Confirm('{{$beneficiore->id}}')" class="btn btn-dark" title="Borrar Beneficio"  {{ $monday ? 'disabled' : '' }}>
											<i class="fas fa-trash"></i>
										</button>
									@else
										<!--dateNow is equal to fecha_cierre-->
										<a href="desposteres/{{$beneficiore->id}}" class="btn btn-dark" title="Despostar" disabled>
											<i class="fas fa-search"></i>
										</a>
										<button onclick="showDataForm('{{$beneficiore->id}}')" class="btn btn-dark mtmobile" title="Editar Beneficio" >
											<i class="fas fa-eye"></i>
										</button>
										<button onclick="Confirm('{{$beneficiore->id}}')" class="btn btn-dark" title="Borrar Beneficio" disabled>
											<i class="fas fa-trash"></i>
										</button>
									@endif
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
	<!-- modal -->
	<div class="modal fade" id="modal-create-beneficiore" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content bg-default">
				<div class="modal-header">
					<h4 class="modal-title">Crear Beneficio Res</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
				</div>
				@include('livewire.beneficiores.form')
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>
@include('livewire.beneficiores.scripts')

<script>
	$(document).ready(function() {

	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
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
		/************************************************* */
		$('#beneficiores').DataTable({
			"order": [
				[0, "desc"]
			]
		});

		$('.selectProvider').select2({
			placeholder: 'Busca un proveedor',
			width: '100%',
			theme: "bootstrap-5",
			allowClear: true,
			dropdownParent: $('#modal-create-beneficiore')
			//https://select2.org/troubleshooting/common-problems
		});
		$('.selectPieles').select2({
			placeholder: 'Busca un cliente',
			width: '100%',
			theme: "bootstrap-5",
			allowClear: true,
			dropdownParent: $('#modal-create-beneficiore')
		});
		$('.selectVisceras').select2({
			placeholder: 'Busca un cliente',
			width: '100%',
			theme: "bootstrap-5",
			allowClear: true,
			dropdownParent: $('#modal-create-beneficiore')
		});

	});


</script>
@section('script')
<script src="{{asset('rogercode/js/res/beneficiores/rogercode-beneficiores-index.js')}}"></script>
@endsection
