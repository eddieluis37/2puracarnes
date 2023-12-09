@extends('layouts.theme.app')
@section('content')
<style>
	.table-totales {
		border: 2px solid red;
	}	

	.table-inventario,
	th,
	td {
		border: 0px solid #DCDCDC;
		text-align: center;
	}

	.input {
		height: 38px;
	}

	td {
		text-align: right;
		font-weight: bold;
		color: black;
	}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="row">
				<div class="col-sm-5">
					<h4 class="">
						<b> Caja | Cuadre </b>
					</h4>
				</div>
			</div>

			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Fecha hora inicio turno</label>
										<p>{{$dataAlistamiento[0]->fecha_hora_inicio}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Turno</label>
										<p>{{$dataAlistamiento[0]->id}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Centro de costo</label>
										<p>{{$dataAlistamiento[0]->namecentrocosto}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Fecha hora cierre turno</label>
										<p>{{$dataAlistamiento[0]->fecha_hora_cierre}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Cajero</label>
										<p>{{$dataAlistamiento[0]->namecajero}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row justify-content-center mt-2">
				<div class="col-md-6">
					<div class="widget widget-chart-one">
						<div class="widget-content mt-0">
							<div class="card-body">
								<form action="{{ route('sale.save') }}" method="POST" enctype="multipart/form-data">
									<input type="hidden" id="alistamientoId" name="alistamientoId" value="{{$dataAlistamiento[0]->id}}">
									@csrf
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th scope="col" style="text-align: center; vertical-align: middle;">CONCEPTO</th>
													<th scope="col" style="text-align: center; vertical-align: middle;">VALOR</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th scope="row" style="text-align: left">Total tarjetas</th>
													<td colspan="2">$ {{number_format($dataAlistamiento[0]->base, 0, ',', '.')}}</td>
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Otros</th>
												
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Total</th>
													<td colspan="2"></td>
												</tr>

												<tr>
												
												
												</tr>
												<tr>
												
												
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<th colspan="2">
														<div class="form-group">
															
														
														</div>
													</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="widget widget-chart-one">
						<div class="widget-content mt-0">
							<div class="card-body">
								<form action="{{ route('sale.save') }}" method="POST" enctype="multipart/form-data">
									<input type="hidden" id="alistamientoId" name="alistamientoId" value="{{$dataAlistamiento[0]->id}}">
									@csrf
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th scope="col" style="text-align: center; vertical-align: middle;">CONCEPTO</th>
													<th scope="col" style="text-align: center; vertical-align: middle;">VALOR</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th scope="row" style="text-align: left">Base inicial</th>
													<td colspan="2">$ {{number_format($dataAlistamiento[0]->base, 0, ',', '.')}}</td>
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Efectivo</th>
												
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Retiro de caja</th>
												
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Total</th>
													<td colspan="2"></td>
												</tr>

												<tr>
													<th scope="row" style="text-align: left">Valor_real_ingresado</th>
												
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Diferencia</th>
												
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<th colspan="2">
														<div class="form-group">
															<button type="submit" class="btn btn-success" id="btnGuardar" disabled>Guardar e imprimir</button>
															<button type="button" class="btn btn-primary" onclick="history.back()">Volver</button>
														</div>
													</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>

	</div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/caja/rogercode-create.js')}}" type="module"></script>
@endsection