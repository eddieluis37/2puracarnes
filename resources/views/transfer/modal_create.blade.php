<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="alistamientoId" id="alistamientoId" >
		</div>
		<div class="row g-6">			
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Centro costo origen</label>
					    <select class="form-control form-control-sm input" name="centrocostoorigen" id="centrocostoorigen" onchange="actualizarStockActualOrigen()" required>
						    <option value="">Seleccione el centro de costo</option>
							@foreach($costcenter as $option)
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
                        <label for="" class="form-label">Seleccionar producto</label>
					    <select class="form-control form-control-sm input select2corte" name="selectCortePadre" id="selectCortePadre" onchange="actualizarStockActualOrigen()" required>
					    </select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-4"> 
				<div class="task-header"> 
					<div class="form-group"> 
						<label for="" class="form-label">Stock actual centro costo origen</label> 
						<input type="text" class="form-control" id="stockActualCenterCostOrigin" name="stockActualCenterCostOrigin" required="true"> 
						<span class="text-danger error-message"></span> 
					</div> 
				</div> 
			</div>
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Centro costo destino</label>
					    <select class="form-control form-control-sm input" name="centrocostodestino" id="centrocostodestino" onchange="actualizarStockActualDest()" required>
						    <option value="">Seleccione el centro de costo</option>
							@foreach($costcenter as $option)
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
						<label for="" class="form-label">Stock actual centro costo destino</label> 
						<input type="text" class="form-control" id="stockActualCenterCostDest" name="stockActualCenterCostDest" required="true"> 
						<span class="text-danger error-message"></span> 
					</div> 
				</div> 
			</div>
			<div class="col-md-4"> 
				<div class="task-header"> 
					<div class="form-group"> 
						<label for="" class="form-label">Stock para trasladar</label> 
						<input type="text" class="form-control" id="stockForTranser" name="stockForTranser" required="true"> 
						<span class="text-danger error-message"></span> 
					</div> 
				</div> 
			</div>	
			<div class="col-md-4"> 
				<div class="task-header"> 
					<div class="form-group"> 
						<label for="" class="form-label">Stock futuro centro costo destino</label> 
						<input type="text" class="form-control" id="stockFutureCenterCostOrigin" name="stockFutureCenterCostOrigin" required="true"> 
						<span class="text-danger error-message"></span> 
					</div> 
				</div> 
			</div>								
		</div>
	</div> 
</div>