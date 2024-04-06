<style>
	#div1, #div2, #div3, #div4, #div5, #div6 {
    display: none;
}
</style>
<div class="row">
	<div class="col-sm-12">
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
									<label>Centro de costo</label>
									<div>
										<select class="form-control form-control-sm" name="centrocosto_id" id="centrocosto_id" required="">
											<option value="">Seleccione centro de costo</option>
											@foreach ($centros as $c)
											<option value="{{$c->id}}" {{ $c->id == 1 ? 'selected' : '' }}>{{$c->name}}</option>
											@endforeach
										</select>
										@error('centrocostoid') <span class="text-danger er">{{ $message}}</span>@enderror
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div class="task-header">
								<div class="form-group">
									<label>Proveedor</label>
									<select class="form-control selectProvider" name="thirds_id" id="thirds_id" required="">
										<option value="">Buscar un proveedor</option>
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
									<label>Cliente visceras</label>
									<select class="form-control selectVisceras" name="clientvisceras_id" id="clientvisceras_id" required="">
										<option value="">Buscar un Cliente Viscera</option>
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
									<input type="text" class="form-control" name="finca" id="finca" placeholder="ej: La finca" required>
									@error('finca') <span class="text-danger er">{{ $message}}</span>@enderror
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div class="task-header">
								<div class="form-group">
									<label>Planta Sacrificio</label>
									<div>
										<select class="form-control form-control-sm" name="plantasacrificiocerdo_id" id="plantasacrificiocerdo_id" required="">
											<option value="">Seleccione planta Sacrificio</option>
											@foreach ($sacrificios as $s)
											<option value="{{$s->id}}">{{$s->name}}</option>
											@endforeach
										</select>
										@error('plantasacrificiocerdoid') <span class="text-danger er">{{ $message}}</span>@enderror
									</div>
								</div>
							</div>
						</div>
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
						<!--div class="col-sm-12 col-md-4">
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
											<label>Lote</label>
											<input type="text" class="form-control" name="lote" id="lote" placeholder="ej: PCD789" required="" readonly>
											@error('lote') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>-->
					</div>
				</div>
			</div>
		</div>
		<div class="">
			<div class="col-md-12">
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
													<input type="text" name="pesopie1" id="pesopie1" class="form-control" aria-describedby="helpId" placeholder="0" step="0.01" required="">
													<span class="input-group-text" id="addon-wrapping">KG</span>
												</div>
											</div>
											<div class="col">
												<label for="sell_price">Costo Animal 1</label>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">$</span>
													<input type="text" name="costoanimal1" id="costoanimal1" class="form-control" aria-describedby="helpId" placeholder="0" step="0.01" required>
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
													<input type="text" name="pesopie2" id="pesopie2" class="form-control" value="0" placeholder="0" aria-describedby="helpId" step="0.01">
													<span class="input-group-text" id="addon-wrapping">KG</span>
												</div>
											</div>
											<div class="col">
												<label for="sell_price">Costo Animal 2</label>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">$</span>
													<input type="text" name="costoanimal2" id="costoanimal2" class="form-control" value="0" placeholder="0" aria-describedby="helpId" step="0.01">
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
													<input type="text" name="pesopie3" id="pesopie3" class="form-control" value="0" placeholder="0" aria-describedby="helpId" step="0.01">
													<span class="input-group-text" id="addon-wrapping">KG</span>
												</div>
											</div>
											<div class="col">
												<label for="sell_price">Costo Animal 3</label>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">$</span>
													<input type="text" name="costoanimal3" id="costoanimal3" class="form-control" value="0" placeholder="0" aria-describedby="helpId" step="0.01">
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
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-2">
						<div class="task-header">
							<div class="form-group">
								<label>Cantidad</label>
								<!--input type="number" name="cantidad" id="cantidad" class="form-control" "aria-describedby=" helpId" required="" min="1" max="30" step="1" value="1">-->
								<input type="number" name="cantidadMacho" id="cantidadMacho" class="form-control" "aria-describedby=" helpId" required="" min="1" max="30" step="1" value="0">
								@error('cantidadMacho') <span class="text-danger er">{{ $message}}</span>@enderror
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-2">
						<div class="task-header">
							<label>Valor Viscera</label>
							<div class="input-group flex-nowrap">
								<span class="input-group-text" id="addon-wrapping">$</span>
								<input type="text" name="valorUnitarioMacho" id="valorUnitarioMacho" class="form-control" "aria-describedby=" helpId" placeholder="0" required="" min="1" step="1">
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-2">
						<div class="task-header">
							<label>Total</label>
							<div class="input-group flex-nowrap">
								<span class="input-group-text" id="addon-wrapping">$</span>
								<input type="text" name="valorTotalMacho" id="valorTotalMacho" class="form-control" "aria-describedby=" helpId" required="" min="1" step="1" readonly>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-2" id="div1">
						<div class="task-header">
							<div class="form-group">
								<label>Cantidad <br> Hembra</label>
								<input type="number" name="cantidadHembra" id="cantidadHembra" class="form-control" "aria-describedby=" helpId" min="0" max="30" step="0" value="0">
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-2" id="div2">
						<div class="task-header">
							<label>Valor Viscera Hembra</label>
							<div class="input-group flex-nowrap">
								<span class="input-group-text" id="addon-wrapping">$</span>
								<input type="text" name="valorUnitarioHembra" id="valorUnitarioHembra" class="form-control" "aria-describedby=" helpId" placeholder="0" min="0" step="0">
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-2" id="div3">
						<div class="task-header">
							<label>Total <br>Hembra</label>
							<div class="input-group flex-nowrap">
								<span class="input-group-text" id="addon-wrapping">$</span>
								<input type="text" name="valorTotalHembra" id="valorTotalHembra" class="form-control" "aria-describedby=" helpId" min="0" step="0" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="card">
			<div class="card-header text-center">
				Datos Frigorifico
			</div>
			<div class="container-fluid">
				<div class="form-row mt-1">
					<div class="form-group col-md-12">
						<div class=" ">
							<div class="">
								<div class="form-row mt-3">
									<div class="col-md-2">
										<label for="canalcaliente">Canal Caliente</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="canalcaliente" id="canalcaliente" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required>
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>
									<div class="col-md-2">
										<label for="canalfria">Canal Fria</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="canalfria" id="canalfria" value="0" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01">
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>
									<div class="col-md-2">
										<label for="sell_price">Canal Planta</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="canalplanta" id="canalplanta" value="0" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01">
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>
									<div class="col-md-2" id="div4">
										<label for="pieleskg">Pieles Kg</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="pieleskg" id="pieleskg" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" value="0">
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>
									<div class="col-md-2" id="div5">
										<label for="pielescosto">Piel Costo</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="pielescosto" id="pielescosto" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" value="0">
										</div>
									</div>
									<div class="col-md-2">
										<label for="visceras">Visceras Costo</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="visceras" id="visceras" class="form-control" placeholder="0" aria-describedby="helpId" step="0.01" required readonly>
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
					<div class="form-group col-md-6">
						<div class="card" style="border:1px solid #fffff;">
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
											<input type="text" name="tsacrificio" id="tsacrificio" class="form-control " aria-describedby="helpId" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<label for="tfomento">Fomento</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="tfomento" id="tfomento" class="form-control" aria-describedby="helpId" readonly step="0.01">
										</div>
									</div>
									<div class="col-md-4">
										<label for="tdeguello">Deguello</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="tdeguello" id="tdeguello" class="form-control" aria-describedby="helpId" readonly step="0.01">
										</div>
									</div>
									<div class="col-md-4">
										<label for="tbascula">Báscula</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="tbascula" id="tbascula" class="form-control" aria-describedby="helpId" readonly step="0.01">
										</div>
									</div>
									<div class="col-md-4">
										<label for="ttransporte">Transporte</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="ttransporte" id="ttransporte" class="form-control" aria-describedby="helpId" readonly step="0.01">
										</div>
									</div>
									<div class="col-md-4" id="div6">
										<label for="tpieles">Pieles</label>
										<div class="input-group flex-nowrap">
											<span class="input-group-text" id="addon-wrapping">$</span>
											<input type="text" name="tpieles" id="tpieles" class="form-control" aria-describedby="helpId" readonly step="0.01" value="0">
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
						<div class="card" style="border:1px solid #fffff;">
							<div class="m-2">
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
										<label for="rtcanalcaliente">Canal Caliente</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="rtcanalcaliente" id="rtcanalcaliente" class="form-control" aria-describedby="helpId" readonly step="0.01">
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>
									<div class="col-md-4">
										<label for="rtcanalplanta">Canal Planta</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="rtcanalplanta" id="rtcanalplanta" class="form-control" aria-describedby="helpId" readonly step="0.01">
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
										<label for="rendcaliente">Rend.Caliente</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="rendcaliente" id="rendcaliente" class="form-control" aria-describedby="helpId" readonly step="0.01">
											<span class="input-group-text" id="addon-wrapping">KG</span>
										</div>
									</div>
									<div class="col-md-4">
										<label for="rendplanta">Rend.Planta</label>
										<div class="input-group flex-nowrap">
											<input type="text" name="rendplanta" id="rendplanta" class="form-control" aria-describedby="helpId" readonly step="0.01">
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
			</div>
		</div>
		<!--div class="modal-footer">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>-->
	</div>
</div>