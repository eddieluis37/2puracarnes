@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="row">
				<div class="col-sm-3">
					<h4 class="">
						<b> Desposte / RES</b>
					</h4>
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
                                        <p>{{$beneficior[0]->id}} </p>
										<input type="hidden" id="beneficioId" value="{{$beneficior[0]->id}}">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
										<label>Proveedor</label>
                                        <p>{{$beneficior[0]->name}} </p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Lote</label>
                                        <p>{{$beneficior[0]->lote}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Factura</label>
                                        <p>{{$beneficior[0]->factura}} </p>
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
								<table id="tableDespostere" class="table table-sm table-striped table-bordered">
									<thead class="text-white" style="background: #3B3F5C">
										<tr>
											<th class="table-th text-white">Producto</th>
											<th class="table-th text-white">% Desposte</th>
											<th class="table-th text-white">Precio venta</th>
											<th class="table-th text-white text-center">Peso kilo</th>
											<th class="table-th text-white text-center">Total venta</th>
											<th class="table-th text-white text-center">Porcventa</th>
											<th class="table-th text-white text-center">Costo total</th>
											<th class="table-th text-white text-center">Acciones</th>
										</tr>
									</thead>
									<tbody id="tbody">
										@foreach($desposters as $item)
										<tr>
											<td> {{ $item->products->name }}</td>
											<td> {{ $item->porcdesposte }}</td>
											<td> {{ $item->precio}}</td>
											<td> <input type="number" class="form-control-sm" id="{{$item->id}}" value="{{$item->peso}}" placeholder="Ingresar" size="10"></td>
											<!--td> <input type="number" class="form-control-sm" placeholder="Ingresar" size="10" onkeypress="saveRowdesposte(event);"></td>-->
											<td> {{ $item->totalventa}}</td>
											<td> {{ $item->porcventa}}</td>
											<td> {{ $item->costo}}</td>
											<td class="text-center">
												<button type="button" onclick="Confirm('{{$item->id}}','{{$item->beneficiores_id}}')" class="btn btn-dark btn-sm" title="Cancelar">
													<i class="fas fa-trash"></i>
												</button>
											</td>
										</tr>
										@endforeach
									</tbody>
									<tfoot id="tfoot" >
										<tr>
											<td>Totales</td>
											<td>{{round($TotalDesposte)}}</td>
											<td>--</td>
											<td>{{$pesoTotalGlobal}}</td>
											<td>{{$TotalVenta}}</td>
											<td>{{round($porcVentaTotal)}}</td>
											<td>--</td>
											<td></td>
										</tr>

									</tfoot>
								</table>
							</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/res/desposteres/rogercode-desposteres.index.js')}}" type="module"></script>
@endsection