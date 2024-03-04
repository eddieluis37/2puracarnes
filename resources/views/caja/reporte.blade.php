<!DOCTYPE html>
<html lang="es">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="application/pdf">

	<title>Cierre de caja</title>

	<!-- cargar a través de la url del sistema -->
	<!--
		<link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
	-->
	<!-- ruta física relativa OS -->
	<link rel="stylesheet" href="{{ public_path('css/pos_custom_pdf.css') }}">
	<link rel="stylesheet" href="{{ public_path('css/pos_custom_page.css') }}">

</head>

<body>
	<section class="" style="top: 0px;">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="text-center">
					<span style="font-size: 17px; font-weight: bold; display: block; margin: 0;">CIERRE DE CAJA</span>

					<img src="{{ asset('assets/img/logo65.png') }}" alt="" class="invoice-logo" width="33%" style="padding-top: -70px; position: relative">
				</td>
			</tr>
			<tr>

			</tr>
			<tr>
				<td>
					<span style="font-size: 13px; font-weight: bold; display: block; margin-top: 10;">Turno: {{$sale[0]->id}}</span>
				</td>
			</tr>
			<tr>
				<td width="100%" class="text-left text-company" style="vertical-align: top; padding-top: 7px">
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Fecha y hora:<strong> {{\Carbon\Carbon::now()->format('Y-m-d H:i')}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Centro costo:<strong> {{$sale[0]->namecentrocosto}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Usuario:<strong> {{$sale[0]->nameuser}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Cajero:<strong> {{$sale[0]->namecajero}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Hora de Inicio: <strong>{{ \Carbon\Carbon::parse($sale[0]->fecha_hora_inicio)->format('Y-m-d H:i') }}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Hora de cierre: <strong>{{ \Carbon\Carbon::parse($sale[0]->fecha_hora_cierre)->format('Y-m-d H:i') }}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;"> Actualización: <strong>{{ \Carbon\Carbon::parse($sale[0]->updated_at)->format('Y-m-d H:i') }}</strong></span>					
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Estado turno:
						{{-- Display "Cerrada" if status is 1 --}}
						{{-- Display "Pendiente" if status is 0 --}}
						<strong>{{ $sale[0]->status == 1 ? 'Cerrado' : 'Pendiente' }}</strong>
					</span>

				</td>
			</tr>
		</table>
	</section>
	<hr>

	<!-- <table>
		<thead>
			<tr>
				<th width="83%">Descripción</th>
				<th width="7%">Cant.</th>
				<th width="10%">Vr.unit</th>
				<th width="10%">Vr.Total</th>
			</tr>
		</thead>
		<!-- <tbody>
			@foreach($saleDetails as $item)
			<tr>
				<td align="left"><strong>{{$item->nameprod}}</strong></td>
				<td align="center"><strong>{{$item->quantity}}</strong></td>
				<td align="center"><strong>{{number_format($item->price),2}}</strong></td>
				<td align="right"><strong>{{number_format($item->total),2}}</strong></td>
			</tr>
			@endforeach
		</tbody> -->
	<!-- <tfoot>
			<tr>
				<td class="">
					<span><b>TOTALES</b></span>
				</td>
				<td align="right">
					<span><strong>{{ $quantity = $item->where('sale_id', '=', $item->sale_id)->sum('quantity')}}</strong></span>
				</td>
				<td></td>
				<td align="right">
					<span><strong>{{ number_format($sale->sum('total_valor_a_pagar'),0)}}</strong></span>
				</td>
			</tr>
		</tfoot> 
	</table> -->

	<p class="text-center" style="font-size: 12px;">
		<span><strong></strong></span>
	</p>

	<table>
		<!-- <thead>
			<h4 class="">
				<b> </b>
			</h4>
			</br>
			<h6 class="">
				<p> </p>
			</h6>
		</thead> -->

	<!-- 	<tr>
			<th style="text-align: left;"># Turno:</th>
			<td>{{ $sale[0]->id }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Cajero:</th>
			<td>{{ $sale[0]->namecajero }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Centro de Costo:</th>
			<td>{{ $sale[0]->namecentrocosto }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Fecha Hora de Inicio:</th>
			<td>{{ $sale[0]->fecha_hora_inicio }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Fecha Hora de Cierre:</th>
			<td>{{ $sale[0]->fecha_hora_cierre }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Fecha de Actualización:</th>
			<td>{{ $sale[0]->updated_at }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Estado:</th>
			<td>{{ $sale[0]->estado }}</td>
		</tr>

		<tr> -->
			<th style="text-align: left;">Base:</th>
			<td style="text-align: right; font-weight: bold;">$ {{number_format($sale[0]->base, 0, ',', '.')}}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Efectivo:</th>
			<td style="text-align: right; font-weight: bold;">$ {{number_format($sale[0]->efectivo, 0, ',', '.')}}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Retiro de Caja:</th>
			<td style="text-align: right; font-weight: bold;">$ {{ $sale[0]->retiro_caja }}</td>
		</tr>
		<tr>
			<th style="text-align: left;">TOTAL:</th>
			<td style="text-align: right; font-weight: bold;">$ {{number_format($sale[0]->total, 0, ',', '.')}}</td>
		</tr>
		<tr>
			<th style="text-align: left;">Valor real:</th>
			<td style="text-align: right; font-weight: bold;">$ {{number_format($sale[0]->valor_real, 0, ',', '.')}}</td>
		</tr>
		<tr>
			<th></th>
			<td style="text-align: right;">______________</td>
		</tr>
		<tr>
			<th style="text-align: left;">Diferencia:</th>
			<td style="text-align: right; font-weight: bold;">$ {{number_format($sale[0]->diferencia, 0, ',', '.')}}</td>
		</tr>

	</table>

	<hr width="60mm" color="black" size="3">


</body>

</html>