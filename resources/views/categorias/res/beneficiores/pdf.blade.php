<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Compra compensada</title>

  <!-- cargar a través de la url del sistema -->
  <!--
		<link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
	-->
  <!-- ruta física relativa OS -->
  <link rel="stylesheet" href="{{ public_path('css/custom_pdf.css') }}">
  <link rel="stylesheet" href="{{ public_path('css/custom_page.css') }}">
  <!-- Enlace al archivo CSS de Bootstrap 5 -->
  <!--   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
 -->

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
          <span style="font-size: 9px; font-weight: bold; display: block; margin-top: 10;">COMPRA LOTE {{$lote[0]->namecentrocosto}}</span>
          <span style="font-size: 9px; font-weight: bold; display: block; margin: 0;">COD Lote {{$lote[0]->lote}}-{{$lote[0]->id}}</span>
        </td>
      </tr>
      <tr>
        <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 7px">
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Factura:<strong> {{$lote[0]->factura}}</strong></span>
      
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Fecha y hora consulta:<strong> {{\Carbon\Carbon::now()->format('Y-m-d H:i')}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Fecha creación beneficio:<strong> {{$lote[0]->fecha_beneficio}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Proveedor:<strong> {{$lote[0]->namethird}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Finca:<strong> {{$lote[0]->finca}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Planta_Sacrificio:<strong> {{$lote[0]->nameplanta}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Cliente_Pieles:<strong> {{$nameclientpieles}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Cliente_Visceras:<strong> {{$nameclientvisceras}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Nit / C.C.:<strong> {{$lote[0]->identification}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Dirección:<strong> {{$lote[0]->direccion}}</strong></span>
          <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Estado_lote:
            {{-- Display "Cerrada" if status is 1 --}}
            {{-- Display "Pendiente" if status is 0 --}}
            <strong>{{ $lote[0]->status == 1 ? 'Cerrada' : 'Pendiente' }}</strong>
          </span>
          <!--     <span style="font-size: 8px; font-weight: lighter; display: block; margin: 2;">Items:<strong>{{$lote->sum('id')}}</strong></span> -->
        </td>
  </section>

  <style>
    .align-items-start {
      height: 100px;
      background-color: green;
    }

    .align-items-center {
      height: 100px;
      background-color: blue;
    }

    .align-items-end {
      height: 100px;
      background-color: red;
    }

    .col {
      background-color: #e4e4e4;
      border: 1px solid grey;
    }
  </style>

  <div class="row">
    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>CantMachos:</th>
          <td>{{$lote[0]->cantidadmacho}}</td>         
          <th>ValorMacho:</th>          
          <td>$ {{number_format($lote[0]->valorunitariomacho),2}}</td>
          <th>ValorTotalMacho:</th>          
          <td>$ {{number_format($lote[0]->valortotalmacho),2}}</td>
          <th>CantHembras:</th>
          <td>{{$lote[0]->cantidadhembra}}</td>
          <th>ValorHembras:</th>          
          <td>$ {{number_format($lote[0]->valorunitariohembra),2}}</td>
          <th>ValorTotalHembra:</th>
          <td>$ {{number_format($lote[0]->valortotalhembra),2}}</td>        
        </tbody>
      </table>
    </div> 
    
    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>Sacrificio:</th>          
          <td>$ {{number_format($lote[0]->sacrificio),2}}</td>
          <th>Fomento:</th>
          <td>$ {{number_format($lote[0]->fomento),2}}</td>
          <th>Deguello:</th>          
          <td>$ {{number_format($lote[0]->deguello),2}}</td>
          <th>Bascula:</th>          
          <td>$ {{number_format($lote[0]->bascula),2}}</td>
          <th>Transporte:</th>          
          <td>$ {{number_format($lote[0]->transporte),2}}</td>         
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>PesoPie1:</th>          
          <td>{{number_format($lote[0]->pesopie1),2}}</td>
          <th>PesoPie2:</th>          
          <td>{{number_format($lote[0]->pesopie2),2}}</td>
          <th>PesoPie3:</th>
          <td>{{number_format($lote[0]->pesopie3),2}}</td>                
        </tbody>
      </table>
    </div>

    
    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>CostoPie1:</th>          
          <td>$ {{number_format($lote[0]->costopie1),2}}</td>      
          <th>CostoPie2:</th>
          <td>$ {{number_format($lote[0]->costopie2),2}}</td>  
          <th>CostoPie3:</th>
          <td>$ {{number_format($lote[0]->costopie3),2}}</td>  
          <th>CostoAninal1:</th>          
          <td>$ {{number_format($lote[0]->costoanimal1),2}}</td>  
          <th>CostoAninal2:</th>
          <td>$ {{number_format($lote[0]->costoanimal2),2}}</td>          
          <th>CostoAninal3:</th>     
          <td>$ {{number_format($lote[0]->costoanimal3),2}}</td>             
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>CanalCaliente:</th>          
          <td>{{number_format($lote[0]->canalcaliente),2}}</td>    
          <th>CanalFria:</th>          
          <td>{{number_format($lote[0]->canalfria),2}}</td>    
          <th>CanalPlanta:</th>          
          <td>{{number_format($lote[0]->canalplanta),2}}</td>
          <th>PielesKg:</th>          
          <td>{{number_format($lote[0]->pieleskg),2}}</td>
          <th>PielesCosto:</th>          
          <td>{{number_format($lote[0]->pielescosto),2}}</td>
          <th>Visceras:</th>               
          <td>{{number_format($lote[0]->visceras),2}}</td>         
        </tbody>
      </table>
    </div>

    
    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>TSacrificio:</th>          
          <td>$ {{number_format($lote[0]->tsacrificio),2}}</td>  
          <th>TFomento:</th>          
          <td>$ {{number_format($lote[0]->tfomento),2}}</td>  
          <th>TDeguello:</th>          
          <td>$ {{number_format($lote[0]->tdeguello),2}}</td>  
          <th>TBascula:</th>          
          <td>$ {{number_format($lote[0]->tbascula),2}}</td>  
          <th>TTransporte:</th>                      
          <td>$ {{number_format($lote[0]->ttransporte),2}}</td>  
        </tbody>
      </table>
    </div>

      
    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>TotalPieles:</th>          
          <td>$ {{number_format($lote[0]->tpieles),2}}</td> 
          <th>TotalVisceras:</th>          
          <td>$ {{number_format($lote[0]->tvisceras),2}}</td> 
          <th>TotalCanalFria:</th>          
          <td>$ {{number_format($lote[0]->tcanalfria),2}}</td> 
          <th>valorFactura:</th>          
          <td>$ {{number_format($lote[0]->valorfactura),2}}</td> 
          <th>CostoKilo:</th>                   
          <td>$ {{number_format($lote[0]->costokilo),2}}</td>    
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>Costo:</th>
          <td>$ {{number_format($lote[0]->costo),2}}</td>
          <th>TotalCosto:</th>          
          <td>$ {{number_format($lote[0]->totalcostos),2}}</td>
          <th>PesoPie:</th>          
          <td>{{number_format($lote[0]->pesopie),2}}</td>   
          <th>RtCanalCaliente:</th>          
          <td>{{number_format($lote[0]->rtcanalcaliente),2}}</td>  
          <th>RtCanalPlanta:</th>                        
          <td>{{number_format($lote[0]->rtcanalplanta),2}}</td>  
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <!-- <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> -->
        <tbody>
          <th>RtCanalFria:</th>          
          <td>{{number_format($lote[0]->rtcanalfria),2}}</td>  
          <th>RendCaliente:</th>          
          <td>{{number_format($lote[0]->rendcaliente),2}}</td>  
          <th>RendPlanta:</th>          
          <td>{{number_format($lote[0]->rendplanta),2}}</td>  
          <th>RendFrio:</th>          
          <td>{{number_format($lote[0]->rendfrio),2}}</td>  
             
        </tbody>
      </table>
    </div>




  </div>

  <section style="margin-top: 10px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th width="5%">Código</th>
          <th width="12%">Descripción</th>
          <th width="3%">%_Desp</th>
          <th width="5%">Precio</th>
          <th width="3%">Peso</th>
          <th width="5%">TVenta</th>
          <th width="3%">%Venta</th>
          <th width="7%">CostoT</th>
          <th width="7%">CostoKg</th>

        </tr>
      </thead>
      <tbody>
        @foreach($desposte as $item)
        <tr>
          <td align="left">{{$item->code}}</td>
          <td align="center">{{$item->nameprod}}</td>
          <td align="right">{{number_format($item->porcdesposte),2}} %</td>          
          <td align="right">$ {{number_format($item->precio),2}}</td>
          <td align="right">{{$item->peso}}</td>
          <td align="right">$ {{number_format($item->totalventa),2}}</td>
          <td align="right">{{number_format($item->porcventa),2}} %</td>   
          <td align="right">$ {{number_format($item->costo),2}}</td>
          <td align="right">$ {{number_format($item->costo_kilo),2}}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td class="text-center">
            <span><b></b></span>
          </td>
          <td></td>
          <td colspan="1" class="text-right">
            <span><strong></strong></span>
          </td>
          <td class="text-center">
            <span><strong></strong></span>
          </td>
          <td class="text-right">
            <span><strong></strong></span>
          </td>

        </tr>
      </tfoot>
    </table>
    <p align="center" style="font-size: 7px; margin-top: 20px;">Esta documento contiene información confidencial y hace parte del modulo beneficios lotes. servicios descritos en este título. <strong>Sistema para todos ERP puracanes SAS</strong></p>
    <p align="center" style="font-size: 7px; margin: -7px;">Versión 1.0</p>
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