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
					<img src="{{ asset('assets/img/logo65.png') }}" alt="" class="invoice-logo" width="20%" style="vertical-align: top; padding-top: -100px; position: relative">
					<span style="font-size: 9px; font-weight: bold; display: block; margin: 0;">PURACARNES SAS</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">Nit 901.531.807-3</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">AUTOPISTA SUR 66 78 LC B 22 FRIGORIFICO GUADALUPE</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">Bogotá - Tel. (601) 9502998</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">contabilidad@puracarnes.com</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 0;">www.puracarnes.com</span>
				</td>

			</tr>
			<tr>
				<td colspan=" 2" class="text-center">
					<span style="font-size: 9px; font-weight: bold; display: block; margin-top: 10;">POS {{$order[0]->namecentrocosto}} CAJA {{$order[0]->nameuser}}</span>
					<span style="font-size: 9px; font-weight: bold; display: block; margin: 0;">N°. ORDEN DE PEDIDO {{$order[0]->resolucion}}</span>
				</td>
			</tr>
			<tr>
				<td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 7px">
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Fecha y hora:<strong> {{\Carbon\Carbon::now()->format('Y-m-d H:i')}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Cajero:<strong> {{$order[0]->nameuser}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Cliente:<strong> {{$order[0]->namethird}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Nit / C.C.:<strong> {{$order[0]->identification}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Dirección:<strong> {{$order[0]->direccion}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Celular:<strong> {{$order[0]->celular}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">
						Fecha de entrega:
						<strong>
							{{ \Carbon\Carbon::parse($order[0]->fecha_entrega)->formatLocalized('%A, %d de %B') }}
						</strong>
					</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">
						Horario de entrega:
						<strong>
							{{ \Carbon\Carbon::parse($order[0]->hora_inicial_entrega)->format('h:i A') }} a
							{{ \Carbon\Carbon::parse($order[0]->hora_final_entrega)->format('h:i A') }}
						</strong>
					</span>				
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Estado_Orden_de_Pedido:
						{{-- Display "Cerrada" if status is 1 --}}
						{{-- Display "Pendiente" if status is 0 --}}
						<strong>{{ $order[0]->status == 1 ? 'Cerrada' : 'Pendiente' }}</strong>
					</span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Items:<strong>{{$order->sum('items')}}</strong></span>
				</td>

			</tr>
		</table>
	</section>

	<section style="margin-top: -1px">
		<table cellpadding="0" cellspacing="0" class="table-items" width="100%">
			<thead>
				<tr>
					<th width="5%">ITEM</th>
					<th width="32%">Descripción</th>
					<th width="5%">Cant.</th>
					<th width="5%">Vr.Total</th>
				</tr>
			</thead>
			<tbody>
				@php $counter = 1 @endphp
				@foreach($orderDetails as $item)
				<tr>
					<td align="center">{{ $counter++ }}</td>
					<td align="center">{{$item->nameprod}}</td>
					<td align="center">{{$item->quantity}}</td>
					<td align="right">$ {{number_format($item->total),2}}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center">
						<span><b>TOTALES</b></span>
					</td>
					<td colspan="1" class="text-center">
						<span><strong>{{ $quantity = $item->where('order_id', '=', $item->order_id)->sum('quantity')}}</strong></span>
					</td>
					<td class="text-right">
						<span><strong>$ {{ number_format($item->where('order_id', '=', $item->order_id)->sum('total'),0)}}</strong></span>
					</td>
				</tr>
			</tfoot>
		</table>
	<!-- 	<p align="center" style="font-size: 7px; margin-top: 20px;">A esta notacredito aplican las normas relativas a la letra de cambio (artículo 5 Ley 1231 de 2008). Con esta el Comprador declara haber recibido real y materialmente las mercancías o prestación de servicios descritos en este título - Valor. <strong>Número Autorización 18764061412040 aprobado en 20231206 prefijo PC desde el número 1001 al 20000 Vigencia: 12 Meses</strong></p>
		<p align="center" style="font-size: 7px; margin: -7px;">Responsable de IVA - Actividad Económica 4620 Comercio al por mayor de materias primas agropecuarias; animales vivos Tarifa 11.04</p> -->
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