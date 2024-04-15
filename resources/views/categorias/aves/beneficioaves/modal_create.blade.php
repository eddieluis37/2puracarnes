					<div class="row">

						<div class="col-sm-12">
							<div>
								<div class="">
									<div class="connect-sorting-content">
										<div class="card simple-title-task ui-sortable-handle">
											<div class="card-body">
												<div class="btn-toolbar justify-content-between">
													<div>
														<input type="hidden" value="0" name="idbeneficio" id="idbeneficio">
													</div>
													<div class="col-sm-12 col-md-4">
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


													<div class="col-sm-12 col-md-4">
														<div class="task-header">
															<div class="form-group">
																<label>Cliente Subproducto_1</label>
																<select class="form-control selectPieles" name="clientsubproductos_uno_id" id="clientsubproductos_uno_id" required="">
																	<option value="">Seleccione el cliente</option>
																	@foreach ($thirds as $p)
																	<option value="{{$p->id}}">{{$p->name}}</option>
																	@endforeach
																</select>
																@error('clientsubproductos_uno_id') <span class="text-danger er">{{ $message}}</span>@enderror
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-md-4">
														<div class="task-header">
															<div class="form-group">
																<label>Cliente Subproducto_2</label>
																<select class="form-control selectVisceras" name="clientsubproductos_dos_id" id="clientsubproductos_dos_id" required="">
																	<option value="">Seleccione el cliente</option>
																	@foreach ($thirds as $p)
																	<option value="{{$p->id}}">{{$p->name}}</option>
																	@endforeach
																</select>
																@error('clientsubproductos_dos_id') <span class="text-danger er">{{ $message}}</span>@enderror
															</div>
														</div>
													</div>

													<div class="col-sm-12 col-md-2">
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
																<label>Planta Sacrificio</label>
																<div>
																	<select class="form-control" name="plantasacrificio_id" id="plantasacrificio_id" required="">
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
													<div class="col-sm-12 col-md-3">
														<div class="task-header">
															<div class="form-group">
																<label>Cantidad</label>
																<input type="number" name="cantidad" id="cantidad" class="form-control" "aria-describedby=" helpId" required="" min="1" max="900" step="1" value="1">
																@error('cantidad') <span class="text-danger er">{{ $message}}</span>@enderror
															</div>
														</div>
													</div>

													<div class="col-sm-12 col-md-3">
														<label for="sacrificio">Sacrificio</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">$</span>
															<input type="text" name="sacrificio" id="sacrificio" class="form-control" aria-describedby="helpId" step="0.01" readonly>
														</div>
													</div>
													<div class="col-md-4 d-flex justify-content-start">
														<div class="form-group col-xs-4 col-lg-12">
															<div class="col">
																<div class="task-header">
																	<div class="form-group">
																		<label>Fecha</label>
																		<input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_beneficio" id="fecha_beneficio" placeholder="ej: dd/dd/aaaa">
																		@error('fecha_beneficio') <span class="text-danger er">{{ $message}}</span>@enderror
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group col-xs-4 col-lg-12">
															<div class="col">
																<label for="sell_price">Valor Kg pollo</label>
																<div class="input-group flex-nowrap">
																	<span class="input-group-text" id="addon-wrapping">$</span>
																	<input type="text" name="valor_kg_pollo" id="valor_kg_pollo" class="form-control" value="0" placeholder="0" aria-describedby="helpId" step="0.01">
																</div>
															</div>
														</div>
														<div class="form-group col-xs-4 col-lg-12">
															<div class="col">
																<label for="total_factura">Total factura</label>
																<div class="input-group flex-nowrap">
																	<span class="input-group-text" id="addon-wrapping">$</span>
																	<input type="text" name="total_factura" id="total_factura" class="form-control" aria-describedby="helpId" step="0.01" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										</br>
										<div class="card">
											<div class="card-header text-center">
												Datos Frigorifico
											</div>
											<div class="container-fluid">
												<div class="form-row mt-1 justify-content-center"> <!-- Añade la clase justify-content-center para centrar las columnas -->
													<div class="form-group col-md-12">
														<div>
															<div>
																<div class="form-row mt-3">
																	<div class="col-md-3">
																		<label for="canalcaliente">Promedio en Pie</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="promedio_pie_kg" id="promedio_pie_kg" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required>
																			<span class="input-group-text" id="addon-wrapping">KG</span>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="canalfria">Peso pie planta</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="peso_pie_planta" id="peso_pie_planta" value="0" class="form-control" placeholder="111.999" aria-describedby="helpId" step="0.01" readonly>
																			<span class="input-group-text" id="addon-wrapping">KG</span>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="visceras">Promedio canal fria</label>
																		<div class="input-group flex-nowrap">
																			<span class="input-group-text" id="addon-wrapping">$</span>
																			<input type="text" name="promedio_canal_fria_sala" id="promedio_canal_fria_sala" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required readonly>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="canalfria">Peso canal en planta</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="peso_canales_pollo_planta" id="peso_canales_pollo_planta" value="0" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01">
																			<span class="input-group-text" id="addon-wrapping">KG</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group col-md-12">
														<div>
															<div>
																<div class="form-row mt-3">
																	<div class="col-md-3">
																		<label for="canalcaliente">Menudencia Kg</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="menudencia_pollo_kg" id="menudencia_pollo_kg" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required>
																			<span class="input-group-text" id="addon-wrapping">KG</span>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="mollejas_corazones_kg">Mollejas/Corazones</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="mollejas_corazones_kg" id="mollejas_corazones_kg" value="0" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01">
																			<span class="input-group-text" id="addon-wrapping">KG</span>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="subtotal">Subtotal</label>
																		<div class="input-group flex-nowrap">
																			<span class="input-group-text" id="addon-wrapping">$</span>
																			<input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required readonly>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="canalfria">Promedio en canal</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="promedio_canal_kg" id="promedio_canal_kg" value="0" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" readonly>
																			<span class="input-group-text" id="addon-wrapping">KG</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group col-md-12">
														<div>
															<div>
																<div class="form-row mt-3">
																	<div class="col-md-3">
																		<label for="menudencia_pollo_porc">Menudencia %</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="menudencia_pollo_porc" id="menudencia_pollo_porc" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" readonly>
																			<span class="input-group-text" id="addon-wrapping">%</span>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="mollejas_corazones_porc">Mollejas/Corazones</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="mollejas_corazones_porc" id="mollejas_corazones_porc" value="0" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" readonly>
																			<span class="input-group-text" id="addon-wrapping">%</span>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="despojos_mermas">Despojos/Mermas</label>
																		<div class="input-group flex-nowrap">
																			<span class="input-group-text" id="addon-wrapping">$</span>
																			<input type="text" name="despojos_mermas" id="despojos_mermas" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required readonly>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="porc_pollo">Porcentaje Pollo</label>
																		<div class="input-group flex-nowrap">
																			<input type="text" name="porc_pollo" id="porc_pollo" value="100" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01">
																			<span class="input-group-text" id="addon-wrapping">%</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<!--div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-outline-primary">Guardar</button>
									</div>-->
									</div>
								</div>
							</div>
						</div>