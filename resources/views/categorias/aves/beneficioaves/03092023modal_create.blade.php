					<style>
						.input-ave {
							width: 90%;
							 /*outline: none;
							 border: none;*/
						}
					</style>
					<div class="row">

						<div class="col-sm-12">
							<div>
								<div class="">
									<div class="connect-sorting-content">
										<div class="card simple-title-task ui-sortable-handle">
											<div class="card-body">
												<div class="btn-toolbar justify-content-between">
													<div>
														<input type="hidden" value="0" name="idbeneficio" id="idbeneficio" >
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
																<label>Factura</label>
																<input type="text" class="form-control" name="factura" id="factura" placeholder="ej: PCD789" required="">
																@error('cantidad') <span class="text-danger er">{{ $message}}</span>@enderror
															</div>
														</div>
													</div>

													<div class="col-sm-12 col-md-4">
														<div class="task-header">
															<div class="form-group">
																<label>Finca</label>
																<input type="text" class="form-control" name="finca" id="finca" placeholder="Nombre" required="">
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
													<!--div class="col-sm-12 col-md-3">
														<div class="task-header">
															<div class="form-group">
																<label>Cantidad</label>
																<input type="number" name="cantidad" id="cantidad" class="form-control" "aria-describedby=" helpId" required="" min="1" max="30" step="1" value="1">
																@error('cantidad') <span class="text-danger er">{{ $message}}</span>@enderror
															</div>
														</div>
													</div>-->
													<div class="form-group col-md-12">
														<div class="form-row">
															<div class="col">
																<label for="sacrificio">Sacrificio</label>
																<div class="input-group flex-nowrap">
																<span class="input-group-text" id="addon-wrapping">$</span>
																<input type="text" name="sacrificio" id="sacrificio" class="form-control" aria-describedby="helpId" step="0.01" readonly>
																</div>
															</div>
															<div class="col">
																<label for="fomento">Fomento</label>
																<div class="input-group flex-nowrap">
																	<span class="input-group-text" id="addon-wrapping">$</span>
																	<input type="text" name="fomento" id="fomento" class="form-control" aria-describedby="helpId" step="0.01">
																</div>
															</div>
															<div class="col">
																<label for="deguello">Deguello</label>
																<div class="input-group flex-nowrap">
																	<span class="input-group-text" id="addon-wrapping">$</span>
																	<input type="text" name="deguello" id="deguello" class="form-control" aria-describedby="helpId" readonly step="0.01">
																</div>
															</div>
															<div class="col">
																<label for="bascula">Báscula</label>
																<div class="input-group flex-nowrap">
																	<span class="input-group-text" id="addon-wrapping">$</span>
																	<input type="text" name="bascula" id="bascula" class="form-control" aria-describedby="helpId" readonly step="0.01">
																</div>
															</div>
															<div class="col">
																<label for="transporte">Transporte</label>
																<div class="input-group flex-nowrap">
																	<span class="input-group-text" id="addon-wrapping">$</span>
																	<input type="text" name="transporte" id="transporte" class="form-control" aria-describedby="helpId" step="0.01" readonly>
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>

									<div class="">
										<div class="form-group col-md-12">
											<div class="form-row mt-2">
												<div class="col-md-4">
													<div class="form-group col-xs-4">
														<div class="">
															<div class="card text-center">
																<div class="card-header">
																	Costo 1
																</div>
																<div class="card-body">
																	<div class="form-row">
																		<div class="col">
																			<label for="sell_price1">Peso pie 1</label>
																			<div class="input-group flex-nowrap">
																				<input type="text" name="pesopie1" id="pesopie1" class="form-control" aria-describedby="helpId" placeholder="000.000" step="0.01" required="">
																				<span class="input-group-text" id="addon-wrapping">KG</span>
																			</div>
																		</div>
																		<div class="col">
																			<label for="sell_price">Costo Animal 1</label>
																			<div class="input-group flex-nowrap">
																				<span class="input-group-text" id="addon-wrapping">$</span>
																				<input type="text" name="costoanimal1" id="costoanimal1" class="form-control" aria-describedby="helpId" placeholder="000.000" step="0.01" required>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

												</div>
												<div class="col-md-4">
													<div class="form-group col-xs-4">
														<div class="">
															<div class="card text-center">
																<div class="card-header">
																	Costo 2
																</div>
																<div class="card-body">
																	<div class="form-row">
																		<div class="col">
																			<label for="sell_price">Peso pie 2</label>
																			<div class="input-group flex-nowrap">
																				<input type="text" name="pesopie2" id="pesopie2" class="form-control" value="0" placeholder="000.000" aria-describedby="helpId" step="0.01">
																				<span class="input-group-text" id="addon-wrapping">KG</span>
																			</div>
																		</div>
																		<div class="col">
																			<label for="sell_price">Costo Animal 2</label>
																			<div class="input-group flex-nowrap">
																				<span class="input-group-text" id="addon-wrapping">$</span>
																				<input type="text" name="costoanimal2" id="costoanimal2" class="form-control" value="0" placeholder="000.000" aria-describedby="helpId" step="0.01">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group col-xs-4">
														<div class="">
															<div class="card text-center">
																<div class="card-header">
																	Costo 3
																</div>
																<div class="card-body">
																	<div class="form-row">
																		<div class="col">
																			<label for="sell_price">Peso pie 3</label>
																			<div class="input-group flex-nowrap">
																				<input type="text" name="pesopie3" id="pesopie3" class="form-control" value="0" placeholder="000.000" aria-describedby="helpId" step="0.01">
																				<span class="input-group-text" id="addon-wrapping">KG</span>
																			</div>
																		</div>
																		<div class="col">
																			<label for="sell_price">Costo Animal 3</label>
																			<div class="input-group flex-nowrap">
																				<span class="input-group-text" id="addon-wrapping">$</span>
																				<input type="text" name="costoanimal3" id="costoanimal3" class="form-control" value="0" placeholder="000.000" aria-describedby="helpId" step="0.01">
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

										<!--div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-sm-12 col-md-2">
														<div class="task-header">
															<div class="form-group">
																<label>Cantidad <br> Macho</label>
																<input type="number" name="cantidadMacho" id="cantidadMacho" class="form-control" "aria-describedby=" helpId" required="" min="1" max="30" step="1" value="1">
																@error('cantidadMacho') <span class="text-danger er">{{ $message}}</span>@enderror
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-md-2">
														<div class="task-header">
															<label>Valor Viscera Macho</label>
															<div class="input-group flex-nowrap">
																<span class="input-group-text" id="addon-wrapping">$</span>
																<input type="text" name="valorUnitarioMacho" id="valorUnitarioMacho" class="form-control" "aria-describedby=" helpId" placeholder="000.000" required="" min="1" step="1">
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-md-2">
														<div class="task-header">
															<label>Total <br> Macho</label>
															<div class="input-group flex-nowrap">
																<span class="input-group-text" id="addon-wrapping">$</span>
																<input type="text" name="valorTotalMacho" id="valorTotalMacho" class="form-control" "aria-describedby=" helpId" required="" min="1"  step="1" readonly>
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-md-2">
														<div class="task-header">
															<div class="form-group">
																<label>Cantidad <br> Hembra</label>
																<input type="number" name="cantidadHembra" id="cantidadHembra" class="form-control" "aria-describedby=" helpId" required="" min="0" max="30" step="0" value="1">
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-md-2">
														<div class="task-header">
															<label>Valor Viscera Hembra</label>
															<div class="input-group flex-nowrap">
																<span class="input-group-text" id="addon-wrapping">$</span>
																<input type="text" name="valorUnitarioHembra" id="valorUnitarioHembra" class="form-control" "aria-describedby=" helpId" placeholder="000.000" required="" min="0"  step="0"  >
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-md-2">
														<div class="task-header">
															<label>Total <br>Hembra</label>
															<div class="input-group flex-nowrap">
																<span class="input-group-text" id="addon-wrapping">$</span>
																<input type="text" name="valorTotalHembra" id="valorTotalHembra" class="form-control" "aria-describedby=" helpId" required="" min="0"  step="0" readonly>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>-->

										<div class="card">
											<div class="card-header text-center">
												Modelo proceso de pollo
											</div>
											<div class="card-body">
												<!--div class="form-row mt-3">
													<div class="col-md-2">
														<label for="canalfria">Peso promedio</label>
														<div class="input-group flex-nowrap">
															<input type="text" name="canalfria" id="canalfria" class="form-control" aria-describedby="helpId" step="0.01" required>
															<span class="input-group-text" id="addon-wrapping">KG</span>
														</div>
													</div>
													<div class="col-md-2">
														<label for="pieleskg">Costo</label>
														<div class="input-group flex-nowrap">
															<input type="text" name="pieleskg" id="pieleskg" class="form-control" aria-describedby="helpId" step="0.01" required>
															<span class="input-group-text" id="addon-wrapping">KG</span>
														</div>
													</div>

													<div class="col-md-2">
														<label for="pielescosto">Costo de venta</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">KG</span>
															<input type="text" name="pielescosto" id="pielescosto" class="form-control" aria-describedby="helpId" step="0.01" required>
														</div>
													</div>
													<div class="col-md-2">
														<label for="visceras">Precio de venta</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">KG</span>
															<input type="text" name="visceras" id="visceras" class="form-control" aria-describedby="helpId" step="0.01" required>
														</div>
													</div>
													<div class="col-md-2">
														<label for="visceras">Venta en kg</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">$</span>
															<input type="text" name="visceras" id="visceras" class="form-control" aria-describedby="helpId" step="0.01" required>
														</div>
													</div>
													<div class="col-md-2">
														<label for="visceras">Ventas netas</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">$</span>
															<input type="text" name="visceras" id="visceras" class="form-control" aria-describedby="helpId" step="0.01" required>
														</div>
													</div>
													<div class="col-md-2">
														<label for="visceras">Utilidad</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">%</span>
															<input type="text" name="visceras" id="visceras" class="form-control" aria-describedby="helpId" step="0.01" required>
														</div>
													</div>
													<div class="col-md-2">
														<label for="visceras">Utilidad</label>
														<div class="input-group flex-nowrap">
															<span class="input-group-text" id="addon-wrapping">$</span>
															<input type="text" name="visceras" id="visceras" class="form-control" aria-describedby="helpId" step="0.01" required>
														</div>
													</div>
												</div>-->
												<table class="table">
													<thead>
														<tr>
														<th scope="col">Producto</th>
														<th scope="col">Peso promedio</th>
														<th scope="col">Costo</th>
														<th scope="col">Costo de venta kg</th>
														<th scope="col">Precio de venta kg</th>
														<th scope="col">Venta en kg</th>
														<th scope="col">Ventas netas</th>
														<th scope="col">Utilidad %</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														<th>Pollo entero promedio</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Cantidad</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="hidden" class="input-ave"></td>
														<td><input type="hidden" class="input-ave"></td>
														<td><input type="hidden" class="input-ave"></td>
														<td>Utilidad</td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="hidden" class="input-ave"></td>
														</tr>
														
													</tbody>
												</table>
												<table class="table">
													<thead>
														<tr>
														<th scope="col">Producto</th>
														<th scope="col">Esperado</th>
														<th scope="col">Peso kg</th>
														<th scope="col">Real</th>
														<th scope="col">Peso kg</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														<th>Peso pie en planta</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Canal fria puesta en sala desposte</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<!--tr>
														<th>Pollo en canal</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>-->
														<tr>
														<th>Visceras</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Mollejas</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Corazones</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Despojo</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Total peso</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
													</tbody>
												</table> 	
												<div class="div.card">
													<div class="card-header text-center">
														Fletes - transporte
													</div>
												</div><br>
												<table class="table">
													<thead>
														<tr>
														<th scope="col">Ciudad</th>
														<th scope="col">Costo</th>
														<th scope="col">Cantidad</th>
														<th scope="col">Valor unidad</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														<td><input type="text" class="input-ave form-control" value="bogota - planta"></td>
														<td><input type="text" class="input-ave form-control" value="0"></td>
														<td><input type="text" class="input-ave form-control" value="425"></td>
														<td><input type="text" class="input-ave form-control" value="0"></td>
														</tr>
														<tr>
														<td><input type="text" class="input-ave form-control" value="0"></td>
														<td><input type="text" class="input-ave form-control" value="pollo canal 5%"></td>
														<td><input type="text" class="input-ave form-control" value="pollo en pie"></td>
														<td><input type="text" class="input-ave form-control" value="2.55"></td>
														</tr>
														<tr>
														<td><input type="text" class="input-ave form-control" value="425"></td>
														<td><input type="text" class="input-ave form-control" value="pollo desposte 5%"></td>
														<td><input type="text" class="input-ave form-control" value="pollo en canal"></td>
														<td><input type="text" class="input-ave form-control" value="2.55"></td>
														</tr>
														<tr>
														<td><input type="text" class="input-ave form-control" value="425"></td>
														<td><input type="text" class="input-ave form-control" value="100%"></td>
														<td><input type="text" class="input-ave form-control" value="Rendimiento"></td>
														<td><input type="text" class="input-ave form-control" value="100"></td>
														</tr>
													</tbody>
												</table>
												<div class="div.card">
													<div class="card-header text-center">
														Gastos
													</div>
												</div><br>
												<table class="table">
													<thead>
														<tr>
														<th scope="col">Concepto gastos</th>
														<th scope="col">Valor</th>
														<th scope="col">Unidad</th>
														<th scope="col">Cantidad</th>
														<th scope="col">Total</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														<th>Animal puesto en planta</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>servicio de sacrificio</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Transporte por canal</th>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
														<tr>
														<th>Total</th>
														<td><input type="hidden" class="input-ave form-control"></td>
														<td><input type="hidden" class="input-ave form-control"></td>
														<td><input type="hidden" class="input-ave form-control"></td>
														<td><input type="text" class="input-ave form-control"></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>

										<!--div class="">
											<div class="">
												<div class="">
													<div class="card">
														<div class="card-header text-center">
															Datos Frigorifico
														</div>
														<div class="card-body">

															<div class="form-row mt-3">
																<div class="col-md-2">
																	<label for="canalfria">Canal fria</label>
																	<div class="input-group flex-nowrap">
																		<input type="text" name="canalfria" id="canalfria" class="form-control" aria-describedby="helpId" step="0.01" required>
																		<span class="input-group-text" id="addon-wrapping">KG</span>
																	</div>
																</div>
																<div class="form-group col-md-2">
																</div>

																<div class="form-group col-md-2">
																</div>
																<div class="col-md-2">
																	<label for="pieleskg">Kg Menudencias</label>
																	<div class="input-group flex-nowrap">
																		<input type="text" name="pieleskg" id="pieleskg" class="form-control" aria-describedby="helpId" step="0.01" required>
																		<span class="input-group-text" id="addon-wrapping">KG</span>
																	</div>
																</div>

																<div class="col-md-2">
																	<label for="pielescosto">Piel Costo</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="pielescosto" id="pielescosto" class="form-control" aria-describedby="helpId" step="0.01" required>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="visceras">Visceras Costo</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="visceras" id="visceras" class="form-control" aria-describedby="helpId" step="0.01" required>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="">
											<div class="form-row mt-1">
												<div class="form-group col-md-6">
													<div class="card">
														<div class="m-2">
															<div class="card-title">TOTALES</div>
															<div class="form-row">
																<div class="col-md-4">
																	<label for="costopie1">Costo Animal 1</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="costopie1" id="costopie1" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="costopie2">Costo Animal 2</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="costopie2" id="costopie2" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="costopie3">Costo Animal 3</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="costopie3" id="costopie3" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>

																<div class="col-md-4">
																	<label for="costokilo">Sacrificio</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="tsacrificio" id="tsacrificio" class="form-control " aria-describedby="helpId" readonly >
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="tpieles">Pieles</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="tpieles" id="tpieles" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>

																<div class="col-md-4">
																	<label for="tvisceras">Visceras</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="tvisceras" id="tvisceras" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="tcanalfria">Canal Fría</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="tcanalfria" id="tcanalfria" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="valorfactura">Valor Factura</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="valorfactura" id="valorfactura" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>

																<div class="col-md-4">
																	<label for="costokilo">Costo Kilo</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="costokilo" id="costokilo" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="costo">Costo</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="costo" id="costo" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="totalcostos">Total Costos</label>
																	<div class="input-group flex-nowrap">
																		<span class="input-group-text" id="addon-wrapping">$</span>
																		<input type="text" name="totalcostos" id="totalcostos" class="form-control" aria-describedby="helpId" readonly step="0.01">
																	</div>
																</div>

															</div>
														</div>
													</div>
												</div>

												<div class="form-group col-md-6">
													<div class="card">
														<div class="card-body">
															<div class="card-title">RENDIMIENTO</div>
															<div class="form-row">
																<div class="col-md-4">
																	<label for="pesopie">Peso Pie</label>
																	<div class="input-group flex-nowrap">
																		<input type="text" name="pesopie" id="pesopie" class="form-control" aria-describedby="helpId" readonly step="0.01">
																		<span class="input-group-text" id="addon-wrapping">KG</span>
																	</div>
																</div>

																<div class="col-md-4">
																	<label for="rtcanalfria">Canal Fría</label>
																	<div class="input-group flex-nowrap">
																		<input type="text" name="rtcanalfria" id="rtcanalfria" class="form-control" aria-describedby="helpId" readonly step="0.01">
																		<span class="input-group-text" id="addon-wrapping">KG</span>
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="rendfrio">Rend.Frio</label>
																	<div class="input-group flex-nowrap">
																		<input type="text" name="rendfrio" id="rendfrio" class="form-control" aria-describedby="helpId" readonly step="0.01">
																		<span class="input-group-text" id="addon-wrapping">KG</span>
																	</div>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>-->

									</div>

								</div>
							</div>
						</div>
					</div>
			