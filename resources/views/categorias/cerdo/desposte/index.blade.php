@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title">
					<b> Desposte | CERDO</b>
				</h4>
				<ul class="tabs tab-pills">
					<li>
						<a href="javascript:void(0)" onclick="window.location.href = '../../beneficiocerdo'" class="tabmenu bg-dark" data-toggle="modal" data-target="" title="Regresa al listado">Volver</a>
					</li>
				</ul>
			</div>

			<!--div class="col-sm-3">
					<div class="info-box">
						<div class="row">
							<div class="col-md-6">
								<div class="ml-3">
									<h3>0</h3>
									<p>Peso total</p>
								</div>
							</div>
							<div class="col-md-6 text-center">
								<i class="fas fa-check mt-2 text-success" style="font-size: 50px;"></i>

							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="info-box">
						<div class="row">
							<div class="col-md-6">
								<div class="ml-3">
									<h3>0000</h3>
									<p>% Desposte</p>
								</div>
							</div>
							<div class="col-md-6 text-center">
								<i class="fas fa-check mt-2 text-success " style="font-size: 50px;"></i>

							</div>
						</div>
					</div>
				</div>-->
		</div>

		<div class="widget-content mt-3">
			<div class="card">
				<div class="card-body">
					<div class="row g-3">
						<div class="col-md-2">
							<div class="task-header">
								<div class="form-group">
									<label>ID Beneficio</label>
									<p>{{$beneficioc[0]->id}} </p>
									<input type="hidden" id="beneficioId" value="{{$beneficioc[0]->id}}">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="task-header">
								<div class="form-group">
									<label>Proveedor</label>
									<p>{{$beneficioc[0]->name}} </p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="task-header">
								<div class="form-group">
									<label>Lote</label>
									<p>{{$beneficioc[0]->lote}}</p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="task-header">
								<div class="form-group">
									<label>Factura</label>
									<p>{{$beneficioc[0]->factura}} </p>
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
					<div class="table-responsive mt-3">
						<table id="tableDespostece" class="table table-sm table-striped table-bordered">
							<thead class="text-white" style="background: #3B3F5C">
								<tr>
									<th class="table-th text-white">Producto</th>
									<th class="table-th text-white">% Desposte</th>
									<th class="table-th text-white">Precio venta</th>
									<th class="table-th text-white text-center">Peso kilo</th>
									<th class="table-th text-white text-center">Total venta</th>
									<th class="table-th text-white text-center">Porcventa</th>
									<th class="table-th text-white text-center">Costo total</th>
									<th class="table-th text-white text-center">Costo kilo</th>
									<th class="table-th text-white text-center">Acciones</th>
								</tr>
							</thead>
							<tbody id="tbody">
								<?php $tpeso = 0;
								$tdesposte = 0; ?>
								@foreach($despostecs as $item)
								<tr>
									<td> {{ $item->products->name }}</td>
									<td> {{ $item->porcdesposte }} %</td>
									<td>$ {{ number_format($item->precio, 0, ',', '.')}}</td>
									<td>
										@if($status == 'true')
										<input type="text" class="form-control-sm" id="{{$item->id}}" value="{{$item->peso}}" placeholder="00" size="5">
										@else
										<p>{{$item->peso}}</p>
										@endif
									</td>

									<td>$ {{ number_format($item->totalventa, 0, ',', '.')}}</td>
									<td> {{ $item->porcventa}} %</td>
									<td>$ {{ number_format($item->costo, 0, ',', '.')}}</td>
									<td> {{ number_format($item->costo_kilo, 2, ',', '.')}}</td>
									<td class="text-center">
										@if($status == 'true')
										<button type="button" name="btnDownReg" data-id="{{$item->id}}" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar">
										</button>
										@else
										<button type="button" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar" disabled>
										</button>
										@endif
									</td>
								</tr>
								<?php $tpeso = $tpeso + $item->peso;
								$tdesposte = $tdesposte + $item->totalventa; ?>
								@endforeach
							</tbody>
							<tfoot id="tfoot">
								<tr>
									<td>Totales</td>
									<td>{{round($TotalDesposte)}} %</td>
									<td>$ --</td>
									<td>{{number_format($pesoTotalGlobal, 2, ',', '.')}}</td>
									<td>$ {{ number_format($TotalVenta, 0, ',', '.')}}</td>
									<td>{{round($porcVentaTotal)}} %</td>
									<td>$ {{ number_format($costoTotalGlobal, 0, ',', '.')}}</td>
									<td>{{$costoKiloTotal}}</td>
									<td class="text-center">
										<button type="hidden" id="cargarInventarioBtn"></button>
									</td>
								</tr>

							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php
		$pi = $beneficioc[0]->canalplanta;
		$cant = $beneficioc[0]->cantidad;
		$ck = $beneficioc[0]->costokilo;
		$tck = $pi * $ck;
		?>
		<div class="widget-content mt-3">
			<div class="card">
				<div class="card-body">
					<div class="row mt-3">
						<div class="col-md-6">
							<div class="">
								<div class="">
									<h5><b> Merma</b> </h5>
									<div class="row g-3 mt-1">
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Peso inicial</label>
													<div class="form-control campo" id="pesoInicial">{{ number_format( $pi, 2, ',', '.' )}} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Peso por Animal</label>
													<div class="form-control campo" id="pesoAnimal">{{ number_format( $pi / $cant, 2, ',', '.' )}} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Peso total Desp</label>
													<div class="form-control campo" id="pesoTotalDesposte">{{ number_format( $tpeso,2, ',', '.')}} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Merma</label>
													<div class="form-control campo" id="merma">{{ number_format( $tpeso - $pi, 2, ',', '.')}} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group" id="porcentajeMerma">
													<label>% Merma</label>
													<?php if ($tpeso == 0) { ?>
														<div class="form-control campo">
															<?php echo number_format($tpeso, 2); ?>
														</div>
													<?php } ?>
													<?php if ($tpeso != 0) { ?>
														<div class="form-control campo">
															<?php echo number_format((($tpeso  - $pi) / $tpeso) * 100, 2); ?>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Cant animales</label>
													<div class="form-control campo" id="cantAnimal">{{ number_format($cant, 0, ',', '.')}} </div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="">
								<div class="">
									<h5><b> Utilidad</b> </h5>
									<div class="row g-3 mt-1">
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Costo kilo</label>
													<div class="form-control campo" id="costoKilo">{{ number_format( $ck, 2, ',', '.') }} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Valor desposte</label>
													<div class="form-control campo" id="valorDesposte">{{ number_format( $tdesposte, 0, ',', '.') }} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Total costo kilo</label>
													<div class="form-control campo" id="totalCostoKilo">{{ number_format( $costoTotalGlobal, 0, ',', '.') }} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group">
													<label>Utilidad</label>
													<div class="form-control campo" id="utilidad">{{ number_format( $tdesposte - $costoTotalGlobal ,0, ',', '.') }} </div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group" id="porcentajeUtilidad">
													<label>% Utilidad</label>
													<?php if ($tdesposte == 0) { ?>
														<div class="form-control campo">
															<?php echo number_format($tdesposte, 2); ?>
														</div>
													<?php } ?>
													<?php if ($tdesposte != 0) { ?>
														<div class="form-control campo">
															<?php echo number_format((($tdesposte - $costoTotalGlobal) / $tdesposte) * 100, 2); ?>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="task-header">
												<div class="form-group" id="utilidadAnimal">
													<label>Utilidad por anima</label>
													<?php if ($tdesposte == 0) { ?>
														<div class="form-control campo">
															<?php echo number_format($tdesposte, 2, ',', '.'); ?>
														</div>
													<?php } ?>
													<?php if ($tdesposte != 0) { ?>
														<div class="form-control campo">
															<?php echo number_format(($tdesposte - $costoTotalGlobal) / $cant, 0, ',', '.'); ?>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
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
<script src="{{asset('code/js/cerdo/despostecerdo/code-despostecerdo.index.js')}}" type="module"></script>
@endsection