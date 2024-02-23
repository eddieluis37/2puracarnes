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
					<span style="font-size: 9px; font-weight: bold; display: block; margin-top: 10;">CENTRO COSTO: {{$order[0]->namecentrocosto}} | Digitador: {{$order[0]->nameuser}}</span>
					<span style="font-size: 9px; font-weight: bold; display: block; margin: 0;">N°. ORDEN DE PEDIDO {{$order[0]->resolucion}} | Alistador: {{$order[0]->nombre_alistador}}</span>
				</td>
			</tr>
			<tr>
				<td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 7px">
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Fecha y hora actual de consulta: <strong>{{ $fecha->isoFormat('dddd, D [de] MMMM [de] YYYY') }} | {{\Carbon\Carbon::now()->format('H:i')}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Vendedor:<strong> {{$order[0]->nombre_vendedor}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Subcentro costo:<strong> {{$order[0]->subcentro}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Cliente:<strong> {{$order[0]->namethird}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Nit / C.C.:<strong> {{$order[0]->identification}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Dirección:<strong> {{$order[0]->direccion}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Celular:<strong> {{$order[0]->celular}}</strong></span>
					<span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">
						Fecha de entrega:
						<strong>												
							{{ \Carbon\Carbon::parse($order[0]->fecha_entrega)->isoFormat('dddd, D [de] MMMM [de] YYYY') }}						
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

	<section style="margin-top: 13px">
		<table cellpadding="0" cellspacing="0" class="table-items" width="100%">
			<thead>
				<tr>
					<th width="auto">ITEM</th>
					<th width="auto">PRODUCTO</th>
					<th width="auto">CT.S</th>
					<th width="5%">CT.D</th>
					<th width="5%">VR.U</th>
					<th width="5%">TOTAL.B</th>
					<th width="5%">T.COSTO</th>
					<th width="5%">UT</th>
					<th width="5%">%UT</th>
					<th width="5%">%IVA</th>
					<th width="5%">IVA</th>
					<th width="5%">%I.S</th>
					<th width="5%">I.S</th>
					<th width="5%">TOTAL</th>
					<th width="5%">ESPECIFICACIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $counter = 1 @endphp
				@foreach($orderDetails as $item)
				<tr>
					<td align="center">{{ $counter++ }}</td>
					<td style="text-align: left;">
						<span style="font-size: smaller; text-transform: uppercase;">{{$item->nameprod}}</span>
					</td>

					<td align="center">{{$item->quantity}}</td>
					<td></td>
					<td align="right">{{number_format($item->price),2}}</td>
					<td align="right">{{number_format($item->total_bruto),2}}</td>
					<td align="right">{{number_format($item->total_costo),2}}</td>
					<td align="right">{{number_format($item->utilidad),2}}</td>
					<td align="center">{{$item->porc_utilidad}}</td>
					<td align="center">{{$item->porc_iva}}</td>
					<td align="right">{{number_format($item->iva),2}}</td>
					<td align="center">{{$item->porc_otro_impuesto}}</td>
					<td align="right">{{number_format($item->otro_impuesto),2}}</td>
					<td align="right">{{number_format($item->total),2}}</td>
					<td style="text-align: left;">
						<span style="font-size: smaller; text-transform: uppercase;">{{$item->observaciones}}</span>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center">
						<span><b>SUM</b></span>
					</td>
					<td></td>
					<td colspan="1" class="text-center">
						<span><strong>{{ $quantity = $item->where('order_id', '=', $item->order_id)->sum('quantity')}}</strong></span>
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">
						<span><strong>{{ number_format($item->where('order_id', '=', $item->order_id)->sum('total'),0)}}</strong></span>
					</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="15" style="text-align: left;">
						<span style="font-size: larger; font-weight: bold;">Observaciones: {{$order[0]->observacion}}</span>
					</td>
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