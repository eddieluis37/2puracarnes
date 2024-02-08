<div class="card">
	<div class="card-body">
		<div>
			<input type="hidden" value="0" name="recibocajaId" id="recibocajaId">
		</div>
		<div class="row g-3">
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha</label>
						<input type="date" class="form-control" name="fecha_elaboracion" id="fecha_elaboracion" placeholder="Last name" aria-label="Last name" value="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Tipo de recibo</label>
						<select class="form-control form-control-sm" name="tipo" id="tipo">
							<option value="">Seleccione una opción</option>							
							<option value="1">DIARIO</option>
							<option value="2">CARTERA</option>
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
						<label for="" class="form-label">Facturas</label>
						<select class="form-control form-control-sm select2Ventas " name="factura" id="factura" required>
							<option value="">Seleccione factura</option>
							@foreach($ventas as $factura)
							<option value="{{ $factura->id }}">{{ $factura->resolucion }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
						<label for="" class="form-label">Forma pagos</label>
						<select class="form-control form-control-sm input" name="formapagos" id="formapagos" required>
							<option value="">Seleccione forma de pago</option>
							@foreach($formapagos as $formapago)
							<option value="{{$formapago->id}}" {{ $formapago->id == 0 ? 'selected' : '' }}>{{$formapago->nombre}}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">

				</div>
			</div>

			<div class="col-md-6">
				<div class="task-header">
					<!-- <div class="form-group">
						<label for="" class="form-label">Domiciliario</label>
						<select class="form-control form-control-sm input" name="domiciliario" id="domiciliario" required>
							<option value="">Seleccione el domiciliario</option>
							@foreach($domiciliarios as $domiciliario)
							<option value="{{ $domiciliario->id }}">{{ $domiciliario->name }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div> -->
				</div>
			</div>


		</div>
	</div>
</div>