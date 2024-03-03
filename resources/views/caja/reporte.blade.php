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
				<td colspan=" 2" class="">
					<span style="font-size: 13px; font-weight: bold; display: block; margin-top: 10;">Sistema POS: {{$sale[0]->resolucion}}</span>
				</td>
			</tr>
			<tr>
				<td width="100%" class="text-left text-company" style="vertical-align: top; padding-top: 7px">
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Fecha y hora:<strong> {{\Carbon\Carbon::now()->format('Y-m-d H:i')}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Cajero:<strong> {{$sale[0]->nameuser}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Cliente:<strong> {{$sale[0]->namethird}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Nit / C.C.:<strong> {{$sale[0]->identification}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Dirección:<strong> {{$sale[0]->direccion}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Factura interna:<strong> {{$sale[0]->consecutivo}}</strong></span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Estado_Factura:
						{{-- Display "Cerrada" if status is 1 --}}
						{{-- Display "Pendiente" if status is 0 --}}
						<strong>{{ $sale[0]->status == 1 ? 'Cerrada' : 'Pendiente' }}</strong>
					</span>
					<span style="font-size: 11px; font-weight: bold; display: block; margin: 2;">Items:<strong>{{$sale->sum('items')}}</strong></span>
				</td>
			</tr>
		</table>
	</section>
	<hr>
	
		<table>
			<thead>
				<tr>
					<th width="83%">Descripción</th>
					<th width="7%">Cant.</th>
					<th width="10%">Vr.unit</th>
					<th width="10%">Vr.Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach($saleDetails as $item)
				<tr>
					<td align="left"><strong>{{$item->nameprod}}</strong></td>
					<td align="center"><strong>{{$item->quantity}}</strong></td>
					<td align="center"><strong>{{number_format($item->price),2}}</strong></td>
					<td align="right"><strong>{{number_format($item->total),2}}</strong></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
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
		</table>
		<hr>***************************
		<p class="text-center" style="font-size: 12px;">
			<span><strong>Forma de pago</strong></span>
		</p>
		<p class="text-right" style="font-size: 12px;">
		<strong><span>EFECTIVO: </span><span>{{ number_format($sale[0]->valor_a_pagar_efectivo,0)}}</strong></span>
		</p>
		<p class="text-right" style="font-size: 12px;">
		<strong><span>{{$sale[0]->formapago1}}: </span><span>{{ number_format($sale[0]->valor_a_pagar_tarjeta,0)}}</></span>
		</p>
		<p class="text-right" style="font-size: 12px;">
		<strong><span>{{$sale[0]->formapago2}}: </span><span>{{ number_format($sale[0]->valor_a_pagar_otros,0)}}</strong></span>
		</p>
		<p class="text-right" style="font-size: 12px;">
		<strong><span>{{$sale[0]->formapago3}}: </span><span>{{ number_format($sale[0]->valor_a_pagar_credito,0)}}</strong></span>
		</p>
		<p class="text-right" style="font-size: 12px;">
			<span><strong>Cambio: {{ number_format($sale[0]->cambio,0)}}</strong></span>
		</p>
		<hr width="60mm" color="black" size="3">
	
</body>

</html>