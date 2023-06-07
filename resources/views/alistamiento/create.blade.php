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
			<div class="row">
				<div class="col-sm-5">
					<h4 class="">
						<b> Alistamiento / Categoria </b>
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
                                        <label for="" class="form-label">Fecha de compra</label>
										<p>{{$dataAlistamiento[0]->created_at}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Categoria</label>
										<p>{{$dataAlistamiento[0]->namecategoria}}</p>
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
						</div>
					</div>
				</div>
            </div>

			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<form id="form-detail">
						<input type="hidden" id="alistamientoId" name="alistamientoId" value="">
						<input type="hidden" id="regdetailId" name="regdetailId" value="0">
						<div class="row g-3">
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Buscar corte padre</label>
					                    <select class="form-control form-control-sm select2Prod" name="productoCorte" id="productoCorte" required="">
											<option value="">Seleccione el producto</option>
											@foreach ($cortes as $p)
											<option value="{{$p->id}}">{{$p->name}}</option>
											@endforeach
					                    </select>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<label for="" class="form-label">Seleccionar hijo </label>
					                <select class="form-control form-control-sm select2ProdHijos" name="producto" id="producto" required="">
					                </select>
							</div>
							<div class="col-md-3">
								<label for="" class="form-label">KG requeridos</label>
								<div class="input-group flex-nowrap">
									<input type="text" id="kgrequeridos" name="kgrequeridos" class="form-control input" placeholder="EJ: 10,00">
									<span class="input-group-text" id="addon-wrapping">KG</span>
								</div>
							</div>
							<div class="col-md-2 text-center">
								<div class="" style="margin-top:30px;">
								<div class="d-grid gap-2">
									<button id="btnAddAlistamiento" class="btn btn-primary">Aceptar</button>
								</div>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
            </div>
			
            <div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
								<label for="" class="form-label">Stock actual</label>
								<input type="text" id="pesokg" name="pesokg" class="form-control-sm form-control" placeholder="10,00 kg">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								<label for="" class="form-label">Ultimo conteo fisico</label>
								<input type="text" id="pesokg" name="pesokg" class="form-control-sm form-control" placeholder="20,00 kg">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								<label for="" class="form-label">Nuevo stock</label>
								<input type="text" id="pesokg" name="pesokg" class="form-control-sm form-control" placeholder="30,00 kg">
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
											<!--th class="table-th text-white">Item</th>-->
											<th class="table-th text-white">#</th>
											<th class="table-th text-white">Codigo</th>
											<th class="table-th text-white">Producto hijo</th>
											<th class="table-th text-white">Stock actual</th>
											<th class="table-th text-white">Fisico</th>
											<th class="table-th text-white">kg requeridos</th>
											<th class="table-th text-white">New stock hijo</th>
											<th class="table-th text-white text-center">Acciones</th>
										</tr>
									</thead>
									<tbody id="tbodyDetail">
										<tr>
											<td>1</td>
											<td>h000</td>
											<td>centro de pierna</td>
											<td>10.00</td>
											<td>8.00</td>
											<td>
												<input type="text" class="form-control-sm" id="" value="50.00" placeholder="Ingresar" size="10">
											</td>
											<td>50.00</td>
											<td class="text-center">
												<button type="button" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar" >
												</button>
											</td>
										</tr>
										<tr>
											<td>2</td>
											<td>h000</td>
											<td>Bota con muchacho</td>
											<td>10.00</td>
											<td>8.00</td>
											<td>
												<input type="text" class="form-control-sm" id="" value="50.00" placeholder="Ingresar" size="10">
											</td>
											<td>50.00</td>
											<td class="text-center">
												<button type="button" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar" >
												</button>
											</td>
										</tr>
										<tr>
											<td>3</td>
											<td>h000</td>
											<td>Bota</td>
											<td>10.00</td>
											<td>8.00</td>
											<td>
												<input type="text" class="form-control-sm" id="" value="50.00" placeholder="Ingresar" size="10">
											</td>
											<td>50.00</td>
											<td class="text-center">
												<button type="button" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar" >
												</button>
											</td>
										</tr>
									</tbody>
									<tfoot id="tabletfoot" >
										<tr>
											<th></th>
											<th></th>
											<th>Totales</th>
											<th>15.00 kg</th>
											<th>15.00 kg</th>
											<th>15.00 kg</th>
											<th>15.00 kg</th>
											<th class="text-center">
												<button class="btn btn-success btn-sm">Cargar al inventario</button>
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
                    </div>
                </div>
            </div>
			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						
					</div>
				</div>
			</div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/alistamiento/rogercode-create.js')}}" type="module"></script>
@endsection