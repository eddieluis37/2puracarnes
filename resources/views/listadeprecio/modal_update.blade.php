<!-- modal -->
<div class="modal fade" id="editlp_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content bg-default">

			<form id="formapagodata">
				{{ csrf_field() }}
				<div class="modal-header">
					<h4 class="modal-title">Editar lista de precio</h4>
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
											<label for="" class="form-label">Centro costo</label>
											<select name="centro_costo_id" class="form-control">
												@foreach($centros as $centrocosto)
												<option value="{{ $centrocosto->id }}" {{ $lp->centrocosto->id == $centrocosto->id ? 'selected' : '' }}>
													{{ $centrocosto->name }}
												</option>
												@endforeach
											</select>
											<span class="text-danger error-message"></span>
										</div>
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
										<select class="form-control form-control-sm input" name="tipo" id="tipo" required value="{{$lp->tipo}}">
											<option value="">Seleccione el tipo</option>
											<option value="NICHO" @if ($lp->tipo == "NICHO"){{'selected="selected"'}} @endif > NICHO </option>
											<option value="GENERAL" @if ($lp->tipo == "GENERAL"){{'selected="selected"'}} @endif > GENERAL </option>
										</select>
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