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
						<label for="dir" class="form-label">Dirección de entrega</label>
						<select class="form-control form-control-sm input" name="direccion_envio" id="direccion_envio" required>
							<option value="">Seleccione dir de entrega</option>
							@foreach($direccion as $dir)
							<option value="{{ $dir->direccion }}">{{ $dir->direccion }}</option>
							<option value="{{ $dir->direccion1 }}">{{ $dir->direccion1 }}</option>
							<option value="{{ $dir->direccion2 }}">{{ $dir->direccion2 }}</option>
							<option value="{{ $dir->direccion3 }}">{{ $dir->direccion3 }}</option>
							<option value="{{ $dir->direccion4 }}">{{ $dir->direccion4 }}</option>
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
						<label for="" class="form-label">Alistador</label>
						<select class="form-control form-control-sm input" name="alistador" id="alistador" required>
							<option value="">Seleccione el alistador</option>
							@foreach($alistadores as $alistador)
							<option value="{{ $alistador->id }}">{{ $alistador->name }}</option>
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="date1" class="form-label">Fecha de entrega</label>
						<input type="date" class="form-control" name="fecha_entrega" id="fecha_entrega" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>		

			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="hora_inicial_entrega" class="form-label">Hora inicial de entrega</label>
						<select class="form-control form-control-sm input" name="hora_inicial_entrega" id="hora_inicial_entrega" required>
							<option value="">Seleccione hora de entrega</option>
							@php
							$startTime = strtotime('08:00');
							$endTime = strtotime('17:00');
							$interval = 60 * 60; // 1 hour interval
							for ($i = $startTime; $i <= $endTime; $i +=$interval) { echo '<option value="' . date('H:i', $i) . '">' . date('h:i A', $i) . '</option>' ; } @endphp </select>
								<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="hora_final_entrega" class="form-label">Hora final de entrega</label>
						<select class="form-control form-control-sm input" name="hora_final_entrega" id="hora_final_entrega" required>
							<option value="">Seleccione hora de entrega</option>
							@php
							$startTime = strtotime('08:00');
							$endTime = strtotime('17:00');
							$interval = 60 * 60; // 1 hour interval
							for ($i = $startTime; $i <= $endTime; $i +=$interval) { echo '<option value="' . date('H:i', $i) . '">' . date('h:i A', $i) . '</option>' ; } @endphp </select>
								<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>	
			
			<div class="col-md-4">
				<div class="task-header">
					<div class="form-group">
						<label for="dir" class="form-label">Forma de pago</label>
						<select class="form-control form-control-sm input" name="forma_de_pago" id="forma_de_pago" required>
							<option value="">Seleccione forma de pago</option>
							@foreach($formapagos as $fp)
							<option value="{{ $fp->id }}">{{ $fp->nombre }}</option>						
							@endforeach
						</select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group">
					<label for="observations">Observación general</label>
					<textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
				</div>
			</div>
			
		</div>
	</div>
</div>