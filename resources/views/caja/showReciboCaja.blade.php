@extends('layouts.theme.app')
@section('content')
<style>
	.table-totales {
		border: 2px solid red;
	}

	h4,
	h6 {
		border: 0px solid #DCDCDC;
		text-align: center;
	}

	th {
		border: 0px solid #DCDCDC;
		text-align: left;
	}

	.input {
		height: 38px;
	}

	td {
		text-align: right;
		font-weight: bold;
		color: black;
	}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
	<div class="col-sm-4">
		<div class="widget widget-chart-one">

			<body>
				<table>
					<thead>
						<h4 class="">
							<b> REPORTE DIARIO </b>
						</h4>
						</br>
						<h6 class="">
							<p>Fecha: {{date("d-m-Y H:i A")}} </p>
						</h6>
					</thead>
					</br>
					<tr>
						<th># Turno:</th>
						<td>{{ $caja[0]->id }}</td>
					</tr>
					<tr>
						<th>Cajero:</th>
						<td>{{ $caja[0]->namecajero }}</td>
					</tr>
					<tr>
						<th>Fecha Hora de Inicio:</th>
						<td>{{ $caja[0]->fecha_hora_inicio }}</td>
					</tr>
					<tr>
						<th>Fecha Hora de Cierre:</th>
						<td>{{ $caja[0]->fecha_hora_cierre }}</td>
					</tr>
					<tr>
						<th>________________________</th>
						<td>____________________________________</td>
					</tr>
					<tr>
						<th>Base:</th>
						<td>{{ $caja[0]->base }}</td>
					</tr>
					<tr>
						<th>Retiro de Caja:</th>
						<td>{{ $caja[0]->retiro_caja }}</td>
					</tr>
					<tr>
						<th>Valor Real:</th>
						<td>{{ $caja[0]->valor_real }}</td>
					</tr>


					<tr>
						<th>Estado:</th>
						<td>{{ $caja[0]->estado }}</td>
					</tr>
					<tr>
						<th>Status:</th>
						<td>{{ $caja[0]->status }}</td>
					</tr>
					<tr>
						<th>Fecha de Creación:</th>
						<td>{{ $caja[0]->created_at }}</td>
					</tr>
					<tr>
						<th>Fecha de Actualización:</th>
						<td>{{ $caja[0]->updated_at }}</td>
					</tr>
					<tr>
						<th>Nombre del Centro de Costo:</th>
						<td>{{ $caja[0]->namecentrocosto }}</td>
					</tr>

				</table>
			</body>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{asset('rogercode/js/caja/rogercode-create.js')}}" type="module"></script>
<script src="{{asset('rogercode/js/caja/code-formulas.js')}}"></script>
@endsection