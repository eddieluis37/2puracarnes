<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="ventaId" id="ventaId">
		</div>
		<div class="row g-3">
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha</label>
						<input type="date" class="form-control" name="fecha_venta" id="fecha_venta" placeholder="Last name" aria-label="Last name" value="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Centro de costo</label>
						<select class="form-control form-control-sm input" name="centrocosto" id="centrocosto" required>
							<option value="">Seleccione el centro de costo</option>
							@foreach($centros as $cencosto)
							<option value="{{$cencosto->id}}" {{ $cencosto->id == 1 ? 'selected' : '' }}>{{$cencosto->name}}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Cliente</label>
						<select class="form-control form-control-sm input " name="cliente" id="cliente" required>
							<option value="">Seleccione el cliente</option>
							@foreach($clientes as $cliente)
							<option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Vendedor</label>
						<select class="form-control form-control-sm input" name="vendedor" id="vendedor" required>
							<option value="">Seleccione el vendedor</option>
							@foreach($vendedores as $vendedor)
							<option value="{{$vendedor->id}}" {{ $vendedor->id == 1 ? 'selected' : '' }}>{{$vendedor->name}}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Sub centro de costo</label>
						<select class="form-control form-control-sm input" name="subcentrodecosto" id="subcentrodecosto" required>
							<option value="">Seleccione subCentroDeCosto</option>
							@foreach($subcentrodecostos as $subcentrodecosto)
							<option value="{{$subcentrodecosto->id}}" {{ $subcentrodecosto->id == 0 ? 'selected' : '' }}>{{$subcentrodecosto->name}}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Domiciliario</label>
						<select class="form-control form-control-sm input" name="domiciliario" id="domiciliario" required>
							<option value="">Seleccione el domiciliario</option>
							@foreach($domiciliarios as $domiciliario)
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->name }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha de entrega</label>
						<input type="date" class="form-control" name="fecha_entrega" id="fecha_entrega" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="domiciliario" class="form-label">Dirección de entrega</label>
						<select class="form-control form-control-sm input" name="domiciliario" id="domiciliario" required>
							<option value="">Seleccione el domiciliario</option>
							@foreach($direcciones as $domiciliario)
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->direccion }}</option>
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->direccion1 }}</option>
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->direccion2 }}</option>
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->direccion3 }}</option>
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->direccion4 }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>



		</div>
	</div>
</div>