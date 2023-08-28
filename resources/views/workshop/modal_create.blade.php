<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="tallerId" id="tallerId">
		</div>
		<div class="row g-3">
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Categoria</label>
						<select class="form-control form-control-sm input " name="categoria" id="categoria" required>
							<option value="">Seleccione la categoria</option>
							@foreach($category as $option)
							<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
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
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Seleccionar corte padre</label>
						<select class="form-control form-control-sm input select2corte" name="selectCortePadre" id="selectCortePadre" required>
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Peso padre</label>
						<div class="input-group flex-nowrap">
							<input type="text" name="peso_producto_padre" id="peso_producto_padre" class="form-control" aria-describedby="helpId" placeholder="0" step="0.01" required="">
							<span class="input-group-text" id="addon-wrapping">KG</span>
						</div>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>