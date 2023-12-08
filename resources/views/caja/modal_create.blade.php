<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="alistamientoId" id="alistamientoId">
		</div>
		<div class="row g-3">
			<!--	<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha</label>
						<input type="date" class="form-control" name="fecha" id="fecha" placeholder="Last name" aria-label="Last name" >
					</div>
				</div>
			</div> -->
			<div class="col-md-4">
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
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Cajero</label>
						<select class="form-control form-control-sm input " name="cajero" id="cajero" required>
							<option value="">Seleccione el cajero</option>
							@foreach($usuario as $option)
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
						<label for="" class="form-label">Base inicial</label>
						<input type="text" class="form-control" id="base" name="base" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<!-- <div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Seleccionar corte padre</label>
						<select class="form-control form-control-sm input select2corte" name="selectCortePadre" id="selectCortePadre" required>
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div> -->
		</div>
	</div>
</div>