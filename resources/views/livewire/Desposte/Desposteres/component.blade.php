<style>
	.info-box {
		box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
		border-radius: .25rem;
		background-color: #b5dbb3;
	}

	/****************/
	.accordion {
		border: 1px solid #ddd;
		border-radius: 4px;
		overflow: hidden;
	}

	.accordion-item {
		border-bottom: 1px solid #ddd;
	}

	.accordion-header {
		background-color: #f7f7f7;
		padding: 10px;
		cursor: pointer;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.accordion-header h3 {
		margin: 0;
	}

	.accordion-content {
		padding: 10px;
		/*display: none;*/
	}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">

	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="">
				<div class="row">
					<div class="col-sm-3">
						<h4 class="">
							<b> Desposte / RES</b>
						</h4>
					</div>
					<div class="col-sm-3">
						<div class="info-box">
							<div class="row">
								<div class="col-md-6">
									<div class="ml-3">
										<h3>{{number_format($pesoTotalGlobal,2)}}</h3>
										<p>Peso total</p>
									</div>
								</div>
								<div class="col-md-6 text-center">
									<i class="fas fa-check mt-2 text-success" style="font-size: 50px;"></i>

								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="info-box">
							<div class="row">
								<div class="col-md-6">
									<div class="ml-3">
										<h3>{{$TotalDesposte}}</h3>
										<p>% Desposte</p>
									</div>
								</div>
								<div class="col-md-6 text-center">
									<i class="fas fa-check mt-2 text-success " style="font-size: 50px;"></i>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>ID Beneficio</label>
										<input type="number" name="id" id="id" class="form-control" readonly value="{{$beneficior[0]->id}}">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Proveedor</label>
										<input type="text" name="proveedor" id="proveedor" class="form-control" readonly value="{{$proveedor[0]->name}}">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Lote</label>
										<input type="text" name="lote" id="lote" class="form-control" readonly value="{{$beneficior[0]->lote}}">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="task-header">
									<div class="form-group">
										<label>Factura</label>
										<input type="text" name="factura" id="factura" class="form-control" readonly value="{{$beneficior[0]->factura}}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!---->
				<div class="accordion mt-3">
					<div class="accordion-item">
						<div class="accordion-header">
							<h5>Formulario</h5>
							<span class="accordion-icon"></span>
						</div>
						<div class="accordion-content">
							<div class="">
								<div class="">
									<div class="">
										<form id="form-desposteres">
											<input type="number" value="{{$beneficio_id}}" name="beneficioId" hidden>
											<input type="number" id="despostereId" name="despostereId" hidden>
											<div class="row mb-3">
												<label for="producto" class="col-sm-2 col-form-label text-right">Producto</label>
												<div class="col-sm-10">
													<select class="form-control select2" name="producto" wire:model="selected" required>
														<option value="">Buscar producto...</option>
														@foreach($prod as $option)
														<option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
														@endforeach
													</select>
												</div>
												<!--label for="inputEmail3" class="col-sm-2 col-form-label text-right">Producto</label>
											<div class="col-sm-10">
											<div class="input-group">
											<input type="text" class="form-control" id="autoSizingInputGroup" wire:model="searchProduct" placeholder="Buscar producto">
											<div class="input-group-text bg-primary">Escoger Dato</div>
											</div>
											</div>-->
											</div>

											<div class="row mb-3">
												<label for="pventa" class="col-sm-2 col-form-label text-right">Precio_venta</label>
												<div class="col-sm-10">
													<input type="number" class="form-control" id="pventa" name="pventa" required>
												</div>
											</div>
											<div class="row mb-3">
												<label for="pkilo" class="col-sm-2 col-form-label text-right">Peso_kilo</label>
												<div class="col-sm-10">
													<input type="number" class="form-control" id="pkilo" name="pkilo" onkeydown="fnInputEnter(event)" placeholder="Enter para calcular el total de venta" required>
												</div>
											</div>
											<div class="row mb-3">
												<label for="totalventa" class="col-sm-2 col-form-label text-right">Total_venta</label>
												<div class="col-sm-10">
													<input type="number" class="form-control" id="totalventa" name="totalventa" required>
												</div>
											</div>
											<!--div class="row mb-3">
											<label for="porcventa" class="col-sm-2 col-form-label text-right">Porcventa</label>
											<div class="col-sm-10">
											<input type="number" class="form-control" id="porcventa" name="porcventa" required>
											</div>
										</div>-->
											<div class="col-12 text-right">
												<button type="button" id="btnAdd" class="btn btn-primary">
													Aceptar
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<div class="accordion-header">
							<h5>Lista de contenido</h5>
							<span class="accordion-icon"></span>
						</div>
						<div class="accordion-content">
							<div class="table-responsive mt-3">
								<table id="tableDespostere" class="table table-striped">
									<thead class="text-white" style="background: #3B3F5C">
										<tr>
											<th class="table-th text-white">Producto</th>
											<th class="table-th text-white">% Desposte</th>
											<th class="table-th text-white">Precio venta</th>
											<th class="table-th text-white text-center">Peso kilo</th>
											<th class="table-th text-white text-center">Total venta</th>
											<th class="table-th text-white text-center">Porcventa</th>
											<th class="table-th text-white text-center">Costo total</th>
											<th class="table-th text-white text-center">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php $tpeso = 0;
										$tdesposte = 0; ?>
										@foreach($desposters as $item)
										<tr>
											<td> {{ $item->products->name }}</td>
											<td> {{ $item->porcdesposte }}</td>
											<td> {{ $item->precio}}</td>
											<td> {{ $item->peso }}</td>
											<td> {{ $item->totalventa}}</td>
											<td> {{ $item->porcventa}}</td>
											<td> {{ $item->costo}}</td>
											<td class="text-center">
												<button type="button" onclick="Edit({{$item->id}})" class="btn btn-dark mtmobile" title="Editar">
													<i class="fas fa-edit"></i>
												</button>

												<button type="button" onclick="Confirm('{{$item->id}}','{{$item->beneficiores_id}}')" class="btn btn-dark" title="Cancelar">
													<i class="fas fa-trash"></i>
												</button>
											</td>
										</tr>
										<?php $tpeso = $tpeso + $item->peso;
										$tdesposte = $tdesposte + $item->total; ?>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<td>Totales</td>
											<td>{{round($TotalDesposte)}}</td>
											<td>--</td>
											<td>{{$pesoTotalGlobal}}</td>
											<td>{{$TotalVenta}}</td>
											<td>{{round($porcVentaTotal)}}</td>
											<td>--</td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!---->


				<?php
				$pi = $beneficior[0]->canalplanta;
				$cant = $beneficior[0]->cantidad;
				$ck = $beneficior[0]->costokilo;
				$tck = $pi * $ck;
				?>
				<div class="row mt-3">
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<h5><b> Merma</b> </h5>
								<div class="row g-3 mt-1">
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Peso inicial</label>
												<div class="form-control campo">{{ number_format( $pi,2 )}} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Peso por Animal</label>
												<div class="form-control campo">{{ number_format( $pi / $cant,2 )}} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Peso total Desp</label>
												<div class="form-control campo">{{ number_format( $tpeso,2)}} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Merma</label>
												<div class="form-control campo">{{ number_format( $tpeso - $pi,2)}} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>% Merma</label>
												<?php if ($tpeso == 0) { ?>
													<div class="form-control campo">
														<?php echo number_format($tpeso, 2); ?>
													</div>
												<?php } ?>
												<?php if ($tpeso != 0) { ?>
													<div class="form-control campo">
														<?php echo number_format((($tpeso  - $pi) / $tpeso) * 100, 2); ?>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Cant animales</label>
												<div class="form-control campo">{{ number_format($cant,0)}} </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<h5><b> Utilidad</b> </h5>
								<div class="row g-3 mt-1">
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Costo kilo</label>
												<div class="form-control campo">{{ number_format( $ck,2) }} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Valor desposte</label>
												<div class="form-control campo">{{ number_format( $tdesposte,2) }} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Total costo kilo</label>
												<div class="form-control campo">{{ number_format( $tck ,2) }} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Utilidad</label>
												<div class="form-control campo">{{ number_format( $tdesposte - $tck ,2) }} </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>% Utilidad</label>
												<?php if ($tdesposte == 0) { ?>
													<div class="form-control campo">
														<?php echo number_format($tdesposte, 2); ?>
													</div>
												<?php } ?>
												<?php if ($tdesposte != 0) { ?>
													<div class="form-control campo">
														<?php echo number_format((($tdesposte - $tck) / $tdesposte) * 100, 2); ?>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="task-header">
											<div class="form-group">
												<label>Utilidad por anima</label>
												<?php if ($tdesposte == 0) { ?>
													<div class="form-control campo">
														<?php echo number_format($tdesposte, 2); ?>
													</div>
												<?php } ?>
												<?php if ($tdesposte != 0) { ?>
													<div class="form-control campo">
														<?php echo number_format(($tdesposte - $tck) / $cant, 2); ?>
													</div>
												<?php } ?>
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

</div>
<script>
	let inputventa = document.querySelector('#pventa');
	let inputTotalVenta = document.querySelector('#totalventa');
	let formdesposteres = document.querySelector('#form-desposteres');
	let btnAddForm = document.querySelector('#btnAdd');
	//let token = $('meta[name="csrf-token"]').attr("content");
	let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');



	document.addEventListener('livewire:load', function() {
		$('#tableDespostere').DataTable({
			//"order": [[ 0, "desc" ]]
		});
		/*$('.select2').select2({
		    placeholder: 'Select an option',
		}).on('change', function (e) {
		    var data = $('.select2').select2("val");
		    @this.set('selected', data);
		});*/
		$('.select2').select2({
			placeholder: 'Busca un producto',
			width: '100%',
		}).on('change', function(e) {
			//var data = $('.select2').select2("val");
			//console.log(data);
			//@this.set('selected', data);
			var selectedValue = $('.select2').val();
			console.log(selectedValue);
			let data = $(".select2 option:selected").attr("data");
			console.log(data);
			let row = JSON.parse(data);
			console.log(row);
			let pventa = row.price;
			inputventa.value = pventa;
		});

	});

	function fnInputEnter(event) {
		if (event.keyCode === 13) {
			console.log("Input submitted: ");
			let pkilo = document.querySelector('#pkilo');
			console.log(pkilo.value);
			let total_venta = inputventa.value * pkilo.value;
			inputTotalVenta.value = total_venta;
		}
	}

	btnAddForm.addEventListener('click', async (e) => {
		e.preventDefault();
		btnAddForm.disabled = true;
		btnAddForm.innerHTML = "";
		btnAddForm.innerHTML += `
	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  	<span class="visually-hidden">Guardando...</span>
	`;
		const formData = new FormData(formdesposteres); // Get the form data
		const response = await fetch("/desposteresAdd", { // Send the form data using fetch()
			headers: {
				'X-CSRF-TOKEN': token
			},
			method: "POST",
			body: formData
		});
		const result = await response.json(); // Parse the response as JSON
		console.log(result);
		btnAddForm.disabled = false;
		btnAddForm.innerHTML = "";
		btnAddForm.innerHTML += `Aceptar`;
		formdesposteres.reset();
		//$('.select2').prop('selectedIndex', 0);
		//$('.select2').select2({});
		if (result.status === 201) {
			swal({
				title: "Exito",
				text: result.message,
				type: "success",
			});
			setTimeout(() => {
				location.reload();
			}, 1000);
		}
		if (result.status === 500) {
			console.log(result.errores)
			swal({
				title: "Error",
				text: "Hay campos del formulario vacios",
				type: "error",
			});

		}

	});

	const Edit = async (id) => {
		try {
			let response = await fetch(`/getdesposter/${id}`);
			let resp = await response.json();
			console.log(resp);
			let dataDespostere = resp.data;
			console.log(dataDespostere);
			document.querySelector('#despostereId').value = dataDespostere.id;
			$('.select2').val(dataDespostere.products_id).trigger('change');
			document.querySelector("#pventa").value = dataDespostere.precio;
			document.querySelector("#pkilo").value = dataDespostere.peso;
			document.querySelector("#totalventa").value = dataDespostere.totalventa;
			document.querySelector("#porcventa").value = dataDespostere.porcventa;

		} catch (error) {
			console.log(error)
		}
	}

	const Confirm = (id, beneficioId) => {
		console.log(beneficioId)
		swal({
			title: 'CONFIRMAR',
			text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Cerrar',
			cancelButtonColor: '#fff',
			confirmButtonColor: '#3B3F5C',
			confirmButtonText: 'Aceptar'
		}).then(function(result) {
			if (result.value) {
				(async () => {
					let response = await fetch(`/downdesposter/${id}/${beneficioId}`);
					let resp = await response.json();
					console.log(resp);
					if (resp.status === 201) {
						swal({
							title: "Exito",
							text: resp.message,
							type: "success",
						});
						setTimeout(() => {
							location.reload();
						}, 1000);
						//swal.close()
					}
				})();
			}

		})
	}
	/*********************/
	// Get all the accordion headers
	const headers = document.querySelectorAll('.accordion-header');

	// Add click event listeners to each header
	headers.forEach(header => {
		header.addEventListener('click', () => {
			// Toggle the accordion content's display property
			const content = header.nextElementSibling;
			content.style.display = content.style.display === 'none' ? 'block' : 'none';

			// Toggle the accordion icon
			const icon = header.querySelector('.accordion-icon');
			icon.classList.toggle('open');
		});
	});
</script>