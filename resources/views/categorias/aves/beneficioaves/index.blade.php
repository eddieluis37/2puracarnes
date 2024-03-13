@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b>Beneficio Pollos | Listado </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="showModalcreate()" class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-beneficiopollo" title="Nuevo Beneficio">Agregar</a>
					</li>
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">
					<table id="tableBeneficioaves" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">#</th>
								<th class="table-th text-white">Proveedor</th>
								<th class="table-th text-white">Fecha</th>
								<th class="table-th text-white">Factura</th>
								<th class="table-th text-white">Lote</th>
								<th class="table-th text-white text-center">Acciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="modal-create-beneficiopollo" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
					<form action="" id="form-beneficiopollos-pollos">
						<div class="modal-header">
							<h4 class="modal-title">Crear Beneficio Pollos</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
				 		<div class="modal-body">
							@include('categorias.aves.beneficioaves.modal_create')
						</div>
						<div class="modal-footer">
							<button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" id="" class="btn btn-primary">Aceptar</button>
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
@section('script')
<script src="{{asset('code/js/aves/beneficioaves/code-beneficioaves-index.js')}}"></script>
<script src="{{asset('code/js/aves/beneficioaves/code-formulas.js')}}"></script>
<script src="{{asset('code/js/aves/beneficioaves/code-create.js')}}" type="module"></script>
@endsection