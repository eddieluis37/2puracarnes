@extends('layouts.theme.app')
@section('content')
<style>
  .table-totales {
    /*border: 2px solid red;*/
  }

  .table-totales,
  th,
  td {
    border: 1px solid #DCDCDC;
  }

  .table-inventario,
  th,
  td {
    border: 1px solid #DCDCDC;
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
  <div class="col-sm-12">
    <div class="widget widget-chart-one">
      <div class="card text-center" style="background: #3B3F5C">
        <div class="m-2">
          <h4 style="color:white;"><strong>Reporte de compras por productos</strong></h3>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-sm-6 col-md-3">
          <h6>Fecha y hora inicial</h6>
          <div class="form-group">
            <input type="datetime-local" class="form-control" value="{{ $dateFrom ?? date('Y-m-d') }}T00:00" name="dateFrom" id="dateFrom" required data-bs-toggle="tooltip" title="Selecciona la fecha y hora inicial desde el calendario">
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <h6>Fecha y hora final</h6>
          <div class="form-group">
            <input type="datetime-local" class="form-control" value="{{ $dateTo ?? date('Y-m-d') }}T23:59" name="dateTo" id="dateTo" required data-bs-toggle="tooltip" title="Selecciona la fecha y hora final desde el calendario">
          </div>
        </div>

        <div class="col-sm-6 col-md-2 mt-3">
          <button class="btn btn-dark btn-block" onclick="exportarExcel()">
            <i class="far fa-file-excel"></i> Exportar a Excel
          </button>
        </div>

        <div class="col-sm-6 col-md-2 mt-3">
          <button onclick="window.location.reload();" class="btn btn-danger" data-bs-toggle="tooltip" title="Solo en caso que requiera">Limpiar</button>
        </div>

        @can('Cerrar_Inventario')

        @endcan

        <div class="table-responsive mt-1" style="overflow-x: auto;">
          <table id="tableInventory" class="table table-success table-striped mt-1">
            <thead class="text-white" style="background: #3B3F5C">
              <tr>
                <th class="table-th text-white" title="Categoria" style="text-align: center;">COD</th>
                <th class="table-th" title="Productos" style="text-align: center;">PRODUCTO</th>
                <th class="table-th" title="Categoria" style="text-align: center;">CAT</th>
                <th class="table-th text-white" title="Cantidades compras lotes" style="text-align: center;">#C_LOTE</th>
                <th class="table-th text-white" title="Costos compras lotes" style="text-align: center;">$C_LOTE</th>
                <th class="table-th text-white" title="Cantidades compras compensadas" style="text-align: center;">#C_COMP</th>
                <th class="table-th text-white" title="Precio compras compensadas" style="text-align: center;">$P_COMP</th>
                <th class="table-th text-white" title="Subtotal compras compensadas" style="text-align: center;">$C_COMP</th>
                <th class="table-th text-white" title="Total cantidades" style="text-align: center;">T#CANT</th>
                <th class="table-th text-white" title="Total costos" style="text-align: center;">T_COSTO</th>
                <th class="table-th text-white" title="Costo promedio" style="text-align: center;">COSTO_P</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th>Totales</th>
                <td>
                  <div class="col-sm-6 col-md-2 mt-3">
                    <a class="btn btn-dark btn-block {{(2) < 1 ? 'disabled' : '' }}" href="{{ url('report_compras_x_prod/excel' . '/' . $dateFrom. '/' . $dateTo) }}" target="_blank">
                      <i class="far fa-file-excel"></i>
                    </a>
                  </div>
                </td>
                <td></td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
              </tr>
            </tfoot>
          </table>
        </div>


      </div>
    </div>
  </div>
  @endsection
  @section('script')
  <script src="{{asset('code/js/reportes/compras-por-productos-index.js')}} " type="module"></script>
  @endsection

  <script>
    // Función para exportar a Excel
    function exportarExcel() {
      const dateFrom = $("#dateFrom").val();
      const dateTo = $("#dateTo").val();
      const url = `../report_compras_x_prod/excel/${dateFrom}/${dateTo}`;
      window.open(url, "_blank");
    }
  </script>