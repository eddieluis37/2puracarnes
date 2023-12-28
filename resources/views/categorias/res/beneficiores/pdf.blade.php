<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Compra compensada</title>

  <!-- cargar a través de la url del sistema -->

  <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">

  <!-- ruta física relativa OS -->
  <!-- <link rel="stylesheet" href="{{ public_path('css/custom_pdf.css') }}">
  <link rel="stylesheet" href="{{ public_path('css/custom_page.css') }}">
  -->
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
        
    </table>
  </section>

  <section style="margin-top: -150px">
    <table cellpadding="0" cellspacing="0" width="100%">
      
        <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: -200px">
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
    </table>
  </section>


  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>Sacrificio</th>
          <th>Fomento</th>
          <th>Deguello</th>
          <th>Bascula</th>
          <th>Transporte</th>
        </tr>
      </thead>
      <tr>
        <td align="center">$ {{number_format( $lote[0]->sacrificio ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->fomento ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->deguello ,0, ',', '.' )}}</td>
        <td align="center">{{number_format( $lote[0]->bascula ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->transporte ,0, ',', '.' )}}</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>CantMachos</th>
          <th>ValorMacho</th>
          <th>ValorTotalMacho</th>
          <th>CantHembras</th>
          <th>ValorHembras</th>
          <th>ValorTotalHembra</th>
        </tr>
      </thead>
      <tr>
        <td align="center">{{number_format( $lote[0]->cantidadmacho ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->valorunitariomacho ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->valortotalmacho ,0, ',', '.' )}}</td>
        <td align="center">{{number_format( $lote[0]->cantidadhembra ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->valorunitariohembra ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->valortotalhembra ,0, ',', '.' )}} KG</td>
      </tr>
    </table>
  </section>



  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>PesoPie1</th>
          <th>PesoPie2</th>
          <th>PesoPie3</th>
        </tr>
      </thead>
      <tr>
        <td align="center"> {{number_format( $lote[0]->pesopie1 ,2, ',', '.' )}} KG</td>
        <td align="center"> {{number_format( $lote[0]->pesopie2 ,2, ',', '.' )}} KG</td>
        <td align="center"> {{number_format( $lote[0]->pesopie3 ,2, ',', '.' )}} KG</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>CostoPie1</th>
          <th>CostoPie2</th>
          <th>CostoPie3</th>
          <th>CostoAninal1</th>
          <th>CostoAninal2</th>
          <th>CostoAninal3</th>
        </tr>
      </thead>
      <tr>
        <td align="center">$ {{number_format( $lote[0]->costopie1 ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->costopie2 ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->costopie3 ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->costoanimal1 ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->costoanimal2 ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->costoanimal3 ,0, ',', '.' )}}</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>CanalCaliente</th>
          <th>CanalFria</th>
          <th>CanalPlanta</th>
          <th>PielesKg</th>
          <th>PielesCosto</th>
          <th>Visceras</th>
        </tr>
      </thead>
      <tr>
        <td align="center">$ {{number_format( $lote[0]->canalcaliente ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->canalfria ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->canalplanta ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->pieleskg ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->pielescosto ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->visceras ,0, ',', '.' )}}</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>TSacrificio</th>
          <th>TFomento</th>
          <th>TDeguello</th>
          <th>TBascula</th>
          <th>TTransporte</th>
          <th></th>
        </tr>
      </thead>
      <tr>
        <td align="center">$ {{number_format( $lote[0]->tsacrificio ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->tfomento ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->tdeguello ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->tbascula ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->ttransporte ,0, ',', '.' )}}</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>TotalPieles</th>
          <th>TotalVisceras</th>
          <th>TotalCanalFria</th>
          <th>valorFactura</th>
          <th>CostoKilo</th>
          <th></th>
        </tr>
      </thead>
      <tr>
        <td align="center">$ {{number_format( $lote[0]->tpieles ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->tvisceras ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->tcanalfria ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->valorfactura ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->costokilo ,0, ',', '.' )}}</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 20px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>Costo</th>
          <th>TotalCosto</th>
          <th>PesoPie</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tr>
        <td align="center">$ {{number_format( $lote[0]->costo ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->totalcostos ,0, ',', '.' )}}</td>
        <td align="center">$ {{number_format( $lote[0]->pesopie ,0, ',', '.' )}}</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 50px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th>Peso Pie</th>
          <th>RtCanalCaliente</th>
          <th>RtCanalPlanta</th>
          <th>RtCanalFria</th>
          <th>RendCaliente</th>
          <th>RendPlanta</th>
          <th>RendFrio</th>
        </tr>
      </thead>
      <tr>
        <td align="center">{{number_format( $lote[0]->pesopie ,0, ',', '.' )}} KG</td>
        <td align="center">{{number_format( $lote[0]->rtcanalplanta ,0, ',', '.' )}} KG</td>
        <td align="center">{{number_format( $lote[0]->rtcanalcaliente ,0, ',', '.' )}} KG</td>
        <td align="center">{{number_format( $lote[0]->rtcanalfria ,0, ',', '.' )}} KG</td>
        <td align="center">{{number_format( $lote[0]->rendcaliente ,2, ',', '.' )}} KG</td>
        <td align="center">{{number_format( $lote[0]->rendplanta ,2, ',', '.' )}} KG</td>
        <td align="center">{{number_format( $lote[0]->rendfrio ,2, ',', '.' )}} KG</td>
      </tr>
    </table>
  </section>

  <section style="margin-top: 180px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th width="5%">Código</th>
          <th width="12%">Descripción</th>
          <th width="3%">%_Desp</th>
          <th width="5%">PrecioV</th>
          <th width="3%">Peso</th>
          <th width="6%">TVenta</th>
          <th width="5%">%Venta</th>
          <th width="7%">CostoT</th>
          <th width="7%">CostoKg</th>

        </tr>
      </thead>
      <tbody>
        @foreach($desposte as $item)
        <tr>
          <td align="left">{{$item->code}}</td>
          <td align="center">{{$item->nameprod}}</td>
          <td align="right">{{$item->porcdesposte}} %</td>
          <td align="right">$ {{number_format($item->precio),2}}</td>
          <td align="right">{{$item->peso}}</td>
          <td align="right">$ {{number_format($item->totalventa),2}}</td>
          <td align="right">{{$item->porcventa}} %</td>
          <td align="right">$ {{number_format($item->costo),2}}</td>
          <td align="right">$ {{number_format($item->costo_kilo),2}}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td class="text-center">
            <span><b>TOTALES</b></span>
          </td>
          <td></td>
          <td colspan="1" class="text-right">
            <span><strong>{{number_format($total_porcdesposte),2}} %</strong></span>
          </td>
          <td class="text-right">
            <span><strong>$ {{number_format($precioventa),2}}</strong></span>
          </td>
          <td class="text-right">
            <span><strong>{{number_format($total_weight),2}}</strong></span>
          </td>
          <td class="text-right">
            <span><strong>$ {{number_format($totalprecioventa),2}}</strong></span>
          </td>
          <td colspan="1" class="text-right">
            <span><strong>{{number_format($total_porcventa),2}} %</strong></span>
          </td>
          <td class="text-right">
            <span><strong>$ {{number_format($total_costo),2}}</strong></span>
          </td>
          <td class="text-right">
            <span><strong>$ {{number_format($total_costo_kilo),2}}</strong></span>
          </td>

        </tr>
      </tfoot>
    </table>


    </br>
    <!--  <div class="table-responsive">
      <table class="table table-bordered">
         <thead>
          <tr>
            <th>Nombre del campo</th>
            <th>Valor</th>
          </tr>
        </thead> 
        <tbody>
          <th>RtCanalCaliente:</th>
          <td>{{number_format($lote[0]->rtcanalcaliente),2}}</td>
          <th>RtCanalPlanta:</th>
          <td>{{number_format($lote[0]->rtcanalplanta),2}}</td>
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
 -->
    <div class="widget-content mt-3">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table id="tableDespostere" class="table table-sm table-striped table-bordered">

              <tbody id="tbody">
                <?php $tpeso = 0;
                $tdesposte = 0; ?>
                @foreach($desposte as $item)

                <?php $tpeso = $tpeso + $item->peso;
                $tdesposte = $tdesposte + $item->totalventa; ?>
                @endforeach
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>

    <?php
    $pi = $lote[0]->canalplanta;
    $cant = $lote[0]->cantidad;
    $ck = $lote[0]->costokilo;
    $tck = $pi * $ck;
    ?>
    <section style="margin-top: 10px">
      <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <thead>
          <tr>
            <th>Peso Inicial</th>
            <th>Peso por animal</th>
            <th>Peso total Desp</th>
            <th>Merma</th>
            <th>% Merma</th>
            <th>% Cant animales</th>
          </tr>
        </thead>
        <tr>
          <td align="center">{{ number_format( $pi, 2, ',', '.' )}}</td>
          <td align="center">{{ number_format( $pi / $cant, 2, ',', '.' )}}</td>
          <td align="center">{{ number_format( $tpeso,2, ',', '.')}}</td>
          <td align="center"><strong>{{ number_format( $tpeso - $pi, 2, ',', '.')}}</strong></td>
          <td align="center"><strong><?php if ($tpeso == 0) { ?>
                <div class="form-control campo">
                  <?php echo number_format($tpeso, 2); ?>
                </div>
              <?php } ?>
              <?php if ($tpeso != 0) { ?>
                <div class="form-control campo">
                  <?php echo number_format((($tpeso  - $pi) / $tpeso) * 100, 2); ?> %
                </div>
              <?php } ?>
            </strong>
          </td>
          <td align="center">{{ number_format($cant, 0, ',', '.')}}</td>
        </tr>
      </table>
    </section>

    <section style="margin-top: 20px">
      <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <thead>
          <tr>
            <th>Costo Kilo</th>
            <th>Valor desposte</th>
            <th>Total costo kilo</th>
            <th>Utilidad</th>
            <th>% Utilidad</th>
            <th>Utilidad por animal</th>
          </tr>
        </thead>
        <tr>
          <td align="center">$ {{ number_format( $ck, 2, ',', '.') }}</td>
          <td align="center">$ {{ number_format( $tdesposte, 0, ',', '.') }}</td>
          <td align="center">$ {{ number_format( $tck, 0, ',', '.') }}</td>
          <td align="center">$ {{ number_format( $tdesposte - $tck ,0, ',', '.') }}</td>
          <td align="center"><?php if ($tdesposte == 0) { ?>
              <div class="form-control campo">
                <?php echo number_format($tdesposte, 2); ?>
              </div>
            <?php } ?>
            <?php if ($tdesposte != 0) { ?>
              <div class="form-control campo">
                <?php echo number_format((($tdesposte - $tck) / $tdesposte) * 100, 2); ?> %
              </div>
            <?php } ?>
          </td>
          <td align="center"><?php if ($tdesposte == 0) { ?>
              <div class="form-control campo">
                <?php echo number_format($tdesposte, 2, ',', '.'); ?>
              </div>
            <?php } ?>
            <?php if ($tdesposte != 0) { ?>
              <div class="form-control campo">
                $ <?php echo number_format(($tdesposte - $tck) / $cant, 0, ',', '.'); ?>
              </div>
            <?php } ?>
          </td>
        </tr>
      </table>
    </section>

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