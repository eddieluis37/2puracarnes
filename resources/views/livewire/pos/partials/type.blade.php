<div class="row mt-3">	
	<div class="col-sm-12">
		<div>
			<div class="connect-sorting">
				
				<h5 class="text-center mb-3">SELECCIONE</h5>

				<div class="connect-sorting-content">
					<div class="card simple-title-task ui-sortable-handle">
						<div class="card-body">

							<div class="btn-toolbar justify-content-between">
								<div class="col-sm-8">
								
									<div class="task-header">

										<div class="form-group">

											<label>Cliente</label>
											<select wire:model="thirdid" class="form-control">
												<option value="Elegir" selected>Elegir</option>					                                
				                                @foreach($thirds as $t)
				                                <option value="{{$t->id}}">{{$t->name}}</option>
				                                @endforeach
				                            </select>
											@error('thirdid') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>

									</div>							

								</div>
								
								<div class="col-sm-4">
								
									<div class="task-header">

										<div class="form-group">

											<label>Pago</label>
											<select wire:model='status' class="form-control">
												<option value="Elegir" selected>Elegir</option>	
												<option value="CONTRAENTREGA">ContraEntrega</option>
												<option value="CREDITO">Credito</option>
												<option value="EFECTIVO">Efectivo</option>
												<option value="WONPI">Wompi</option>						
												
											</select>
											@error('status') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>

									</div>							

								</div>

								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>