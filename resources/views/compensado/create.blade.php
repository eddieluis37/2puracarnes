@extends('layouts.theme.app')
@section('content')
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
                                        <label for="" class="form-label">Categoria</label>
					                    <select class="form-control form-control-sm " name="" id="" required="">
						                    <option value="">Seleccione la categoria</option>
											@foreach($category as $option)
											<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
											@endforeach
					                    </select>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Proveedor</label>
					                    <select class="form-control form-control-sm " name="" id="" required="">
						                    <option value="">Seleccione el proveedor</option>
											@foreach($providers as $option)
											<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
											@endforeach
					                    </select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Centro de costo</label>
					                    <select class="form-control form-control-sm " name="" id="" required="">
						                    <option value="">Seleccione el centro de costo</option>
					                    </select>
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
					                    <select class="form-control form-control-sm " name="" id="" required="">
						                    <option value="">Seleccione el producto</option>
					                    </select>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Precio de compra</label>
                                        <input type="text" class="form-control" placeholder="EJ: 20.500">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Peso KG</label>
                                        <input type="text" class="form-control" placeholder="EJ: 10.00">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Sub Total</label>
                                        <input type="text" class="form-control" placeholder="EJ: 10.00">
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
											<th class="table-th text-white text-center">Productos</th>
											<th class="table-th text-white text-center">Precio compra</th>
											<th class="table-th text-white text-center">Peso KG</th>
											<th class="table-th text-white text-center">Sub Total</th>
											<th class="table-th text-white text-center">IVA $</th>
											<th class="table-th text-white text-center">Acciones</th>
										</tr>
									</thead>
									<tbody id="tbody">
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
<script src="" type="module"></script>
@endsection