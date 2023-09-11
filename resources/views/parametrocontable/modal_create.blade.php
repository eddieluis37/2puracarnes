<div class="card">
	<div class="card-body">
		
		<div class="row g-3">
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Código</label>
						<input type="text" class="form-control" id="codigo" name="codigo" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Nombre</label>
						<input type="text" class="form-control" id="nombre" name="nombre" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Tipo</label>
					    <select class="form-control form-control-sm input" name="tipoparametro" id="tipoparametro" required>
						    <option value="">Seleccione el tipo</option>
							<option value="COMPRA"> COMPRA </option>
							<option value="VENTA"> VENTA </option>
							<option value="GASTO"> GASTO </option>
					    </select>
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="task-header">
					<div class="form-group">
                        <label for="" class="form-label">Cuenta Contable</label>
						<input type="text" class="form-control" id="cuenta" name="cuenta" required="true">
						<span class="text-danger error-message"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>