
<!-- modal -->
<div class="modal fade" id="editpc_modal"  >
		<div class="modal-dialog modal-md" >
			<div class="modal-content bg-default">
			
					<form id="parametrocontabledata">
					{{ csrf_field() }}
						<div class="modal-header">
							<h4 class="modal-title">Editar Parámetro Cotable</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
						</div>
				 		<div class="modal-body">
						 <div class="card">
								<div class="card-body">
									
									<div class="row g-3">
										<div class="col-md-6">
											<div class="task-header">
												<div class="form-group">
													<label for="" class="form-label">Código</label>
													<input type="text" class="form-control" id="codigo" name="codigo" required="true" value="">
													<span class="text-danger error-message"></span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="task-header">
												<div class="form-group">
													<label for="" class="form-label">Nombre</label>
													<input type="text" class="form-control" id="nombre" name="nombre" required="true" value="">
													<span class="text-danger error-message"></span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="task-header">
												<div class="form-group">
													<label for="" class="form-label">Tipo</label>
													<select class="form-control form-control-sm input" name="tipoparametro" id="tipoparametro" required value="{{$pc->tipoparametro}}">
														<option value="">Seleccione el tipo</option>
														<option value="COMPRA"  @if ($pc->tipoparametro == "COMPRA"){{'selected="selected"'}} @endif > COMPRA </option>
														<option value="VENTA"   @if ($pc->tipoparametro == "VENTA"){{'selected="selected"'}} @endif >  VENTA </option>
														<option value="GASTO"   @if ($pc->tipoparametro == "GASTO"){{'selected="selected"'}} @endif > GASTO  </option>
													</select>
													<span class="text-danger error-message"></span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="task-header">
												<div class="form-group">
													<label for="" class="form-label">Cuenta Contable</label>
													<input type="text" class="form-control" id="cuenta" name="cuenta" required="true" value="{{$pc->cuenta}}">
													<span class="text-danger error-message"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" id="btnAddFormapago" class="btn btn-primary">Aceptar</button>
						</div>
					</form>
				
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

