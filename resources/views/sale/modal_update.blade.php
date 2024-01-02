<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="alistamientoId" id="alistamientoId">
		</div>
		<div class="row g-3">
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha</label>
						<input type="date" class="form-control" name="fecha2" id="fecha2" placeholder="Last name" aria-label="Last name" >
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Centro de costo</label>
						<select class="form-control form-control-sm input" name="centrocosto2" id="centrocosto2" required>
							<option value="">Seleccione el centro de costo</option>
							@foreach($centros as $cencosto)
								<option value="{{ $cencosto->id }}">{{ $cencosto->name }}</option>
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
						<select class="form-control form-control-sm input " name="cliente2" id="cliente2" required>
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
						<select class="form-control form-control-sm input" name="vendedor2" id="vendedor2" required>
							<option value="">Seleccione el vendedor</option>
							@foreach($vendedores as $vendedor)
								<option value="{{ $vendedor->id }}">{{ $vendedor->name }}</option>
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
						<select class="form-control form-control-sm input" name="domiciliario2" id="domiciliario2" required>
							<option value="">Seleccione el domiciliario</option>
							@foreach($domiciliarios as $domiciliario)
								<option value="{{ $domiciliario->id }}">{{ $domiciliario->name }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
