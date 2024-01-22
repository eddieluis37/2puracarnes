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
	<section class="header" style="top: 0px;">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td colspan="2" class="text-center">

					<span style="font-size: 39px; font-weight: bold; display: block; margin: 0;">PURACARNES SAS</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">901.531.807-3</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">AUTOPISTA SUR 66 78 LC B 22</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">FRIGORIFICO GUADALUPE</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Bogotá - Tels: 01-9502998</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Resolución DIAN 18764064061708</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Autorizada el: 2024/01/20 :</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Prefijo ERPC Del 1 AL 10000</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Vigencia: 6</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Responsable de IVA</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">Actividad Economica 4620 Tartifa</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 0;">11.04 Maquina</span>
					<img src="{{ asset('assets/img/logo65.png') }}" alt="" class="invoice-logo" width="177%" style="vertical-align: top; padding-top: -70px; position: relative">
				</td>
			</tr>
			<hr width="140mm" color="black" size="3">
			<tr>
				<td colspan=" 2" class="text-center">
					<span style="font-size: 29px; font-weight: bold; display: block; margin-top: 10;">Sistema POS: {{$sale[0]->resolucion}}</span>
				</td>
			</tr>
			<tr>
				<td width="100%" class="text-left text-company" style="vertical-align: top; padding-top: 7px">
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Fecha y hora:<strong> {{\Carbon\Carbon::now()->format('Y-m-d H:i')}}</strong></span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Cajero:<strong> {{$sale[0]->nameuser}}</strong></span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Cliente:<strong> {{$sale[0]->namethird}}</strong></span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Nit / C.C.:<strong> {{$sale[0]->identification}}</strong></span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Dirección:<strong> {{$sale[0]->direccion}}</strong></span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Factura interna:<strong> {{$sale[0]->consecutivo}}</strong></span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Estado_Factura:
						{{-- Display "Cerrada" if status is 1 --}}
						{{-- Display "Pendiente" if status is 0 --}}
						<strong>{{ $sale[0]->status == 1 ? 'Cerrada' : 'Pendiente' }}</strong>
					</span>
					<span style="font-size: 28px; font-weight: lighter; display: block; margin: 2;">Items:<strong>{{$sale->sum('items')}}</strong></span>
				</td>
			</tr>
		</table>
	</section>
	<hr width="140mm" color="black" size="4">
	<section style="margin-top: 15px">
		<table align="center" cellpadding="33" cellspacing="1" class="table-items" width="100%">
			<thead>
				<tr>
					<th width="60%">Descripción</th>
					<th width="10%">Cant.</th>
					<th width="10%">Vr.unit</th>
					<th width="10%">Vr.Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach($saleDetails as $item)
				<tr>
					<td align="center">{{$item->nameprod}}</td>
					<td align="center">{{$item->quantity}}</td>
					<td align="center">${{number_format($item->price),2}}</td>
					<td align="center">${{number_format($item->total),2}}</td>
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
					<td></td>
					<td class="text-center">
						<span><strong>${{ number_format($sale->sum('total_valor_a_pagar'),0)}}</strong></span>
					</td>
				</tr>
			</tfoot>
		</table>

		<hr width="140mm" color="black" size="3">
		<p class="text-center" style="font-size: 21px;">
			<span><strong>Forma de pago</strong></span>
		</p>
		<p class="text-right" style="font-size: 28px;">
			<span><strong>${{ number_format($sale[0]->valor_pagado,0)}}</strong></span>
		</p>
		<p class="text-right" style="font-size: 28px;">
			<span><strong>Cambio: ${{ number_format($sale[0]->cambio,0)}}</strong></span>
		</p>

		<p align="center" style="font-size: 17px; margin-top: -15px;">A esta factura de venta aplican las normas relativas a la letra de cambio (artículo 5 Ley 1231 de 2008). Con esta el Comprador declara haber recibido real y materialmente las mercancías o prestación de servicios descritos en este título - Valor. <strong>Número Autorización 18764064061708 aprobado en 20240120 prefijo ERPC desde el número 1 al 10000, del dia 20 de enero de 2024, Vigencia: 6 Meses</strong></p>
		<p align="center" style="font-size: 17px; margin: -27px;">Responsable de IVA - Actividad Económica 4620 Comercio al por mayor de materias primas agropecuarias; animales vivos Tarifa 11.04</p>
	</section>
	<!-- <section class="footer">
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
	</section> -->
</body>

</html>