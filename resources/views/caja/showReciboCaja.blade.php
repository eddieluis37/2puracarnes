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
	<div class="col-sm-6">
		<div class="widget widget-chart-one">

			<body>
				<table>
					<thead>
						<h4 class="">
							<b> REPORTE DIARIO </b>
						</h4>
						</br>
						<h6 class="">
							<p>Fecha: {{date("Y-m-d H:i A")}} </p>
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
						<th>Centro de Costo:</th>
						<td>{{ $caja[0]->namecentrocosto }}</td>
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
						<th>Fecha de Actualización:</th>
						<td>{{ $caja[0]->updated_at }}</td>
					</tr>
					
					<tr>
						<th>Estado:</th>
						<td>{{ $caja[0]->estado }}</td>
					</tr>
					<tr>
						<th>___________________________</th>
						<td>___________________________</td>
					</tr>
					<tr>
						<th>Base:</th>
						<td colspan="2">$ {{number_format($caja[0]->base, 0, ',', '.')}}</td>
					</tr>
					<tr>
						<th>Efectivo:</th>
						<td colspan="2">$ {{number_format($caja[0]->efectivo, 0, ',', '.')}}</td>
					</tr>
					<tr>
						<th>Retiro de Caja:</th>
						<td>{{ $caja[0]->retiro_caja }}</td>
					</tr>
					<tr>
						<th>TOTAL:</th>
						<td colspan="2">$ {{number_format($caja[0]->total, 0, ',', '.')}}</td>
					</tr>
					<tr>
						<th>Valor real ingresado:</th>
						<td colspan="2">$ {{number_format($caja[0]->valor_real, 0, ',', '.')}}</td>
					</tr>
					<tr>
						<th>Diferencia:</th>
						<td colspan="2">$ {{number_format($caja[0]->diferencia, 0, ',', '.')}}</td>
					</tr>	
					<tr>
						<th>___________________________</th>
						<td>___________________________</td>
					</tr>
				</table>
			</body>
		</div>
	</div>
</div>
<div class="text-center">
	<button onclick="printReport()" class="btn btn-success">Imprimir</button>
	<!-- <button onclick="exportToPDF()" class="btn btn-success">Exportar a PDF</button> -->
	<button type="button" class="btn btn-primary" onclick="history.back()">Volver</button>
</div>
@endsection
@section('script')

<script src="{{asset('rogercode/js/caja/imprimir-y-exportar-pdf.js')}}"></script>
@endsection