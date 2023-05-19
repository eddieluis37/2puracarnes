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
						<b> Compensado / Categoria </b>
					</h4>
				</div>
			</div>

			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Fecha de compra</label>
										<p>5/18/2021</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Categoria</label>
										<p>Res</p>
					                    <!--select class="form-control form-control-sm input " name="categoria" id="categoria" required="">
						                    <option value="">Seleccione la categoria</option>
											@foreach($category as $option)
											<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
											@endforeach
					                    </select>-->
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Proveedor</label>
										<p>Rogercode</p>
					                    <!--select class="form-control form-control-sm select2Provider " name="provider" id="provider" required="">
						                    <option value="">Seleccione el proveedor</option>
											@foreach($providers as $option)
											<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
											@endforeach
					                    </select>-->
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Centro de costo</label>
										<p>Guadalupe</p>
					                    <!--select class="form-control form-control-sm input" name="" id="" required="">
						                    <option value="">Seleccione el centro de costo</option>
											@foreach($centros as $option)
											<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
											@endforeach
					                    </select>-->
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
						<div class="row g-3">
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Buscar producto</label>
					                    <select class="form-control form-control-sm select2Prod" name="producto" id="producto" required="">
					                    </select>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Precio de compra</label>
                                        <input type="text" class="form-control input" placeholder="EJ: 20.500">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Peso KG</label>
                                        <input type="text" class="form-control input" placeholder="EJ: 10.00">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Sub Total</label>
                                        <input type="text" class="form-control input" placeholder="EJ: 10.00">
									</div>
								</div>
							</div>
							<div class="col-md-2">
                                <button class="btn btn-primary">Aceptar</button>
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
											<th class="table-th text-white">Item</th>
											<th class="table-th text-white">Fecha compra</th>
											<th class="table-th text-white">Codigo</th>
											<th class="table-th text-white">Productos</th>
											<th class="table-th text-white">Precio compra</th>
											<th class="table-th text-white">Peso KG</th>
											<th class="table-th text-white">Sub Total</th>
											<th class="table-th text-white">IVA $</th>
											<th class="table-th text-white text-center">Acciones</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<tr>
											<td>2</td>
											<td>5/18/2023</td>
											<td>pc001</td>
											<td>pacha</td>
											<td>18.87</td>
											<td>30.00 kg</td>
											<td>100</td>
											<td>16 %</td>
											<td class="text-center">
												<a href="#" class="btn btn-dark" title="Despostar" >
													<i class="fas fa-edit"></i>
												</a>
												<button class="btn btn-dark" title="Borrar Beneficio" >
													<i class="fas fa-trash"></i>
												</button>
											</td>
										</tr>
										<tr>
											<td>2</td>
											<td>5/18/2023</td>
											<td>pc001</td>
											<td>pacha</td>
											<td>18.87</td>
											<td>30.00 kg</td>
											<td>100</td>
											<td>16 %</td>
											<td class="text-center">
												<a href="#" class="btn btn-dark" title="Despostar" >
													<i class="fas fa-edit"></i>
												</a>
												<button class="btn btn-dark" title="Borrar Beneficio" >
													<i class="fas fa-trash"></i>
												</button>
											</td>
										</tr>
									</tbody>
									<tfoot id="tfoot" >

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
<script src="{{asset('rogercode/js/inventory/rogercode-create.js')}}" type="module"></script>
@endsection