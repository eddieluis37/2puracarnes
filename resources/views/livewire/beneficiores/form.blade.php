 <fieldset id="contentDisable">
<form action="{{ route('store') }}" id="formBeneficiores" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="connect-sorting-content">
					<div class="card simple-title-task ui-sortable-handle">
						<div class="card-body">
							<div class="btn-toolbar justify-content-between">
								<div>
									<input type="hidden" value="0" name="idbeneficio" id="idbeneficio" >
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="task-header">
										<div class="form-group">
											<label>Proveedor</label>
											<select class="form-control selectProvider" name="thirds_id" id="thirds_id" required="">
												<option value="">Seleccione el proveedor</option>
												@foreach ($thirds as $p)
												<option value="{{$p->id}}">{{$p->name}}</option>
												@endforeach
											</select>
											@error('thirdsid') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="task-header">
										<div class="form-group">
											<label>Planta Sacrificio</label>
											<div>
												<select class="form-control form-control-sm" name="plantasacrificio_id" id="plantasacrificio_id" required="">
													<option value="">Seleccione planta</option>
													@foreach ($sacrificios as $s)
													<option value="{{$s->id}}">{{$s->name}}</option>
													@endforeach
												</select>
												@error('plantasacrificioid') <span class="text-danger er">{{ $message}}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Cantidad Macho</label>
											<!--input type="number" name="cantidad" id="cantidad" class="form-control" "aria-describedby=" helpId" required="" min="1" max="30" step="1" value="1">-->
											<input type="number" name="cantidadMacho" id="cantidadMacho" class="form-control" "aria-describedby=" helpId" required="" min="1" max="30" step="1" value="1">
											@error('cantidadMacho') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Valor Unitario</label>
											<input type="text" name="valorUnitarioMacho" id="valorUnitarioMacho" class="form-control" "aria-describedby=" helpId" placeholder="000.000" required="" min="1" step="1">
											@error('valorUnitarioMacho') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Valor Total</label>
											<input type="text" name="valorTotalMacho" id="valorTotalMacho" class="form-control" "aria-describedby=" helpId" required="" min="1"  step="1" readonly>
											@error('valorTotalMacho') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Cantidad Hembra</label>
											<input type="number" name="cantidadHembra" id="cantidadHembra" class="form-control" "aria-describedby=" helpId" required="" min="0" max="30" step="0" value="1">
											@error('cantidadHembra') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Valor Unitario</label>
											<input type="text" name="valorUnitarioHembra" id="valorUnitarioHembra" class="form-control" "aria-describedby=" helpId" placeholder="000.000" required="" min="0"  step="0"  >
											@error('valorUnitarioHembra') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2">
									<div class="task-header">
										<div class="form-group">
											<label>Valor Total</label>
											<input type="text" name="valorTotalHembra" id="valorTotalHembra" class="form-control" "aria-describedby=" helpId" required="" min="0"  step="0" readonly>
											@error('valorTotalHembra') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Fecha</label>
											<input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_beneficio" id="fecha_beneficio" placeholder="ej: dd/dd/aaaa">
											@error('fecha_beneficio') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Factura</label>
											<input type="text" class="form-control" name="factura" id="factura" placeholder="ej: PCD789" required="">
											@error('cantidad') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Cliente Pielees</label>
											<select class="form-control selectPieles" name="clientpieles_id" id="clientpieles_id" required="">
												<option value="">Seleccione el proveedor</option>
												@foreach ($thirds as $p)
												<option value="{{$p->id}}">{{$p->name}}</option>
												@endforeach
											</select>
											@error('clientpielesid') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Cliente visceras</label>
											<select class="form-control selectVisceras" name="clientvisceras_id" id="clientvisceras_id" required="">
												<option value="">Seleccione el proveedor</option>
												@foreach ($thirds as $p)
												<option value="{{$p->id}}">{{$p->name}}</option>
												@endforeach
											</select>
											@error('clientviscerasid') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Finca</label>
											<input type="text" class="form-control" name="finca" id="finca" placeholder="ej: La finca">
											@error('finca') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Lote</label>
											<input type="text" class="form-control" name="lote" id="lote" placeholder="ej: PCD789" required="" readonly>
											@error('lote') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="form-row">
										<div class="form-group col-md-2">
											<label for="sacrificio">Sacrificio</label>
											<input type="text" name="sacrificio" id="sacrificio" class="form-control" aria-describedby="helpId" step="0.01" readonly>
										</div>
										<div class="form-group col-md-2">
											<label for="fomento">Fomento</label>
											<input type="text" name="fomento" id="fomento" class="form-control" aria-describedby="helpId" step="0.01">
										</div>
										<div class="form-group col-md-2">
											<label for="deguello">Deguello</label>
											<input type="text" name="deguello" id="deguello" class="form-control" aria-describedby="helpId" readonly step="0.01">
										</div>
										<div class="form-group col-md-2">
											<label for="bascula">Báscula</label>
											<input type="text" name="bascula" id="bascula" class="form-control" aria-describedby="helpId" readonly step="0.01">
										</div>
										<div class="form-group col-md-2">
											<label for="transporte">Transporte</label>
											<input type="text" name="transporte" id="transporte" class="form-control" aria-describedby="helpId" step="0.01" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class=form-group "col-md-12">
						<div class="form-row mt-3">
							<div class="col-md-4">
								<div class="form-group col-xs-4">
									<div class="card-body">
										<div class="card text-center">
											<div class="card-header">
												Costo 1
											</div>
											<div class="card-body">
												<div class="form-row">
													<div class="form-group col-sm">
														<label for="sell_price1">Peso pie 1</label>
														<input type="text" name="pesopie1" id="pesopie1" class="form-control" aria-describedby="helpId" placeholder="000.000" step="0.01" required="">
													</div>
													<div class="form-group col-sm">
														<label for="sell_price">Costo Animal 1</label>
														<input type="text" name="costoanimal1" id="costoanimal1" class="form-control" aria-describedby="helpId" placeholder="000.000" step="0.01" required>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group col-xs-4">
									<div class="card-body">
										<div class="card text-center">
											<div class="card-header">
												Costo 2
											</div>
											<div class="card-body">
												<div class="form-row">
													<div class="form-group col-sm">
														<label for="sell_price">Peso pie 2</label>
														<input type="text" name="pesopie2" id="pesopie2" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
													</div>

													<div class="form-group col-sm">
														<label for="sell_price">Costo Animal 2</label>
														<input type="text" name="costoanimal2" id="costoanimal2" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group col-xs-4">
									<div class="card-body">
										<div class="card text-center">
											<div class="card-header">
												Costo 3
											</div>
											<div class="card-body">
												<div class="form-row">
													<div class="form-group col-sm">
														<label for="sell_price">Peso pie 3</label>
														<input type="text" name="pesopie3" id="pesopie3" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
													</div>
													<div class="form-group col-sm">
														<label for="sell_price">Costo Animal 3</label>
														<input type="text" name="costoanimal3" id="costoanimal3" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container-fluid">
						<div class="form-row mt-1">
							<div class="form-group col-md-12">
								<div class="card text-center">
									<div class="card-header">
										Datos Frigorifico
									</div>
									<div class="card-body">
										<div class="form-row mt-3">
											<div class="form-group col-md-2">
												<label for="canalcaliente">Canal caliente</label>
												<input type="text" name="canalcaliente" id="canalcaliente" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
											</div>
											<div class="form-group col-md-2">
												<label for="canalfria">Canal fria</label>
												<input type="text" name="canalfria" id="canalfria" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
											</div>
											<div class="form-group col-md-2">
												<label for="sell_price">Canal planta</label>
												<input type="text" name="canalplanta" id="canalplanta" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
											</div>
											<div class="form-group col-md-2">
												<label for="pieleskg">Pieles Kg</label>
												<input type="text" name="pieleskg" id="pieleskg" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
											</div>
											<div class="form-group col-md-2">
												<label for="pielescosto">Piel Costo</label>
												<input type="text" name="pielescosto" id="pielescosto" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
											</div>
											<div class="form-group col-md-2">
												<label for="visceras">Visceras Costo</label>
												<input type="text" name="visceras" id="visceras" class="form-control" placeholder="000.000" aria-describedby="helpId" step="0.01">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container-fluid">
						<div class="form-row mt-2">
							<div class="form-group col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="card-title">TOTALES</div>
										<div class="form-row">
											<div class="form-group col-md-4">
												<label for="costopie1">Costo Animal 1</label>
												<input type="text" name="costopie1" id="costopie1" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="costopie2">Costo Animal 2</label>
												<input type="text" name="costopie2" id="costopie2" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="costopie3">Costo Animal 3</label>
												<input type="text" name="costopie3" id="costopie3" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="costokilo">Sacrificio</label>
												<input type="text" name="tsacrificio" id="tsacrificio" class="form-control campo" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="tfomento">Fomento</label>
												<input type="text" name="tfomento" id="tfomento" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="tdeguello">Deguello</label>
												<input type="text" name="tdeguello" id="tdeguello" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="tbascula">Báscula</label>
												<input type="text" name="tbascula" id="tbascula" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="ttransporte">Transporte</label>
												<input type="text" name="ttransporte" id="ttransporte" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="tpieles">Pieles</label>
												<input type="text" name="tpieles" id="tpieles" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="tvisceras">Visceras</label>
												<input type="text" name="tvisceras" id="tvisceras" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="tcanalfria">Canal fría</label>
												<input type="text" name="tcanalfria" id="tcanalfria" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="valorfactura">Valor Factura</label>
												<input type="text" name="valorfactura" id="valorfactura" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="costokilo">Costo Kilo</label>
												<input type="text" name="costokilo" id="costokilo" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="costo">Costo</label>
												<input type="text" name="costo" id="costo" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="totalcostos">Total Costos</label>
												<input type="text" name="totalcostos" id="totalcostos" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<!-- 		
													<div class="col-md-4">
														<div class="task-header">
															<div class="form-group">
																<label>Sacrificio</label>
																<div class="form-control campo">{{number_format( $sacrificios[1]->sacrificio )}} </div>
															</div>
														</div>
													</div>															
 												-->
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="card-title">RENDIMIENTO</div>
										<div class="form-row">
											<div class="form-group col-md-4">
												<label for="pesopie">Peso Pie</label>
												<input type="text" name="pesopie" id="pesopie" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="rtcanalcaliente">Canal Caliente</label>
												<input type="text" name="rtcanalcaliente" id="rtcanalcaliente" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="rtcanalplanta">Canal Planta</label>
												<input type="text" name="rtcanalplanta" id="rtcanalplanta" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="rtcanalfria">Canal Fría</label>
												<input type="text" name="rtcanalfria" id="rtcanalfria" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="rendcaliente">Rend.Caliente</label>
												<input type="text" name="rendcaliente" id="rendcaliente" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="rendplanta">Rend.Planta</label>
												<input type="text" name="rendplanta" id="rendplanta" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
											<div class="form-group col-md-4">
												<label for="rendfrio">Rend.Frio</label>
												<input type="text" name="rendfrio" id="rendfrio" class="form-control" aria-describedby="helpId" readonly step="0.01">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</form>
</fieldset>