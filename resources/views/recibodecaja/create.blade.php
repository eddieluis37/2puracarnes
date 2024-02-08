@extends('layouts.theme.app')
@section('content')
<style>
	.input {
		height: 38px;
	}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b> Recibo de caja | Crear </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../recibodecajas'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
					</li>
				</ul>
			</div>
			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label for="date1" class="form-label">Fecha de recibo de caja</label>
										<input type="date" class="form-control" name="fecha" id="fecha" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Cliente</label>
										<p>{{$datacompensado[0]->namethird}}</p>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Identificación</label>
										<p>{{$datacompensado[0]->identification}}</p>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Tipo de recibo</label>
										<p>
											@if ($datacompensado[0]->tipo == 1)
											INGRESO DIARIO
											@elseif ($datacompensado[0]->tipo == 2)
											EGRESO DE CARTERA
											@endif
										</p>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Deuda Inicial</label>
										<p>{{$datacompensado[0]->deuda_inicial}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<form id="form-detail">
							<input type="hidden" id="recibodecajaId" name="recibodecajaId" value="{{$id}}">
							<input type="hidden" id="regdetailId" name="regdetailId" value="0">
							<div class="row g-3">
								<div class="col-md-3">
									<div class="task-header">
										<div class="form-group">
											<label for="" class="form-label">Facturas del cliente</label>
											<input type="hidden" id="cliente" name="cliente" value="{{$datacompensado[0]->third_id}}" data-id="{{$datacompensado[0]->third_id}}">
											<input type="hidden" id="facturaId" name="facturaId" value="{{$datacompensado[0]->sale_id}}" data-id="{{$datacompensado[0]->sale_id}}">
											<select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
												<option value="">Seleccione el facturas</option>
												@foreach ($prod as $p)
												<option value="{{$p->id}}">{{$p->resolucion}} - {{$p->consecutivo}}</option>
												@endforeach
											</select>
											<span class="text-danger error-message"></span>
										</div>
									</div>
								</div>

								<div class="col-md-3">
									<label for="" class="form-label">Deuda inicial</label>
									<div class="input-group flex-nowrap">
										<span class="input-group-text" id="addon-wrapping">$</span>
										<input type="text" id="saldo" name="saldo" class="form-control input" value="{{$datacompensado[0]->deuda_inicial}}" data-id="{{$datacompensado[0]->deuda_inicial}}" readonly placeholder="">
									</div>
								</div>

								<div class="col-md-3">
									<label for="" class="form-label">Saldo Pendiente</label>
									<div class="input-group flex-nowrap">
										<span class="input-group-text" id="addon-wrapping">$</span>
										<input type="text" id="saldo_pendiente" name="saldo_pendiente" class="form-control input" readonly placeholder="">
									</div>
								</div>

								<div class="col-md-3">
									<label for="" class="form-label">Abono</label>
									<div class="input-group flex-nowrap">
										<span class="input-group-text" id="addon-wrapping">$</span>
										<input type="text" id="abono" name="abono" class="form-control input" placeholder="">
										<span class="text-danger error-message"></span>
									</div>									
								</div>

								<div class="col-md-3">
									<label for="" class="form-label">Nuevo saldo</label>
									<div class="input-group flex-nowrap">
										<span class="input-group-text" id="addon-wrapping">$</span>
										<input type="text" id="nuevo_saldo" name="nuevo_saldo" class="form-control input" readonly placeholder="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="observations">Observaciones</label>
										<textarea class="form-control" id="observations" name="observations" rows="3"></textarea>
									</div>
								</div>


								<div class="col-md-3">
									<div class="" style="margin-top:100px;">
										<div class="d-grid gap-2">
											<button id="btnAdd" class="btn btn-success">Guardar</button>
										</div>
									</div>
								</div>

								<!--  	<button type="submit" id="btnAddReciboCaja" class="btn btn-primary">Aceptar</button>  -->

							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
	@endsection
	@section('script')
	<script src="{{asset('rogercode/js/recibodecaja/rogercode-create.js')}}" type="module"></script>
	@endsection