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
			<div class="widget-heading">
				<h4 class="card-title">
					<b> Caja | Cuadre </b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../caja'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
					</li>
				</ul>
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
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label for="" class="form-label">Estado</label>
										<p>{{$dataAlistamiento[0]->estado}}</p>
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
								<form action="" method="POST" enctype="multipart/form-data">
									<input type="hidden" id="ventaId" name="ventaId" value="{{$dataAlistamiento[0]->id}}">
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
													<td colspan="2">
														<input type="text" id="valor_a_pagar_tarjeta" name="valor_a_pagar_tarjeta" value="$ {{number_format($arrayTotales['valorApagarTarjeta'], 0, ',', '.')}}" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
													</td>
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Otros</th>
													<td colspan="2">
														<input type="text" id="valor_a_pagar_otros" name="valor_a_pagar_otros" value="$ {{number_format($arrayTotales['valorApagarOtros'], 0, ',', '.')}}" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
													</td>
												</tr>
												<tr>
													<th scope="row" style="text-align: left">Total</th>
													<td colspan="2">
														<input type="text" id="" name="" value="$ {{number_format($arrayTotales['valorTotal'], 0, ',', '.')}}" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
													</td>
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
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="widget widget-chart-one">
						<div class="widget-content mt-0">
							<div class="card-body">

								<input type="hidden" id="ventaId" name="ventaId" value="{{$dataAlistamiento[0]->id}}">
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
												<td colspan="2">
													<input type="text" id="base" name="base" value="$ {{number_format($dataAlistamiento[0]->base, 0, ',', '.')}}" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
												</td>
											</tr>
											<tr>
												<th scope="row" style="text-align: left">Efectivo</th>
												<td colspan="2">
													<input type="text" id="efectivo" name="efectivo" value="$ {{number_format($arrayTotales['valorEfectivo'], 0, ',', '.')}}" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
												</td>
											</tr>
											<tr>
												<th scope="row" style="text-align: left">Retiro de caja</th>

											</tr>
											<tr>
												<th scope="row" style="text-align: left">Total</th>
												<td colspan="2">
													<input type="text" id="total" name="total" value="" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
												</td>
											</tr>

											<tr>
												<th scope="row" style="text-align: left">Valor_real_ingresado</th>
												<td colspan="2">
													<input type="text" id="valor_real" name="valor_real" value="" data-id="" style="text-align: right; font-weight: bold; color: black">
												</td>

											</tr>
											<tr>
												<th scope="row" style="text-align: left">Diferencia</th>
												<td colspan="2">
													<input type="text" id="diferencia" name="diferencia" value="" data-id="" style="text-align: right; font-weight: bold; color: black" readonly>
												</td>

											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="2">
													<div class="form-group">
														@php
														use App\Models\caja\Caja;
														$caja = Caja::find($dataAlistamiento[0]->id);
														@endphp

														@if($caja->status == 0)
														<button type="submit" class="btn btn-success" id="btnGuardar" disabled>Guardar e imprimir</button>
														@endif
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
<script src="{{asset('rogercode/js/caja/code-formulas.js')}}"></script>
@endsection