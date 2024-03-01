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
					<!-- <li>
						<a href="{{ route('cargar.inventario.masivo') }}" class="btn btn-primary">Cargar Inventario Masivo</a>
					</li> -->
					<li>
						<a href="javascript:void(0)" onclick="showModalcreate()" class="tabmenu bg-dark" data-toggle="modal" data-target="#modal-create-compensado" title="Nueva venta por domicilio">Domicilio</a>
					</li>
					<li></li>
					@php
					$user_id = auth()->id();
					@endphp
					@if(\App\Models\caja\Caja::where('cajero_id', $user_id)
					->whereDate('fecha_hora_inicio', \Carbon\Carbon::now()->toDateString())
					->where('estado', 'open')
					->exists())
					<li>
						<a href="javascript:void(0)" class="tabmenu bg-dark ml-2" id="storeVentaMostradorBtn" title="Nueva venta por mostrador">POS</a>
					</li>
					@endif
				</ul>
			</div>

			<div class="widget-content">
				<div class="table-responsive">
					<table id="tableCompensado" class="table table-striped mt-1">
						<thead class="text-white" style="background: #3B3F5C">
							<tr>
								<th class="table-th text-white">#</th>
								<th class="table-th text-white">CLIENT</th>
								<th class="table-th text-white ">CE</th>
								<th class="table-th text-white">ST</th>
								<th class="table-th text-white">VALOR.F</th>
								<th class="table-th text-white">DIA.HORA</th>
								<th class="table-th text-white">FACTURA</th>
								<th class="table-th text-white">RESOL</th>
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
	<div class="modal fade" id="modal-create-compensado" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content bg-default">
				<fieldset id="contentDisable">
					<form action="" id="form-compensado-res">
						<div class="modal-header">
							<h4 class="modal-title">Crear venta domicilio</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							@include('sale.modal_create')
						</div>
						<div class="modal-footer">
							<button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" id="btnAddVentaDomicilio" class="btn btn-primary">Aceptar</button>
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
<script src="{{asset('rogercode/js/sale/rogercode-ventas-index.js')}}"></script>
<script src="{{asset('rogercode/js/sale/rogercode-create-update.js')}}" type="module"></script>
@endsection