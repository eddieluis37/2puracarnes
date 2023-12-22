<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Reporte de Ventas</title>

	<!-- cargar a través de la url del sistema -->
	<!--
		<link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
	-->
	<!-- ruta física relativa OS -->
	<link rel="stylesheet" href="{{ public_path('css/custom_pdf.css') }}">
	<link rel="stylesheet" href="{{ public_path('css/custom_page.css') }}">

</head>

<body>

	<section class="header" style="top: -293px;">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td colspan="2" class="text-center">
					<span style="font-size: 9px; font-weight: bold; display: block; margin: 0;">PURACARNES SAS</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">Nit 901.531.807-3</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">AUTOPISTA SUR 66 78 LC B 22 FRIGORIFICO GUADALUPE</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">Bogotá - Tel. (601) 9502998</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">contabilidad@puracarnes.com</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">www.puracarnes.com</span>
				</td>
				<th width="10%" style="vertical-align: top; padding-top: -100px; position: relative">
					<img src="{{ asset('assets/img/logo65.png') }}" alt="" class="invoice-logo">
				</th>
			</tr>
			<tr>
				<td colspan=" 2" class="text-center">
					<span style="font-size: 9px; font-weight: bold; display: block; margin-top: 10;">POS GUADALUPE CAJA PRINCIPAL</span>
					<span style="font-size: 9px; font-weight: bold; display: block; margin: 0;">N°.PC {{$sale->id}}</span>
				</td>
			</tr>
			<tr>
				<td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px">
					<span style="font-size: 8px"><strong>Fecha: {{ \Carbon\Carbon::now()->format('d-M-Y')}}</strong></span>
					<br>
					<span style="font-size: 8px">Usuario: </span>
				</td>
			</tr>
		</table>
	</section>
	{{$sale->id}}

	<section style="margin-top: -110px">
		<table cellpadding="0" cellspacing="0" class="table-items" width="100%">
			<thead>
				<tr>
					<th width="32%">Descripción</th>
					<th width="10%">Cant.</th>
					<th width="12%">Vr.Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach($saleDetails as $item)
				<tr>
					<td align="center">{{$item->nameprod}}</td>
					<td align="center">{{$item->quantity}}</td>
					<td align="center">$ {{number_format($item->total),2}}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center">
						<span><b>TOTALES</b></span>
					</td>
					<td colspan="1" class="text-center">
						<span><strong>{{ $quantity = $item->where('sale_id', '=', $item->sale_id)->sum('quantity')}}</strong></span>
					</td>
					<td class="text-center">
						{{$sale->sum('items')}}
					</td>
					<td colspan="3"><span><strong>${{ number_format($sale->sum('total_valor_a_pagar'),2)}}</strong></span></td>
				</tr>
			</tfoot>
		</table>
	</section>


	<section class="footer">

		<table cellpadding="0" cellspacing="0" class="table-items" width="100%">
			<tr>
				<td width="20%">
					<span>Sistema PuraCarnes v1</span>
				</td>
				<td width="60%" class="text-center">
					Admin@puracarnes.com
				</td>
				<td class="text-center" width="20%">
					página <span class="pagenum"></span>
				</td>

			</tr>
		</table>
	</section>

</body>

</html>