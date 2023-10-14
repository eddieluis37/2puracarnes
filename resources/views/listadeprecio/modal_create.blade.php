<div class="card">
	<div class="card-body">

		<div class="row g-3">
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Centro costo</label>
						<select name="centro_costo_id" class="form-control">
							@foreach($centros as $centrocosto)
							<option value="{{ $centrocosto->id }}" {{ $lp->centrocosto->id == $centrocosto->id ? 'selected' : '' }}>
								{{ $centrocosto->name }}
							</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Nombre</label>
						<input type="text" class="form-control" id="nombre" name="nombre" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
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