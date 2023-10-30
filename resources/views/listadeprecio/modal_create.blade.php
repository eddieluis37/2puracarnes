<div class="card">
	<div class="card-body">

		<div class="row g-3">
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Centro costo</label>
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
						<label for="" class="form-label">Nombre</label>
						<input type="text" class="form-control" id="nombre" name="nombre" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Tipo</label>
						<select class="form-control form-control-sm input" name="tipo" id="tipo" required>
							<option value="">Seleccione el tipo</option>
							<option value="NICHO"> NICHO </option>
							<option value="GENERAL"> GENERAL </option>							
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>