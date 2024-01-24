<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="compensadoId" id="compensadoId">
		</div>
		<div class="row g-3">
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Proveedor</label>
						<select class="form-control form-control-sm select2Provider " name="provider" id="provider" required>
							<option value="">Seleccione el proveedor</option>
							@foreach($providers as $option)
							<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Centro de costo</label>
						<select class="form-control form-control-sm input" name="centrocosto" id="centrocosto" required>
							<option value="">Seleccione el centro de costo</option>
							@foreach($centros as $option)
							<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Factura</label>
						<input type="text" class="form-control" id="factura" name="factura" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha</label>
						<input type="date" class="form-control" name="fecha" id="fecha" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>