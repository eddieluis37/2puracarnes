
<div class="row" class="table-responsive">
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
    </>
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
        </tbody>
      </table>
    </div>
  </div>