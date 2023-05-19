<div class="card">
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-3">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Categoria</label>
					    <select class="form-control form-control-sm input " name="categoria" id="categoria" required>
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
					    <select class="form-control form-control-sm select2Provider " name="provider" id="provider" required>
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
					    <select class="form-control form-control-sm input" name="centrocosto" id="centrocosto" required>
						    <option value="">Seleccione el centro de costo</option>
							@foreach($centros as $option)
							<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
							@endforeach
					    </select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>